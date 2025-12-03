<?php

namespace App\Traits;

trait DateScope
{
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeYesterday($query)
    {
        return $query->whereDate('created_at', today()->subDay());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    public function scopeLastWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek(),
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ]);
    }

    public function scopeLastMonth($query)
    {
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        return $query->whereBetween('created_at', [
            $lastMonthStart,
            $lastMonthEnd,
        ]);
    }
}
