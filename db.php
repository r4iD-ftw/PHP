<?php
	if(!mysqli_connect("localhost","root","toor","services"))
	{
		echo "<h2>".Error."</h2>";
		die();
	}
	$con=mysqli_connect("localhost","root","toor","services");
?>