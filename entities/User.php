<?php

declare(strict_types = 1);

class User {

    protected $id,
              $name,
              $password,
              $email;

    /**
     * Constructor
     *
     * @param array $array
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

    
    //*** SETTER ***
    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
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
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
                $this->password = $password;

                return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
                $this->email = $email;

                return $this;
    }

    //*** GETTER ***/
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
     * Get the value of password
     */ 
    public function getPassword()
    {
                return $this->password;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
                return $this->email;
    }
}
?>