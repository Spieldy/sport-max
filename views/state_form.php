<?php 

if (user_connected()) { ?>
<div class="row">
	<div class="col"></div>

	<div class="col-md-4">
		<form method="post" action="<?=BASEURL?>/index.php/user/change_state">
		  <h2 class="form-signin-heading">Settings</h2>
		  <div class="form-group">
		    <label for="exampleSelect1">What is your favourite sport</label>
		    <select class="form-control" name="sport_state" id="sport_state">
		      <option value="1">NHL</option>
		      <option value="2">MLS</option>
		      <option value="3">NFL</option>
		      <option value="4">NBA</option>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="exampleSelect1">What are you looking for on a sport website?</label>
		    <select class="form-control" name="display_state" id="display_state">
		      <option value="1">Standing</option>
		      <option value="2">Calendar</option>
		      <option value="3">Results</option>
		      <option value="4">Teams</option>
		    </select>
		  </div>
		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>

	<div class="col"></div>
</div>
	
<?php
} else {
	include 'views/signin.php';
}
?>