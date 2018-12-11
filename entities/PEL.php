<?php

declare(strict_types = 1);

/**
 * PEL class
 */
class PEL extends Account
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