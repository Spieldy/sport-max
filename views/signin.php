<?php
/**
* \file      views/signin.php
* \author    Jérémy Spieldenner
* \version   2.0
* \date      20 Octobre 2014
* \brief     Affiche le formulaire de connexion
*
* \details   La vue permet à l'utilisateur de se connecter à l'aide de son login et son mot de passe. Il y un lien vers la page d'inscription si l'utilisateur n'est pas inscrit.
*/
?>


<div class="top-bar">
	<p> Se connecter </p>
</div>



<div class="signin">

	<div class="signin-card">
		<form method="post" action="<?=BASEURL?>/index.php/user/signin" id="signin-form">
		<div class="formline-login">

			<input type="text" id="login" placeholder="Login" name="login">
		</div>
		<div class="formline-password">
			<input type="password" id="password" placeholder="Mot de passe" name="password">
		</div>
		<div class="formline-btn">
			<input type="submit" value="Se connecter">
		</div>
		</form>

		<a href="<?=BASEURL?>/index.php/user/signup">Créer un compte</a>
	</div>


</div>
