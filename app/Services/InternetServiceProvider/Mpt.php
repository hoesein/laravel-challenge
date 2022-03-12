<?php

namespace App\Services\InternetServiceProvider;

use App\Services\InternetServiceProvider\IspOptions;

class Mpt
{

    protected $options;

    // protected $operator = 'mpt';
    
    // protected $month = 0;
    
    // protected $monthlyFees = 200;

    public function __construct(IspOptions $options){
        $this->options = $options;
    }
    
    // public function setMonth(int $month)
    // {
    //     $this->month = $month;
    // }
    
    // public function calculateTotalAmount()
    // {
    //     return $this->month * $this->monthlyFees;
    // }

    public function diCalculateTotalAmount()
    {
        return $this->options->month * $this->options->monthlyFees;
    }
}