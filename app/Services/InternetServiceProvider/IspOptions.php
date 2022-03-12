<?php

namespace App\Services\InternetServiceProvider;

class IspOptions
{
    public $operator;
    
    public $month;

    public $monthlyFees;

    public function __construct($month, $monthlyFees)
    {
        $this->month = $month;
        $this->monthlyFees = $monthlyFees;
    }

    public static function setMonth(int $month)
    {
        $this->month = $month;
    }

    public function calculateTotalAmount()
    {
        return $this->month * $this->monthlyFees;
    }
}