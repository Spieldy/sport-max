<div class="row">
	<div class="col"></div>

	
	<div class="col-md-3">
		<form class="form-signin" method="post" action="<?=BASEURL?>/index.php/user/signin" id="signin-form">
			<h2 class="form-signin-heading">Please sign in</h2>
			<label for="inputLogin" class="sr-only">Login</label>
			<input type="text" id="login" class="form-control" placeholder="Login" name="login" required="" autofocus="">
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<a href="<?=BASEURL?>/index.php/user/signup">Create an account</a>
		</form>
	</div>


	<div class="col"></div>
</div>