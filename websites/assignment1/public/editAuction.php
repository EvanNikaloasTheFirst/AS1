<?php
session_start();
$title = "Edit auction";
require 'layout.php';

        $server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);

        if (isset($_POST['submit'])) {
            $stmt = $pdo->prepare('UPDATE CSY2028.auction 
                                SET title = :title, 
                                description = :description,
                                categoryid = :categoryid,
                                endDate = :endDate
                                WHERE id = :id');
        
        $values = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'categoryid' => $_POST['categoryid'],
            'endDate' => $_POST['endDate'],
            'id' => $_POST['id']
        ];
        
        $stmt->execute($values);
        echo 'Auction #'.$_POST['id'].' edited';
        }
        //If the form has not been submitted, check that a game has been selected to be edited e.g. editgame.php?id=3
else if (isset($_GET['id'])) {

	$gameStmt = $pdo->prepare('SELECT * FROM CSY2028.auction WHERE id = :id');

	$values = [
		'id' => $_GET['id']
	];

	$gameStmt->execute($values);

	$game = $gameStmt->fetch();
?>
<form action ="editAuction.php" method="POST" id="auctionForm">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>

<label for = "title">Title</label>
<input type ="text"  name="title" value="<?php echo $game['title'];?>"/>

    
<textarea name="description" id="description">
<?php echo $game['description'];?>
</textarea>

<?php
echo '<select name="categoryid">';
$stmt = $pdo->prepare('SELECT * FROM category');
$stmt->execute();

foreach($stmt as $row)
{
if ($row['id'] == $game['categoryid'])
{
echo '<option value"'. $row['id']. '" selected="selected">'.$row['name'].'</option>';
} else {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}
echo '</select>';
?>
<label for = "endOfAuction">End of auction</label>
<input type="date" name="endDate"  value="<?php echo $game['endDate'];?>"/>
<input type="text" name="userid" disabled value="<?php echo $game['userid'];?>"/>
<input type ="submit" value ="Submit"  name="submit" />
</form>


<?php
require 'footer.php';

}
?>