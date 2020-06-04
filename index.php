
<?php
include "header2.php";
?>





<?php session_start();

$conn = new mysqli("localhost","root","","karten");

$msg="";
// login
if(isset($_POST['verzenden'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	
	
	$sql = "SELECT * 
	FROM personeel where Email= ? and Wachtwoord=? 
	AND Rolnaam=?  
	left join rollen.Rolid = personeel.Personeelid
	";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("sss", $email,$password, $user);
	$stmt-execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	
	session_regenerate_id(); // will replace the current session id with a new one and keep the current session information

$_SESSION['email'] = $row['email'];
$_SESSION['role'] = $row['Rol'];
session_write_close();

if($result->num_rows==1 && $_SESSION['role']=="personeel"){
	header("location:personeel.php");
}
else if($result->num_rows==1 && $_SESSION['role']=="admin"){
	header("location:admin.php");
}
else{
	$msg = "Email or password is incorrect";
}


}

 ?>
<html>
<head>
	<title>Login</title>
	
	
	
</head>

<body>
<a href="index.php">Login</a> <br />


<?php
include("dbco.php");
?>



	<form name="form1" method="post" action="header.php">
		<table width="75%" border="0">
			
			<tr> 
				<td>Email</td>
				<td><input type="text" name="email"></td>
			</tr>			
			
				<td>Password</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr> 
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="Submit"></td>
			</tr>
		</table>
	</form>
	


	<form name="form1" method="post" action="cursus.php">
		<table width="75%" border="0">
			
			<tr> 
				<td>Email</td>
				<td><input type="text" name="email"></td>
			</tr>			
			
				<td>Password</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr> 
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="Submit"></td>
			</tr>
		</table>
	</form>



</body>
</html>



<div class="frontpage">

<div></div>
<div></div>
<div></div>

</div>



<?php
include "footer.php";
?>

