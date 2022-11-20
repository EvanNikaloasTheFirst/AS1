<?php 
session_start();
	$title = "Delete admin";
		require 'layout.php';

		$server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);

        var_dump($_GET);

		$theId =$_GET['id'];

		$stmt1 = $pdo->prepare('DELETE FROM CSY2028.user_accounts WHERE user_id = :id');

		$values = [
            'id' => $_GET['id']
        ];


		$stmt1->execute($values);
		echo 'user #'. $theId. ' has been deleted';







?>	
