<?php 

if (user_connected()) { ?>
<div class="row">
	<h3>Settings</h3>
	<form>
	  <div class="form-group">
	    <label for="exampleSelect1">Favourite sport</label>
	    <select class="form-control" id="exampleSelect1">
	      <option>Auncune préférence</option>
	      <option>NHL</option>
	      <option>MLS</option>
	      <option>NFL</option>
	      <option>NBA</option>
	    </select>
	  </div>
	  <div class="form-group">
	    <label for="exampleSelect1">What are your looking for on a sport website?</label>
	    <select class="form-control" id="exampleSelect1">
	      <option>Aucune préférence</option>
	      <option>Scoring</option>
	      <option>Calendar</option>
	      <option>Results</option>
	      <option>Teams</option>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>
	
<?php
} else {
	include 'views/signin.php';
}
?>