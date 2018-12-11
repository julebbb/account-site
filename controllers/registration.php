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

//Create database
$db = Database::DB();

//New manager user
$userManager = new UserManager($db);

//Variable error
$errorRegister = "";

// **** ADD USER ****
if (isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['password'])) 
{
 
    if(!empty($_POST['name']) AND !empty($_POST['email']) AND !empty($_POST['password'])) 
    {
        //Secure post and hash password
        $name = strip_tags($_POST['name']);
        $password = strip_tags($_POST['password']);
        $pass_retry= strip_tags($_POST['pass_retry']);
        $email = strip_tags($_POST['email']);
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        if ($userManager->checkIfExist($email)) 
        {
            //Check if email use
            $errorRegister = "Email déjà utilisé !";
        } 
        else 
        {
           
            if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email) == true) 
            {
                //Check if email if a email with regex and check if two password are the same
                if ($password == $pass_retry) 
                {
                    //Create object and in database
                    $user = new User([
                        'name' => $name,
                        'password' => $pass_hash,
                        'email' => $email
                    ]);

                    $userManager->add($user);

                    //Redirect
                    header('Location: connexion.php');

                }
            } 
            else 
            {
                $errorRegister = "L'email est incorrect !";
            }
        }
    } 
    else 
    {
        $errorRegister = "Les champs ne sont pas tous remplis !";
    }

}


include "../views/registrationView.php";
?>