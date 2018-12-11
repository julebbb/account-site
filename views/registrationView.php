<?php
include 'includes/header.php';

?>

<main class="container">

	<header class="flex">
		<p class="margin-right">Bienvenue sur l'application Comptes Bancaires</p>
        <a href="connexion.php">Retour à la page connexion</a>
	</header>


    <section class="connexion">

        <h1>Inscription :</h1>

        <form action="registration.php" method="post" class="flex">

        <?php if (!empty($errorRegister)) {?>
        <p class="error-message"><?php echo $errorRegister; ?></p>
        <?php }?>

        <label for="name">Entrez votre prénom :</label>
        <input type="text" name="name" required>

        <label for="email">Entrez votre email :</label>
        <input type="email" name="email" required>

        <label for="password">Entrez votre mot de passe :</label>
        <input type="password" name="password" required>

        <label for="pass_retry">Entrez une nouvelle fois votre mot de passe :</label>
        <input type="password" name="pass_retry" required>

        <input type="submit" value="Envoyer">

        </form>

    </section>


</main>

<?php
include 'includes/footer.php';
?>