<?php

declare(strict_types = 1);

class LivretA extends Account
{
    protected $count = 0;

    public function __construct(array $array) {
        parent::hydrate($array);
    }

     public function credit(int $credit) {
        $balance = $this->getBalance();

        if ($this->getName() === "Livret A" AND $count === 0) {
            $credit = $credit * 2.5/100;
            $count = $count + 1;
        }
        
        $result = $balance + $credit;


        $this->setBalance($result); 
    }
}