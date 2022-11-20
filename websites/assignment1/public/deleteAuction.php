<?php 
session_start();
	$title = "Delete Auction";
		require 'layout.php';

		$server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);


		$theId =$_GET['id'];

		$stmt1 = $pdo->prepare('DELETE FROM CSY2028.auction WHERE id = :id');

		$values = [
            'id' => $_GET['id']
        ];


		$stmt1->execute($values);
		echo 'Auction #'. $theId. ' has been deleted';


?>	
<?php

require 'footer.php';
?>
