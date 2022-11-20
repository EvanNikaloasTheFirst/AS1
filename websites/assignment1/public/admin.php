<?php 
session_start();
	$title = "Log in";
		require 'layout.php';
        $server = 'mysql';
        $username = 'student';
        $password = 'student';
       
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);
	?>	

    <h1>Admin Login</h1>

<form action = "admin.php" method = "POST" id="loginForm">
<label for = "admin_email">Email</label>
<input type ="text"  name="admin_email" value="<?php echo $_POST['email'] ?? ''; 
?>" 
/>
<label for = "admin_password">Password</label>
<input type="password" name="admin_password" />
<input type ="submit" value ="Submit"  name="submit" />

</form>
</main>

<?php
if(isset($_POST['submit'])){

    $stmt = $pdo->prepare('SELECT * FROM CSY2028.admin WHERE admin_email = :admin_email');

    $values = [
        'admin_email' => $_POST['admin_email']

    ];

    $stmt->execute($values);

    $user = $stmt->fetch();

// if (password_verify($_POST['admin_password'], $user['admin_password']))

if ($_POST['admin_email'] === 'admin1@outlook.com' && $_POST['admin_password'] === 'Empochon123!') 
{
    // if ($stmt -> rowCount() > 0){
        $_SESSION['loggedIn'] = $user['id'];
        $_SESSION['email'] = $user['admin_email'];
        $_SESSION['adminLoggedIn'] = $user['id'];
        var_dump($_SESSION);

echo'<p style="color:green;" "text-align=center">'.'You are now logged in'.'</p>';	
    }

else {
$_SESSION['loggedIn'] = false;
echo'<p style="color:red;" "text-align=center">'.'Invalid details'.'</p>';

}
}





?>



<?php

require 'footer.php';

?>