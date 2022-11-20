<?php 
session_start();
	$title = "Add category";
		require 'layout.php';
?>	


<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'CSY2028';
$pdo = new PDO ('mysql:dbname=' . 
$schema . ';host='. $server,$username,$password);



if (isset($_POST['submit'])){

    $stmt = $pdo->prepare('INSERT INTO CSY2028.category (name)
            VALUES (:name)');
    
            $values = [
                'name' => $_POST['name']
            ];
            
            $stmt->execute($values);
            echo'<p>'.'Category added'.'</p>';
        }
        
        // if (isset($_SESSION['loggedIn'])){
  ?>
<form action="addCategory.php" method="POST">
   <label for = "name">Name</label>
     <input type ="text"  name="name"/>
   <input type="submit" value="Submit" name="submit">
 </form> 

 <?php
		require 'footer.php';
?>
