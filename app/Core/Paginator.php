<?php

namespace App\Core;

class Paginator
{
    public int $page;
    public int $perPage;
    public int $total;

    public function __construct(int $page, int $perPage, int $total)
    {
        $this->page = max(1, $page);
        $this->perPage = $perPage;
        $this->total = $total;
    }

    public function offset(): int
    {
        return ($this->page - 1) * $this->perPage;
    }

    public function totalPages(): int
    {
        return (int) ceil($this->total / $this->perPage);
    }
}
