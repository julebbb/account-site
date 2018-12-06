<?php

declare(strict_types = 1);

abstract class Account
{

    protected $id,
              $name,
              $balance = 0,
              $id_user;

    /**
     * Construct
     *
     * @param array $array
     * @return void
     */
    public function __construct(array $array) 
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

    /**
     * Get the value of id_user
     */ 
    public function getId_user()
    {
        return $this->id_user;
    }

    //SETTER

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = (int) $id;

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
    public function setBalance( $balance)
    {
                $this->balance = (int) $balance;

                return $this;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */ 
    public function setId_user($id_user)
    {
        $this->id_user = (int) $id_user;

        return $this;
    }


    //Method

    public function credit(int $credit) {
        $balance = $this->getBalance();

        $result = $balance + $credit;


        $this->setBalance($result); 
    }

    public function debit(int $debit) {
        $balance = $this->getBalance();

        $result = $balance - $debit;

        $this->setBalance($result);
    }
}
