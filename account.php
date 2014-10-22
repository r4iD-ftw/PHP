<?php
	include('db.php');
	session_start();
	$status="";
	$user=$_SESSION['login_user'];
	$ses=mysqli_query($con,"SELECT userid FROM users where userid='$user'");
	$row=mysqli_fetch_array($ses);
	$login_session=$row['userid'];
	if(!isset($login_session))
		header("Location: login.php");
	$hash="";
	$no=0;
	if($_SERVER['REQUEST_METHOD']=="POST")
		if($_POST['submit']=="Generate Unique Link")
		{
			$query=mysqli_query($con,"SELECT * FROM downloads where userid='$login_session'");
			if(mysqli_num_rows($query)==1)
			{
				$row=mysqli_fetch_array($query);
				if($row['no']>=1)
				{	
					$hash=$row['link'];
					$no=$row['no'];
					$status =  $row['no']." download(s) remaining";
				}
				else
				{
					$status="No Downloads Remaining. Enter Max No. of Downloads";
					if(!empty($_POST['no']))
					{
						$hash=md5(date(" j m y H i s"));
						$no=$_POST['no'];
						$query=mysqli_query($con,"UPDATE downloads SET link='$hash' , no='$no' where userid='$login_session'");
					}
				}
			}
			else
			{
				if(!empty($_POST['no']))
				{
					$no = $_POST['no'];
					$hash=md5(date(" j m y H i s"));
					$query=mysqli_query($con,"INSERT INTO downloads(userid,link,no) VALUES('$login_session','$hash','$no')");
				}
				else
					$status = "Enter Max No. of Downloads";
			}
		}
?>
<html>
<head>
<title>Welcome <?php echo $login_session;?></title>
<link rel=stylesheet type="text/css" href="default.css">
</head>
<body>
<h1 id=header>Your Account</h1>
<ul>
	<li><a href="welcome.html" class="nav">Home</a></li>
	<li><a href="login.php" class="nav">Login</a></li>
	<li><a href="createacc.php" class="nav">Sign Up</a></li>
	<li><a href="logout.php" class="nav">LogOut</a></li>
</ul><br><hr>
<p>
<form action="<?php print htmlspecialchars($_SERVER['PHP_SELF']);?>" method=post style="position:absolute;left:500px;top:200px;" id=form>
	Unique Link: <input type=text name=hash id=text align=center style="width:300px;" value="<?php print $hash;?>"><br><br>
	Max No. of Downloads: <input type=text name=no id=text align=center style="width:300px;" value=""><br><br>
	<input type=submit id=submitButton value="Generate Unique Link" name=submit><br><br>
	<span id=error><?php print $status;?></span>
</form>
</p>
<table border=1 align=center>
	<tr>
		<th>Unique Link</th>
		<th>Max No. Of Downloads</th>
	</tr>
	<tr>
		<td><a href="<?php print "download.php?link=".$hash;?>">Link</a></td>
		<td><?php print $no;?></td>
	</tr>
</table>
</body>
</html>
<?php
  
 ?>