<html>
<?php
include('db.php');
session_start();
$userid=$pass=$status="";
if($_SERVER['REQUEST_METHOD']=="POST")
{	
	
	$userid=testinput($_POST['userid']);
	$pass=md5(testinput($_POST['pass']));
	$query=mysqli_query($con,"SELECT * from users WHERE (userid='$userid' or emailid='$userid') and passhash='$pass';");
	$row=mysqli_fetch_array($query);
	$count=mysqli_num_rows($query);
	if($count==1)
	{
		$_SESSION['login_user']=$row['userid'];
		//$status = "Login Successful! Welcome ".$row['emailid'];
		header("Location: account.php");
	}
	else
	{
		$status = "Login Error ";
	}
}
function testinput($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<head>
<title>Login</title>
<link rel=stylesheet type="text/css" href="default.css">
</head>
<body>
<h1 id=header>Login</h1>
<ul>
	<li><a href="welcome.html" class="nav">Home</a></li>
	<li><a href="login.php" class="nav">Login</a></li>
	<li><a href="createacc.php" class="nav">Sign Up</a></li>
</ul><br>
<hr><br>
<form method=post action="<?php print htmlspecialchars($_SERVER['PHP_SELF']);?>">
<table border=0px id=form align=center>
	<tr>
		<td colspan=2 align=center><span id=error><?php print $status;?></span></td>
	</tr>
	<tr>
		<td>Userid/Email-Id: </td>
		<td><input type=text name="userid" id=text></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type=password name="pass" id=text></td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type=submit id=submitButton value="Log In"></td>
	</tr>
</table>

</form>
</body>
</html>