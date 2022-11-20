<?php 
session_start();
	$title = "Delete Category";
		require 'layout.php';

		$server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);


		$theId =$_GET['id'];

		$stmt1 = $pdo->prepare('DELETE FROM CSY2028.category WHERE id = :id');

		$values = [
            'id' => $_GET['id']
        ];


		$stmt1->execute($values);
		echo 'Auction #'. $theId. ' has been deleted';

?>	

<?php
session_start();
$title = "Edit category";
require 'layout.php';


$server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);

        if (isset($_POST['submit'])) {
            $stmt = $pdo->prepare('UPDATE CSY2028.category
            SET name = :name 
            WHERE id = :id');


$values = [
    'name' => $_POST['name'],
    'id' => $_POST['id']
];

$stmt->execute($values);
echo'<p>'.'Category edited'.'</p>';
}

else if (isset($_GET['id'])) {
    $gameStmt = $pdo->prepare('SELECT * FROM CSY2028.category WHERE id = :id');

	$values = [
		'id' => $_GET['id']
	];

	$gameStmt->execute($values);

	$game = $gameStmt->fetch();

    ?>
    <form action="editCategory.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
    <label for = "name">Name</label>
     <input type ="text"  name="name" 
     value="<?php echo $game['name'];?>"/>
   <input type="submit" value="Submit" name="submit">
</form> 


<?php

}
require 'footer.php';

?>



