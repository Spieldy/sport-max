<!-- <div class="signup">
	<div class="signup-card">
		<form method="post" action="<?=BASEURL?>/index.php/user/signup">

		<div class="formline-login">
			<input type="text" id="login" placeholder="Login" name="login">
		</div>
		<div class="formline-password">
			<input type="password" id="password" placeholder="Mot de passe" name="password">
		</div>
		<div class="formline-confirm">
			<input type="password" id="password_check" placeholder="Confirmation mot de passe" name="password_check">
		</div>
		<div class="formline-btn">
			<input type="submit" value="S'inscrire">
		</div>
		</form>
		<a href="<?=BASEURL?>/index.php/user/signin">Déjà membre?</a>
	</div>
</div> -->


<div class="row">
	<div class="col"></div>

	
	<div class="col-md-3">
		<form class="form-signin" method="post" action="<?=BASEURL?>/index.php/user/signup" id="signup-form">
			<h2 class="form-signin-heading">Create an account</h2>
			<label for="inputLogin" class="sr-only">Login</label>
			<input type="text" id="login" name="login" class="form-control" placeholder="Login" name="login" required="" autofocus="">
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
			<label for="inputPassword" class="sr-only">Confirm password</label>
			<input type="password" id="password_check" name="password_check" class="form-control" placeholder="Confirm password" required="">
			<button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>

			<a href="<?=BASEURL?>/index.php/user/signin">Already an account</a>
		</form>
	</div>


	<div class="col"></div>
</div>