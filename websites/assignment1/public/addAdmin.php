<?php 
session_start();
	$title = "Register an admin account";
	
		require 'layout.php';
	?>	
<main>



<form action = "addAdmin.php" method = "POST" id="registerForm">
<label for = "Firstname">First Name</label>
<input type ="text"  name="Firstname"/>

<label for = "Surname">Surname</label>
<input type ="text"  name="Surname"/>

<label for = "Email">Email</label>
<input type ="text"  name="Email"  />

<label for = "Date">Date of birth</label>
<input type="date" name="DateOfBirthday" />




<label for = "Password">Password</label>
<input type="password" name="Password" />





<input type ="submit" value ="Submit"  name="submit" />

</form>
</main>

<?php 

$server = 'mysql';
$username = 'student';
$password = 'student';

$schema = 'CSY2028';
$pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);


// $formArray = ['Firstname','Surname','Email','DateOfBirthday','Password','myCheckbox'];
$valid = false;	



// if (isset($_POST['submit'])){
// check if the email inputted is in a valid fashion
if (isset($_POST['Email']))
{
	$email = $_POST['Email'];

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//   echo("$email is a valid Email address");
$valid =true;
} else {
  echo('<p style="color:red;" "text-align=center">'.'Provided email is not a valid email address'.'</p>');
  $valid = false;
}
}

if (isset($_POST['Firstname']) && $_POST['Firstname'] != "")
{
	$valid =true;
} else{
	echo('<p style="color:red;" "text-align=center">'.'Invalid name'.'</p>');
	$valid = false;
}
if (isset($_POST['Surname']) && $_POST['Surname'] != "")
{
	$valid =true;
} else{
	echo('<p style="color:red;" "text-align=center">'.'Invalid surname'.'</p>');
	$valid = false;
}
if (isset($_POST['DateOfBirthday']) && $_POST['DateOfBirthday'] != "")
{

} else{
	echo('<p style="color:red;" "text-align=center">'.'Invalid date of birth'.'</p>');
	$valid = false;
}


if (isset($_POST['Password'])) {
//  Code below sourced from https://stackoverflow.com/questions/42467243/regex-strong-password-the-special-characters
// code below uses regex (Regular expression) to create a secure password
 if (strlen($_POST['Password']) < 6) {
	$valid = false;
	echo '<p style="color:red;" "text-align=center">'.'Please enter a longer password'.'</p>';
 } 

 if (!preg_match("/\d/", $_POST['Password'])) {
	$valid = false;
	echo '<p style="color:red;" "text-align=center">'.'Password should contain at least one digit'.'</p>';
}
if (!preg_match("/[A-Z]/", $_POST['Password'])) {
	$valid = false;
	echo '<p style="color:red;" "text-align=center">'.'Password should contain at least one Capital Letter'.'</p>';
}
if (!preg_match("/[a-z]/", $_POST['Password'])) {
	$valid = false;
	echo '<p style="color:red;" "text-align=center">'.'Password should contain at least one small Letter'.'</p>';
}
if (!preg_match("/\W/", $_POST['Password'])) {
	$valid = false;
	echo '<p style="color:red;" "text-align=center">'.'Password should contain at least one special character'.'</p>';
}
if (preg_match("/\s/", $_POST['Password'])) {
	$valid = false;
	echo '<p style="color:red;" "text-align=center">'.'Password should not contain any white space'.'</p>';
}
  }
  else{
	$valid = true;
  }




	if(isset($_POST['submit']) && $valid == true){

		$stmt = $pdo->prepare('INSERT INTO CSY2028.user_accounts (Firstname,Surname,Email,DateOfBirthday,Password,admin)
		VALUES (:firstname,:surname, :email, :DateOfBirthday,:password,:admin)');
		
		$values = [
		       'firstname' => $_POST['Firstname'],
		       'surname' => $_POST['Surname'],
		       'email' => $_POST['Email'],
			   'DateOfBirthday' => $_POST['DateOfBirthday'],
		       'password' =>  $hash = password_hash($_POST['Password'], PASSWORD_DEFAULT),
			   'admin' => 'Y'
			   
		];
		$stmt->execute($values);	
		echo'<p style="color:green;" "text-align=center">'.'Form submitted!'.'</p>';
}
		require 'footer.php';
	?>	




