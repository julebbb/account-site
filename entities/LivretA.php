<?php

declare(strict_types = 1);

class LivretA extends Account
{   
    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array) {
        parent::hydrate($array);
    }
}