<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\DB;
use SessionHandlerInterface;
use SessionUpdateTimestampHandlerInterface;

/**
 * Keeps sessions in a database table rather than on the filesystem.
 *
 * The filesystem handler PHP ships with is faster — a local write beats a query
 * over a socket every time — so this is not a performance change. What it buys is
 * a session that does not belong to one machine: several web servers behind a load
 * balancer share one table, and a user stops being logged out at random as requests
 * land on different hosts. It also makes sessions something you can look at, which
 * is what "sign this account out everywhere" needs.
 *
 * Registered through {@see \Session::attachHandler()}; it is not used unless the
 * SESSION_HANDLER init key names it.
 *
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class DBSessionHandler implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface
{

    /**
     * Table holding the sessions.
     *
     * @var string
     */
    public static string $table = 'sessions';

    private ?DBHandler $db = null;

    /**
     * Whether the table has been looked for this request.
     *
     * @var bool
     */
    private bool $checked = false;

    public function __construct()
    {
        $dbm = new DB();
        $this->db = $dbm->openDB();
    }

    /* ----------------------------------------------------------------- *
     *  Lifecycle                                                         *
     * ----------------------------------------------------------------- */

    public function open(string $path, string $name): bool
    {
        return $this->db !== null;
    }

    public function close(): bool
    {
        return true;
    }

    /**
     * Read a session back.
     *
     * An expired row is treated as absent rather than deleted here, because a read
     * is not the place to write. The sweep in gc() clears them.
     *
     * @param string $id
     * @return string|false
     */
    public function read(string $id): string|false
    {
        if(!$this->ready()) return '';

        $table = self::$table;

        $this->db->query(
            "SELECT `payload` FROM `{$table}` WHERE `id` = ? AND `expires_at` > ?",
            [$id, time()]
        );

        $row = $this->db->read()? $this->db->results(0) : false;

        // an absent session is an empty one, never a failure — PHP starts a fresh session
        return is_array($row)? (string) ($row['payload'] ?? '') : '';
    }

    /**
     * Write a session.
     *
     * Uses the upsert MySQL provides rather than a SELECT followed by an INSERT or
     * an UPDATE, so two requests from one visitor arriving together cannot both find
     * the row missing and both try to create it.
     *
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write(string $id, string $data): bool
    {
        if(!$this->ready()) return false;

        $table   = self::$table;
        $expires = time() + $this->lifetime();

        return $this->db->query(
            "INSERT INTO `{$table}` (`id`, `payload`, `expires_at`, `updated_at`)
             VALUES (?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                `payload`    = VALUES(`payload`),
                `expires_at` = VALUES(`expires_at`),
                `updated_at` = VALUES(`updated_at`)",
            [$id, $data, $expires, time()]
        )->process();
    }

    /**
     * Push a session's expiry forward without rewriting its contents.
     *
     * PHP calls this instead of write() when a request read the session but changed
     * nothing, which is most of them. Answering it here keeps an active visitor from
     * being logged out while sparing the table the full payload write.
     *
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function updateTimestamp(string $id, string $data): bool
    {
        if(!$this->ready()) return false;

        $table = self::$table;

        return $this->db->query(
            "UPDATE `{$table}` SET `expires_at` = ?, `updated_at` = ? WHERE `id` = ?",
            [time() + $this->lifetime(), time(), $id]
        )->process();
    }

    /**
     * Whether a session id already exists.
     *
     * With session.use_strict_mode on, PHP asks this before adopting an id, and
     * answering it correctly is what stops an id the server never issued from being
     * accepted. Returning a blind TRUE here would undo that protection.
     *
     * @param string $id
     * @return bool
     */
    public function validateId(string $id): bool
    {
        if(!$this->ready()) return false;

        $table = self::$table;

        $this->db->query(
            "SELECT `id` FROM `{$table}` WHERE `id` = ? AND `expires_at` > ?",
            [$id, time()]
        );

        return $this->db->read()? is_array($this->db->results(0)) : false;
    }

    public function destroy(string $id): bool
    {
        if(!$this->ready()) return true;

        $table = self::$table;

        return $this->db->query("DELETE FROM `{$table}` WHERE `id` = ?", [$id])->process();
    }

    /**
     * Clear sessions that have expired.
     *
     * @param int $max_lifetime
     * @return int|false
     */
    public function gc(int $max_lifetime): int|false
    {
        if(!$this->ready()) return 0;

        $table = self::$table;

        // expires_at is already absolute, so $max_lifetime is not applied a second time
        return $this->db->query("DELETE FROM `{$table}` WHERE `expires_at` < ?", [time()])->process()? 1 : 0;
    }

    /* ----------------------------------------------------------------- *
     *  Storage                                                           *
     * ----------------------------------------------------------------- */

    /**
     * Session lifetime in seconds, taken from PHP's own setting so that the table
     * and the cookie agree on when a session has ended.
     *
     * @return int
     */
    private function lifetime() : int {

        return (int) (ini_get('session.gc_maxlifetime') ?: 1440);

    }

    /**
     * Whether the table is there to be used, creating it on first use.
     *
     * @return bool
     */
    private function ready() : bool {

        if($this->db === null) return false;
        if($this->checked) return true;

        $this->checked = true;

        $table = self::$table;

        if($this->db->table_exists($table)) return true;

        /* Created on demand rather than by migration, because a session store has to
           exist before the application can serve its first request — there is no
           point in the boot sequence where a migration could be relied upon to have
           run. The id length matches PHP's longest session id. */
        return $this->db->query(
            "CREATE TABLE IF NOT EXISTS `{$table}` (
                `id` VARCHAR(128) NOT NULL,
                `payload` MEDIUMTEXT NOT NULL,
                `expires_at` INT UNSIGNED NOT NULL,
                `updated_at` INT UNSIGNED NOT NULL,
                PRIMARY KEY (`id`),
                KEY `expires_at` (`expires_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        )->process();

    }

}
