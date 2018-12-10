<?php

declare(strict_types = 1);

/**
 * CompteCourant
 */
class CompteCourant extends Account
{
    protected $balance = 80;

    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array) {
        parent::hydrate($array);
    }
}