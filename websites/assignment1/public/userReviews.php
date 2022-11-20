<?php
session_start();
$title = 'Review history';
require 'layout.php';




$stmt = $pdo->prepare('SELECT * FROM CSY2028.reviews WHERE usersid = :id');
$values = [
    'id' => $_GET['id']
];
$stmt->execute($values);

$stmt1 = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE user_id = :id');
$values1 = [
    'id' => $_GET['id']
];
$stmt1->execute($values1);
$user = $stmt1->fetch();

echo '<h1>'.'History of '.$user['firstname']. ' '.$user['surname']."'s reviews".'</h1>';
echo '<ul>';
while($review = $stmt->fetch()){
    echo '<li>'. $review['reviewtext'].'</li>';
}
echo '</ul>';



?>



<?php


require 'footer.php';

?>



