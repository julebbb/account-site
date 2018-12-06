<?php

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

$userManager = new UserManager($db);

$errorRegister = "";

// **** ADD USER ****
if (isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['password'])
AND !empty($_POST['name']) AND !empty($_POST['email']) AND !empty($_POST['password'])) {
    # code...
}


include "../views/registrationView.php";
?>