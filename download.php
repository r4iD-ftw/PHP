<?php
	include('db.php');
	$link = $_GET['link'];
	$query=mysqli_query($con,"Select * from downloads where link='$link'");
	if(mysqli_num_rows($query)==1)
	{
		$row=mysqli_fetch_array($query);
		if($row['no']>=1)
			$query=mysqli_query($con,"UPDATE downloads SET no=no-1 where link='$link'");
		else
			print "Invalid Link";
	}
	else
		print "Invalid Link";
?>