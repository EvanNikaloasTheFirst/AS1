<?php 
session_start();
	$title = "Add Auction";
		require 'layout.php';
?>	

<?php
$server = 'mysql';
$username = 'student';
$password = 'student';

$schema = 'CSY2028';
$pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);



if(isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn']))
{
    ?>
<form action ="addAuction.php" method="POST" id="auctionForm">
<label for = "title">Title</label>
<input type ="text"  name="title"/>

<label for = "description">Description</label>
<textarea name="description" id="description" >
</textarea>

<label for = "category">Category</label>

<?php
$stmt = $pdo->prepare('SELECT * FROM category');

$stmt->execute();
echo '<select name="category">';
while ($category =$stmt->fetch())
{
    echo '<option value="'. $category['id']. '">'.$category['name'].'</option>';
}
echo '</select>';
?>

<label for = "endOfAuction">End of auction</label>
<input type="date" name="endDate"/>

<input type ="submit" value ="Submit"  name="submit" />

</form>
<?php
}
else{
    echo 'you need to be logged in';
}
?>
<?php

$valid = false;
$currentdate = date("Y/m/d");	


    if (isset($_POST['submit'])){
    if (isset($_POST['title']) && $_POST['title'] != "")
    {
        $valid = true;
    } else{
        echo('<p style="color:red;" "text-align=center">'.'Invalid title'.'</p>');
        $valid = false;
    }

    if (isset($_POST['description']) && $_POST['description'] != "")
    {
        $valid = true;
    } else{
        echo('<p style="color:red;" "text-align=center">'.'Invalid description'.'</p>');
        $valid = false;
    }

    if (isset($_POST['endDate']) )
    {
      $storedDate = $_POST['endDate'];
      if ($storedDate > $currentdate){
        $valid = true;
      }

    } else {
        echo('<p style="color:red;" "text-align=center">'.'Invalid date'.'</p>');
        $valid = false;
    }
}
 if(isset($_POST['submit']) && $valid == true)
{
    $stmt = $pdo->prepare('INSERT INTO CSY2028.auction (title,description,categoryid,endDate,userid)
		VALUES (:title,:description, :categoryid, :endDate, :userid)');
		
		$values = [
		       'title' => $_POST['title'],
		       'description' => $_POST['description'],
               'categoryid' => $_POST['category'],
			   'endDate' => $_POST['endDate'],
               'userid' => $_SESSION['loggedIn']
		];
		$stmt->execute($values);
        echo 'Post created!';
}else {
    echo('<p style="color:red;" "text-align=center">'.'Invalid input'.'</p>');
    $valid = false;
}
require 'footer.php';
?>