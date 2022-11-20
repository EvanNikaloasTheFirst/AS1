<?php
session_start();
$title = "Reviews";
require 'layout.php';
        $server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);

if(isset($_SESSION['loggedIn'])){
if (isset($_POST['submit'])){

		$stmt = $pdo->prepare('INSERT INTO CSY2028.reviews (reviewtext,usersid,reviewee_id)
		VALUES (:reviewtext, :usersid, :reviewee_id)');

		$values = [
		       'reviewtext' => $_POST['reviewtext'],
			   'usersid' => $_SESSION['loggedIn'],
               'reviewee_id'=> $_POST['id']
               
		];

		$stmt->execute($values);
		echo 'Review submitted successfully';
		
	}
    else {
        $stmt1 = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE user_id = :user_id');

		$values = [
            'user_id' => $_GET['id']
        ];

        echo '<p>'.'You need to be logged in'.'</p>';
        echo '<p>'.'<a href="login.php">Log in</a>'.'</p>';
        

$stmt1->execute($values);
$user = $stmt->fetch();




if(!empty($_SESSION['loggedIn']) && $_SESSION['loggedIn']== true){
?>
<form action ="reviews.php" method="POST" id="auctionForm">

<input type ="hidden" name="id" value="<?php echo $_GET['id'];?>"/>

<label for = "review">Review</label>
<textarea name="reviewtext" id="review" >
</textarea>

<input type ="submit" value ="Submit"  name="submit" />

</form>

<?php
}
    }

}
require 'footer.php';
?>