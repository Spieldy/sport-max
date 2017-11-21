<h2>Page de profil</h2>
<h4>Login : <?php echo $_SESSION['user'] ?></h4>
<h4>Email : <?php echo $emailProfil ?></h4>

<form method="post" action="index.php?action=profil">
	<h3>Modifier le login</h3>
	<label for="login">Modifier login</label>
	<input type="text" id="updateLogin" name="updateLogin">
	<label for="verification">Verification mot de passe</label>	
	<input type="password" id="updatePassword" name="updatePassword"></br>
	<h3>Modifier le mot de passe</h3>
	<label for="lastPassword">Ancien mot de passe</label> 	
	<input type="password" id="lastPassword" name="lastPassword">
	<label for="lastPassword">Nouveau mot de passe</label> 	
	<input type="password" id="newPassword" name="newPassword"> </br>
	<h3>Modifier l'email</h3>
	<label for="updateEmail">Nouvel email</label> 	
	<input type="updateEmail" id="updateEmail" name="updateEmail">
	<label for="update2Password">Verification mot de passe</label> 	
	<input type="update2Password" id="update2Password" name="update2Password"> </br> </br>
	<input type="submit">
</form>