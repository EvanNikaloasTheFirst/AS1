<?php 
session_start();
	$title = "Log in";
		require 'layout.php';
	?>	
	<main>

<form action = "login.php" method = "POST" id="loginForm">
<label for = "Email">Email</label>
<input type ="text"  name="email" value="<?php echo $_POST['email'] ?? ''; 
?>" 
/>
<label for = "myPassword">Password</label>
<input type="password" name="password" />
<input type ="submit" value ="Submit"  name="submit" />

</form>
</main>

<?php 
 $server = 'mysql';
 $username = 'student';
 $password = 'student';

 $schema = 'CSY2028';
 $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);



	if(isset($_POST['submit'])){

		$stmt = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE email = :email');

		$values = [
			'email' => $_POST['email']
		];

		$stmt->execute($values);

		$user = $stmt->fetch();

if (password_verify($_POST['password'], $user['password']) && $user['admin'] == 'N')
{
			$_SESSION['loggedIn'] = $user['user_id'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['adminLoggedIn'] = false;

	echo'<p style="color:green;" "text-align=center">'.'You are now logged in'.'</p>';	
	}

	else if  (password_verify($_POST['password'], $user['password']) && $user['admin'] == 'Y') 
	{

		$_SESSION['loggedIn'] = $user['user_id'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['adminLoggedIn'] = $user['user_id'];

		echo'<p style="color:green;" "text-align=center">'.'Welcome admin #'.$_SESSION['loggedIn'] = $user['user_id'];	
	
	}
	else {
		echo'<p style="color:red;" "text-align=center">'.'Invalid details'.'</p>';
	}
}
require 'footer.php';
?>	