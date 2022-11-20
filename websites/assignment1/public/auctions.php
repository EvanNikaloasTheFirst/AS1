<?php
session_start();
$title = "Auctions";
require 'layout.php';

?>
<ul class="productList">
<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'CSY2028';
$pdo = new PDO ('mysql:dbname=' . $schema . ';host='. $server,$username,$password);

$stmt = $pdo->prepare('SELECT * FROM CSY2028.auction WHERE categoryid =:id');

$values = 
[
    'id' => $_GET['id']
];
$stmt->execute($values);

echo '<ul>';
echo '<li>';
while($auction = $stmt->fetch()){
    // echo '<li>';
    echo '<img src="product.png" alt="product name">';
    echo '<article>';
    echo '<h2>'.$auction['title'].'</h2>';
    echo '<p>'.$auction['description'].'</p>';
    echo '<p>'.'Auction ends at... '.$auction['endDate'].'</p>';
    if(!empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == $auction['userid'])
        {
    echo '<p>'.'<button>'.'<a href=editauction.php?id='. $auction['id'] . '>' . 'Edit' .'</a>'.'</button>'.'</p>';
// delete the listing
echo '<p>'.'<button>'.'<a href=deleteAuction.php?id='. $auction['id'] . '>' . 'Delete' .'</a>'.'</button>'.'</p>';
echo '</li>';
        }
        else{
            echo '<p>'.'<button>'.'<a href=bidItem.php?id='. $auction['id'] . '>' . 'Bid' .'</a>'.'</button>'.'</p>';
echo '</li>';

        }
    }
echo '</ul>';


?> 
