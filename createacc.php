<html>
<head>
<title>Sign Up</title>
<link rel=stylesheet type="text/css" href="default.css">
</head>
<?php
include('db.php');
$passError=$status=$useridError=$emailidError=$conpassError="";
$userid=$pass=$emailid=$con_pass="";
$chk[0]=0;
$chk[1]=0;
$chk[2]=0;
$chk[3]=0;
if($_SERVER['REQUEST_METHOD']=="POST")
{
	if(empty($_POST['userid']))
	{	$useridError = "User id Required";
		$chk[0]=1;
	}
	else
	{
		$userid=$_POST['userid'];
		$userid=testinput($userid);
		if (!preg_match("/^[a-zA-Z0-9 ]*$/",$userid)) 
		{
			$useridError = "Only letters, numbers and white space allowed";
			$chk[0]=1;
		}
	}
	if(empty($_POST['pass']))
	{
		$passError="Password Required";
		$chk[1]=1;
	}
	else
		$pass=$_POST['pass'];
	
	if(empty($_POST['con_pass']))
	{
		$conpassError="Required";
		$chk[2]=1;
	}
	else
		$con_pass=$_POST['con_pass'];
	
	if(empty($_POST['emailid']))
	{
		$emailidError="Email Id Required";
		$chk[3]=1;
	}
	else
	{
		$emailid=$_POST['emailid'];
		$emailid=testinput($emailid);
		if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) 
		{
			$emailidError = "Invalid email format";
			$chk[3]=1;
		}
	}
	for($x=0;$x<4;$x++)
		if($chk[$x]==1)
			break;
	if(strcmp($pass,$con_pass)==0 && $x==4)
	{
		$query=mysqli_query($con,"SELECT * from users WHERE userid='$userid' or emailid='$emailid';");
		$row=mysqli_fetch_array($query);
		$count=mysqli_num_rows($query);
		if($count!=0)
				$status =  "Someone has already registered with this Email/Userid";
		else
		{
			$passhash=md5($pass);
			$query=mysqli_query($con,"INSERT INTO users(emailid,userid,pass,passhash) VALUES('$emailid','$userid','$pass','$passhash')");
			$status = "Success! You can now login <a href ='login.php'>here</a>";
		}
	}
	else
	{
		$conpassError="Passwords don't Match";
	}
}
function testinput($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<body>
<h1 id=header>Sign Up</h1>
<ul>
	<li><a href="welcome.html" class="nav">Home</a></li>
	<li><a href="login.php" class="nav">Login</a></li>
	<li><a href="createacc.php" class="nav">Sign Up</a></li>
</ul><br><hr>
<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']);?>"  method=post>
<table id=form align=center>
<tr>
	<td colspan=3 align=center><span id=error>* Required</span></td>
</tr>
<tr>
	<td>Email Id :</td>
	<td><input type=text name="emailid" value="<?php print $emailid;?>" id=text></td>
	<td><span id=error>*<?php print $emailidError;?></span></td>
</tr>
<tr>
	<td>User Id :</td>
	<td><input type=text name="userid" value="<?php print $userid;?>" id=text></td>
	<td><span id=error>*<?php print $useridError;?></span></td>
</tr>
<tr>
	<td>Password :</td>
	<td><input type=password name="pass" value="<?php print $pass;?>" id=text></td>
	<td><span id=error>*<?php print $passError;?></span></td>
</tr>
<tr>
	<td>Confirm Password :</td>
	<td><input type=password name="con_pass" value="<?php print $con_pass;?>" id=text></td>
	<td><span id=error>* <?php print $conpassError;?></span></td>
</tr>
<tr>
	<td colspan=3 align=center><input type=submit value="Create Account" id=submitButton></td>
</tr>
<tr>
	<td colspan=3 align=center><b><?php print $status;?></b></td>
</tr>
</table>
</form>
</body>
</html>
