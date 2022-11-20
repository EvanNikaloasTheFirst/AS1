<?php 
session_start();
	$title = "Manage admins";
		require 'layout.php';
        $server = 'mysql';
				$username = 'student';
				$password = 'student';
				$schema = 'CSY2028';
				$pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);


    $stmt = $pdo->query("SELECT * FROM CSY2028.user_accounts WHERE admin = 'Y'");


	$stmt->execute();


  echo '<p>'.'Current Admins'.'</p>';

    while($users = $stmt->fetch()){
        echo '<p>'.$users['firstname'].' '.$users['surname'].' - ' .'#' .$users['user_id'].'</p>';

        echo '<p>'.'<button>'.'<a href=editAdmin.php?id='. $users['user_id'] . '>' . 'Edit '.$users['user_id'] .'</a>'.'</button>'.'</p>';
					// delete the listing
					echo '<p>'.'<button>'.'<a href=deleteAdmin.php?id='. $users['user_id'] . '>' . 'Delete '.$users['user_id'] .'</a>'.'</button>'.'</p>';



    }
    echo '<p>'.'<button>'.'<a href=addAdmin.php>' .'Add Admin'.'</a>'.'</button>'.'</p>';

               
	?>	



<?php
require 'footer.php';


?>