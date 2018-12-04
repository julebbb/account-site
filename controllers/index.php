<?php

// On enregistre notre autoload.
function chargerClasse($classname)
{
    if(file_exists('../models/'. $classname.'.php'))
    {
        require '../models/'. $classname.'.php';
    }
    else 
    {
        require '../entities/' . $classname . '.php';
    }
}
spl_autoload_register('chargerClasse');

$db = Database::DB();

//New manager for account
$accountManager = new AccountManager($db);

//array for display type of account
$arrayAccount = ['Compte courant', 'PEL', 'Livret A', 'Compte joint'];

//variable for display errors
$errorCreate = "";

//**** ADD NEW ACCOUNT ****
if (isset($_POST['name']) AND !empty($_POST['name'])) {
    $name = htmlspecialchars($_POST['name']);
    if (in_array($name, $arrayAccount) AND is_string($name)) {
        if ($accountManager->checkIfExist($name)) {
            $errorCreate = "Vous ne pouvez avoir qu'un seul compte " . $name . " !";
        } else {

            $newAccount = new Account(array(
                'name' => $name
            ));
            
            //Add account in db
            $accountManager->add($newAccount);
            header('index.php');
        }
        
    } else {
        $errorCreate = "Erreur dans le select !";
    }
}


include "../views/indexView.php";
