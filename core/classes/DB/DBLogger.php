<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use Error;

class DBLogger
{
    private string $filepath;
    private string $archivedfilepath;
    private int $threshold;
    private DBHandler $dbh;
    private bool $clean = false;

    private function __construct(DBHandler $dbh, bool $clean = false)
    {
        $this->dbh = $dbh;
        $this->clean = $clean; 
    }

    /**
     * Open a new logger
     *
     * @param DBHandler $dbh
     * @param boolean $clean TRUE creates a logger file if it does not exist
     * @param DBLogger|null $log
     * @return DBLogger
     */
    public static function open(DBHandler $dbh, bool $clean = false, ?DBLogger &$log = null) : DBLogger {

        $log = new static($dbh, $clean);
        return $log;

    }

    /**
     * Generates a configuration file.
     *
     * @param string $filepath
     * @param integer $threshold
     * @return void
     */
    public function config(string $filepath, int $threshold = 1) : void {
        $this->filepath = $filepath; 
        $this->threshold = $threshold;
        $this->archivedfilepath = str_replace('.log', '_' . date('Y-m-d_H-i-s') . '.log', $filepath);

        if(!Filemanager::createFile($filepath, ['clean' => $this->clean])){
            throw new Error('Logger file creation error');
        }
    }

    /**
     * Renames a log file to archive it. 
      *  - The archived log file will have a timestamp appended to its name to prevent overwriting existing logs.   
     *
     * @return boolean 
     *  - Returns true if the log file was successfully archived, false otherwise. 
      * - The log file will be renamed with a timestamp to prevent overwriting existing logs.
     */
    public function archiveLog() : bool {
        if (file_exists($this->filepath) && filesize($this->filepath) > 0) {
            if (rename($this->filepath, $this->archivedfilepath)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Removes all logs from the log file. 
     *  - Warning: Use with caution as this will permanently delete all log entries.
     *
     * @return void
     */
    public function clearLog() : void {
        if (file_exists($this->filepath)) {
            file_put_contents($this->filepath, '');
        }
    }

    public function addLog() : float {
        if ($this->dbh === false) {
            throw new Error('DBHandler is not available');
        }

        $metrics = $this->dbh->metrics();
        $runtime = $metrics['runtime'] ?? 0;
        $sql = $metrics['sql'] ?? '';

        if (!isset($this->filepath)) {
            throw new Error('Logger must be configured with config() before adding logs');
        }

        // Write query log to file
        $logEntry = $this->formatLogEntry($sql, $runtime);
        file_put_contents($this->filepath, $logEntry, FILE_APPEND);

        // Send alert if threshold exceeded
        if ($runtime > $this->threshold) {
            $this->sendAlert($sql, $runtime);
        }

        return $runtime;
    }

    private function formatLogEntry(string $sql, float $runtime) : string {
        $timestamp = date('Y-m-d H:i:s');
        $status = ($runtime > $this->threshold) ? '[SLOW]' : '[OK]';
        return sprintf(
            "[%s] %s - Runtime: %.4f sec\nSQL: %s\n%s\n",
            $timestamp,
            $status,
            $runtime,
            $sql,
            str_repeat('-', 80)
        );
    }

    public function analyzeQuery(string $query) : array {
        if ($this->dbh === false) {
            throw new Error('DBHandler is not available');
        }

        $explainQuery = "EXPLAIN " . $query;
        $this->dbh->query($explainQuery);
        $results = $this->dbh->results();

        if (empty($results)) {
            throw new Error('Failed to analyze query');
        }

        return $results;
    }

    private function sendAlert(string $query, float $executionTime) : void {
        $message = sprintf(
            "Critical Alert: Query exceeded threshold of %.2f seconds.\n"
            . "Execution Time: %.4f seconds\n"
            . "SQL: %s",
            $this->threshold,
            $executionTime,
            $query
        );
        
        // Log alert to separate file
        $alertFile = str_replace('.log', '_alerts.log', $this->filepath);
        $alertEntry = sprintf(
            "[%s] %s\n%s\n",
            date('Y-m-d H:i:s'),
            $message,
            str_repeat('-', 80)
        );
        file_put_contents($alertFile, $alertEntry, FILE_APPEND);
        
        // Optionally send email
        // mail('admin@example.com', 'Critical Slow Query Detected', $message);
    }
}

// $dbh = (new DB)->openDB();

// DBLogger::open($dbh, $logger)->config(); 

// $dbh->onCRUD(function(DBHandler $dbh, $method) use($logger) {

//     $metrics = $dbh->metrics();
//     $log->createNewLog($dbh);

// });

// // Example usage
// $log->clearLog();
// $logger = new DBLogger()

// $logger->archiveLog();
// $logger->clearLog();

// // Example queries
// $query1 = "SELECT SLEEP(2);"; // Simulate a slow query
// $query2 = "SELECT * FROM large_table WHERE column = 'value';"; // Example query

// $logger->analyzeQuery($query1);

// $logger->analyzeQuery($query2);

// $logger->closeConnection();

