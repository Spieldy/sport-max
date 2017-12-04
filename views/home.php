<?php

if (user_connected()) {
	$user = User::get_by_login($_SESSION['user']);
	if ($user->state() != NULL) {
		$state = $user->state();
		include "views/custom_home.php";
	} else {  
		include "views/state_form.php";
	}
} else { ?>

<div class="jumbotron">
  <h1 class="display-4">All the information you need at the first sight !</h1>
  <p class="lead">If you want to customize your homepage, it's easy !  You only need to create on account so we can save your display preference.</p>
  <hr class="my-4">
  <p>Create on account or sign in if you already have one.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="<?=BASEURL?>index.php/user/signup" role="button">Sign up</a>
    <a class="btn btn-secondary btn-lg" href="<?=BASEURL?>index.php/user/signin" role="button">Login</a>
  </p>
</div>

 <?php } ?>