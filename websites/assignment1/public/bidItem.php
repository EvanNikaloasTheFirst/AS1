<?php
session_start();
$title = "Bid";
require 'layout.php';
        $server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'CSY2028';
        $pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);

        if (isset($_POST['submit'])){
            
            $date = date('Y-m-d');

            $stmt = $pdo->prepare('INSERT INTO CSY2028.currentBid (bids,auction_Id,dateOfBid)
                    VALUES (:bids, :auction_Id,:dateOfBid)');
            
                    $values = [
                        'bids' => $_POST['bid'],
                        'auction_Id' => $_POST['id'],
                        'dateOfBid' =>  $date
                    ];
                    
                    $stmt->execute($values);
                    echo'<p>'.'Bid added'.'</p>';
                }

        else if (isset($_GET['id'])) {
            $gameStmt = $pdo->prepare('SELECT * FROM CSY2028.auction WHERE id = :id');
    
        $values = [
            'id' => $_GET['id'],

        ];
    
        $gameStmt->execute($values);
    
        $user = $gameStmt->fetch();
    ?>
    <form action ="bidItem.php" method="POST" id="auctionForm">

<input type ="hidden" name="id" value="<?php echo $_GET['id'];?>"/>

<input type ="text"  name="title" disabled="disabled" value="<?php echo $user['title'];?>"/>

<textarea name="description" id="description" disabled="disabled">
    <?php echo $user['description'] ;?>
    </textarea>

     <!-- dsiplay select options -->
<?php
echo '<select name="category">';
$stmt = $pdo->prepare('SELECT * FROM category');
$stmt->execute();

foreach($stmt as $row)
{
    if ($row['id'] == $user['categoryid'])
    {
        
        echo '<option value"'. $row['id']. '" selected="selected"'.'disabled="disabled"' .'>'.$row['name'].'</option>';
    }
}
echo '</select>';
?>

    <!-- end of display select options -->
    <label for = "endOfAuction">Auction ends at</label>
<input type="date" name="endDate" disabled="disabled"  value="<?php echo $user['endDate'];?>"/>

<?php

$stmt2 = $pdo->prepare('SELECT MAX(CAST(bids AS INT)) AS highest FROM CSY2028.currentBid WHERE auction_Id = ?');
$stmt2->execute([$_GET['id']]);
$price = $stmt2->fetch();
// echo '<p>'. intval($price).'</p>';

?>
<p class ="price">Current Price: <?php echo $price['bids']?> </p>
<input type ="number"  name="bid"  />
<input type ="submit" value ="Submit"  name="submit" />
</form>

<?php
        }
        require 'footer.php';
?>


