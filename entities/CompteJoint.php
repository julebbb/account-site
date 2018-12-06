<?php

declare(strict_types = 1);

class CompteJoint extends Account
{

    public function __construct(array $array) {
        parent::hydrate($array);
    }
}