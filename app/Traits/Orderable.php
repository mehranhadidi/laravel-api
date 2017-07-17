<?php

namespace App\Traits;

trait Orderable
{
    /**
     * Sort a query result by latest first
     *
     * @param $query
     * @return collection
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Sort a query result by oldest first
     *
     * @param $query
     * @return collection
     */
    public function scopeOldestFirst($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}