<?php

declare(strict_types = 1);

class CompteCourant extends Account
{
    protected $balance = 80;


    public function __construct(array $array) {
        parent::hydrate($array);
    }
}