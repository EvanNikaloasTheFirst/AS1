<?php
session_start();
$title = "Edit admin";
require 'layout.php';


$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'CSY2028';
$pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);


 if (isset($_POST['submit'])) {
            $stmt = $pdo->prepare('UPDATE CSY2028.user_accounts 
                                SET firstname = :firstname, 
                                surname = :surname,
                                email = :email,
                                password = :password,
                                DateOfBirthday = :DateOfBirthday,
                                admin = :admin
                                WHERE user_id = :id');

$values = [
    'firstname' => $_POST['Firstname'],
    'surname' => $_POST['Surname'],
    'email' => $_POST['Email'],
    'password' => $_POST['Password'],
    'DateOfBirthday' => $_POST['DateOfBirthday'],
    'admin' => $_POST['admin'],
    'id' => $_POST['id']
];

$stmt->execute($values);
echo 'Admin #'.$_POST['id'].' has been edited';
}
else if (isset($_GET['id'])) {

    $gameStmt = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE user_id = :id');

	$values = [
		'id' => $_GET['id']
	];

	$gameStmt->execute($values);

	$game = $gameStmt->fetch();
?>
<form action = "editAdmin.php" method = "POST" id="registerForm">

<input type="hidden" name="id" value="<?php echo $game['user_id']; ?>"/>

<label for = "Firstname">First Name</label>
<input type ="text"  name="Firstname" value="<?php echo $game['firstname']; ?>"/>


<label for = "Surname">Surname</label>
<input type ="text"  name="Surname" value="<?php echo $game['surname']; ?>"/>


<label for = "Email">Email</label>
<input type ="text"  name="Email" value="<?php echo $game['email']; ?>"/>


<label for = "Date">Date of birth</label>
<input type="date" name="DateOfBirthday" value="<?php echo $game['DateOfBirthday']; ?>"/>


<label for = "adminUser">Is this an admin account? Y or N</label>

<input type ="text"  name="admin"  value="<?php echo $game['admin']; ?>"/>



<label for = "Password">Password</label>
<input type="password" name="Password" value="<?php echo $game['password']; ?>"/>



<label for = "checkbox">Do you agree to the terms and conditions?</label>

<input type = "checkbox" name="myCheckbox" value="ticked" />
<input type ="submit" value ="Submit"  name="submit" />

</form>


<?php

}
require 'footer.php';

?>