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
if (isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['password'])) {
 
    if(!empty($_POST['name']) AND !empty($_POST['email']) AND !empty($_POST['password'])) {
        $name = strip_tags($_POST['name']);
        $password = strip_tags($_POST['password']);
        $pass_retry= strip_tags($_POST['pass_retry']);
        $email = strip_tags($_POST['email']);
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        if ($userManager->checkIfExist($email)) {
            $errorRegister = "Email déjà utilisé !";
        } else {
           
            if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email) == true) {
                if ($password == $pass_retry) {
                    $user = new User([
                        'name' => $name,
                        'password' => $pass_hash,
                        'email' => $email
                    ]);

                    $userManager->add($user);

                    header('Location: connexion.php');

                }
            } else {
                $errorRegister = "L'email est incorrect !";
            }
        }
    } else {
        $errorRegister = "Les champs ne sont pas tous remplis !";
    }

}


include "../views/registrationView.php";
?>