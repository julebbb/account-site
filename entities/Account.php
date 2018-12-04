<?php

declare(strict_types = 1);

class Account
{

    protected $id,
              $name,
              $balance;

    /**
     * Construct
     *
     * @param array $array
     * @return void
     */
    public function __conctruct(array $array) 
    {
        $this->hydrate($array);
    }

    /**
     * Hydration
     *
     * @param array $donnees
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
                
            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

    //GETTER

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
                return $this->name;
    }

    /**
     * Get the value of balance
     */ 
    public function getBalance()
    {
                return $this->balance;
    }

    //SETTER

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
                $this->name = $name;

                return $this;
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */ 
    public function setBalance( int $balance)
    {
                $this->balance = $balance;

                return $this;
    }
}
