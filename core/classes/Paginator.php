<?php

namespace spoova\mi\core\classes;

use InvalidArgumentException;
use spoova\mi\core\classes\DB\DBMediators;
use spoova\mi\core\classes\DB\DBViewer;

class Paginator
{
    private DBViewer $items;
    private int $total;
    private int $perPage;
    private int $currentPage;
    private int $lastPage;

    public function __construct(DBMediators $query, int $perPage = 15, ?int $page = null)
    {
        if($perPage < 1){
            throw new InvalidArgumentException('perPage must be greater than zero');
        }

        $this->perPage = $perPage;
        $this->currentPage = max(1, $page ?? (int) ($_GET['page'] ?? 1));
        $this->total = $query->count();
        $this->lastPage = max(1, (int) ceil($this->total / $this->perPage));
        $offset = ($this->currentPage - 1) * $this->perPage;
        $this->items = $query->read([], [$offset, $this->perPage]);
    }

    public function items() : DBViewer { return $this->items; }
    public function total() : int { return $this->total; }
    public function perPage() : int { return $this->perPage; }
    public function currentPage() : int { return $this->currentPage; }
    public function lastPage() : int { return $this->lastPage; }
    public function hasMorePages() : bool { return $this->currentPage < $this->lastPage; }
    public function hasPages() : bool { return $this->lastPage > 1; }

    public function meta() : array
    {
        return [
            'total' => $this->total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'from' => $this->total ? (($this->currentPage - 1) * $this->perPage) + 1 : null,
            'to' => $this->total ? min($this->currentPage * $this->perPage, $this->total) : null,
            'has_more_pages' => $this->hasMorePages(),
        ];
    }
}