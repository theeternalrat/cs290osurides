<?php include("_header.php"); ?>
	<div class="info">
		<h1>OSU Rides</h1>
		<p>We are a team of student programmers currently working on completing a website for our CS 290 course. Our group consists of: Ryan Atkinson, Samuel Morey, Takumi Crary, Rebecca Farnham, Charles Koll, and Annie Lei. We hope you enjoy our site!</p>
	</div> 
	<div><input type="button" class="do_things_button" onclick="location.href='browse.php';" value="Find a Ride" /></div>
	<div><input type="button" class="do_things_button" onclick="location.href='start_carpool.php';" value="Make a Ride" /></div>
	<div><img src="imgs/filler.jpg" alt="example map" class="image"></div>
<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("mainpage").className += "active";
	});
</script>
<?php include("_footer.php"); ?>
