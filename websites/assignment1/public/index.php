<?php
session_start();
require 'layout.php';
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'CSY2028';
$pdo = new PDO ('mysql:dbname=' . 
$schema . ';host='. $server,$username,$password);
?>


		<main>

    <?php
    // / DISPLAY THE SOONEST ENDING LISTINGS
				$stmt = $pdo->prepare('SELECT * FROM CSY2028.auction ORDER BY endDate ASC LIMIT 10');
				$stmt->execute();

        $stmt1 = $pdo->prepare('SELECT * FROM CSY2028.category WHERE id = :id');

        $values = [
          'id' => $_GET['id']
      ];
      $stmt1->execute($values);

      $cat = $stmt1->fetch();

      $stmt2 = $pdo->prepare('SELECT * FROM CSY2028.auction WHERE id = :id');

      $values1 = [
        'id' => $_GET['id']
    ];
    $stmt2->execute($values1);

    $cat1 = $stmt2->fetch();
      ?>

			<h1>Latest Listings / Search Results / Category listing</h1>

			<ul class="productList">
				<li>
					<img src="product.png" alt="product name">
					<article class ="product">
            <?php
            while($auction = $stmt->fetch()){
              ?>
						<h2><?php  echo $auction['title'] ?> </h2>

            
            
						<!-- <h3><?php $auction['name']?></h3> -->

						<p><?php echo $auction['description'] ?></p>
          

						<p class="price">Current bid:</p>
					
<?php
            echo '<a href=ex12.php?id='. $auction['id'] .'&userid='.$auction['userid'] . ' class="more auctionLink">' . 'More'. '&gt;&gt' .'</a>';

            ?>
            
					</article>
				</li>
        
			
					<?php
// checks if user is logged in
					if(!empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == $auction['userid'])
					{
			// 		// edit the lisiting
			echo '<p>'.'<button>'.'<a href=editauction.php?id='. $auction['id'] . '>' . 'Edit' .'</a>'.'</button>'.'</p>';
					// delete the listing

					echo '<p>'.'<button>'.'<a href=deleteAuction.php?id='. $auction['userid'] . '>' . 'Delete' .'</a>'.'</button>'.'</p>';

			// 		//Displays Bid,review and view review buttons
				} else {
					
					echo '<p>'.'<button>'.'<a href=reviews.php?id='. $auction['userid'] . '>' . 'Review' .'</a>'.'</button>'.'</p>';
					echo '<p>'.'<button>'.'<a href=viewreviews.php?id='. $auction['userid'] . '>' . 'View Reviews' .'</a>'.'</button>'.'</p>';
					
				}
				
			}

?>
      
			</ul>

			<hr />

			<h1>Product Page</h1>

      <?php
        if (isset($_GET['id'])) {
          $gameStmt = $pdo->prepare('SELECT * FROM CSY2028.auction WHERE id = :id');

          $userName = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE user_id = :user_id');
  
      $values = [
          'id' => $_GET['id'],

      ];

      $gameStmt->execute($values);
  
      $user = $gameStmt->fetch();

      $values1 = [
        'user_id' => $_GET['userid'],

    ];
  

      // -------

      $userName->execute($values1);
  
      $user2 = $userName->fetch();
        ?>

			<article class="product">
        <h3><?php  echo $user['title']  ?> </h3>
						<p class="price">Current bid:</p>
					<section class="description">
            <h4>Item description</h4>
					<p><?php  echo $user['description']  ?> </p>
          <p><?php echo' Auction created by '. $user2['firstname'].' '. $user2['surname']?></p>
          <form action ="bidItem.php" method="POST" id="auctionForm">

<input type ="hidden" name="id" value="<?php echo $_GET['id'];?>"/>



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
    <label for = "endDate">Auction ends at</label>
    <input type="date" name="endDate" disabled="disabled"  value="<?php echo $user['endDate'];?>"/>
          <input type ="number"  name="bid"  />
          <input type ="submit" value ="Submit"  name="submit" />
          </form>

<?php
}
else {

echo '';
}

?>
					</section>

					<section class="reviews">
            
            <?php
           $reviewQuery = $pdo->prepare('SELECT * from CSY2028.reviews');
           $userQuery = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE user_id = :userid');
           
           $reviewQuery->execute();
           echo '<h1>'.'Reviews'.'</h1>';
           echo '<ul>';
           foreach ($reviewQuery as $message) 
           {
               $values1 = [
                   'userid' => $message['usersid']
           ];
               $userQuery->execute($values1);
               $user1 = $userQuery->fetch();
           
           
               if($_SESSION['loggedIn'] == $message['reviewee_id'])
               {
               echo '<li>'.'<button>'.'<a href=userReviews.php?id='. $user1['user_id'] . '>' . $user1['firstname'] . ' ' . $user1['surname'] .' posted ... ' . "' ". $message['reviewtext'] ." ' ".'</a>'.'</button>'.'</li>';;
               }
           }
            ?>
						

            <?php

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
 else {

  echo '<a href="login.php">Log in</a>'.'</p>';
  


}
  }
}


?>


	</section>
					</article>


					<hr />
				


<?php
require 'footer.php';
?><?php
session_start();
require 'layout.php';
$server = 'mysql';
$username = 'student';
$password = 'student';
$schema = 'CSY2028';
$pdo = new PDO ('mysql:dbname=' . 
$schema . ';host='. $server,$username,$password);
?>


		<main>

    <?php
    // / DISPLAY THE SOONEST ENDING LISTINGS
				$stmt = $pdo->prepare('SELECT * FROM CSY2028.auction ORDER BY endDate ASC LIMIT 10');
				$stmt->execute();

        $stmt1 = $pdo->prepare('SELECT * FROM CSY2028.category WHERE id = :id');

        $values = [
          'id' => $_GET['id']
      ];
      $stmt1->execute($values);

      $cat = $stmt1->fetch();

      $stmt2 = $pdo->prepare('SELECT * FROM CSY2028.auction WHERE id = :id');

      $values1 = [
        'id' => $_GET['id']
    ];
    $stmt2->execute($values1);

    $cat1 = $stmt2->fetch();
      ?>

			<h1>Latest Listings / Search Results / Category listing</h1>

			<ul class="productList">
				<li>
					<img src="product.png" alt="product name">
					<article class ="product">
            <?php
            while($auction = $stmt->fetch()){
              ?>
						<h2><?php  echo $auction['title'] ?> </h2>

            
            
						<!-- <h3><?php $auction['name']?></h3> -->

						<p><?php echo $auction['description'] ?></p>
          

						<p class="price">Current bid:</p>
					
<?php
            echo '<a href=index.php?id='. $auction['id'] .'&userid='.$auction['userid'] . ' class="more auctionLink">' . 'More'. '&gt;&gt' .'</a>';

            ?>
            
					</article>
				</li>
        
			
					<?php
// checks if user is logged in
					if(!empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == $auction['userid'])
					{
			// 		// edit the lisiting
			echo '<p>'.'<button>'.'<a href=editauction.php?id='. $auction['id'] . '>' . 'Edit' .'</a>'.'</button>'.'</p>';
					// delete the listing

					echo '<p>'.'<button>'.'<a href=deleteAuction.php?id='. $auction['userid'] . '>' . 'Delete' .'</a>'.'</button>'.'</p>';

			// 		//Displays Bid,review and view review buttons
				} else {
					
					echo '<p>'.'<button>'.'<a href=reviews.php?id='. $auction['userid'] . '>' . 'Review' .'</a>'.'</button>'.'</p>';
					echo '<p>'.'<button>'.'<a href=viewreviews.php?id='. $auction['userid'] . '>' . 'View Reviews' .'</a>'.'</button>'.'</p>';
					
				}
				
			}

?>
      
			</ul>

			<hr />

			<h1>Product Page</h1>

      <?php
        if (isset($_GET['id'])) {
          $gameStmt = $pdo->prepare('SELECT * FROM CSY2028.auction WHERE id = :id');

          $userName = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE user_id = :user_id');
  
      $values = [
          'id' => $_GET['id'],

      ];

      $gameStmt->execute($values);
  
      $user = $gameStmt->fetch();

      $values1 = [
        'user_id' => $_GET['userid'],

    ];
  

      // -------

      $userName->execute($values1);
  
      $user2 = $userName->fetch();
        ?>

			<article class="product">
        <h3><?php  echo $user['title']  ?> </h3>
						<p class="price">Current bid:</p>
					<section class="description">
            <h4>Item description</h4>
					<p><?php  echo $user['description']  ?> </p>
          <p><?php echo' Auction created by '. $user2['firstname'].' '. $user2['surname']?></p>
          <form action ="bidItem.php" method="POST" id="auctionForm">

<input type ="hidden" name="id" value="<?php echo $_GET['id'];?>"/>



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
    <label for = "endDate">Auction ends at</label>
    <input type="date" name="endDate" disabled="disabled"  value="<?php echo $user['endDate'];?>"/>
          <input type ="number"  name="bid"  />
          <input type ="submit" value ="Submit"  name="submit" />
          </form>

<?php
}
else {

echo '';
}

?>
					</section>

					<section class="reviews">
            
            <?php
           $reviewQuery = $pdo->prepare('SELECT * from CSY2028.reviews');
           $userQuery = $pdo->prepare('SELECT * FROM CSY2028.user_accounts WHERE user_id = :userid');
           
           $reviewQuery->execute();
           echo '<h1>'.'Reviews'.'</h1>';
           echo '<ul>';
           foreach ($reviewQuery as $message) 
           {
               $values1 = [
                   'userid' => $message['usersid']
           ];
               $userQuery->execute($values1);
               $user1 = $userQuery->fetch();
           
           
               if($_SESSION['loggedIn'] == $message['reviewee_id'])
               {
               echo '<li>'.'<button>'.'<a href=userReviews.php?id='. $user1['user_id'] . '>' . $user1['firstname'] . ' ' . $user1['surname'] .' posted ... ' . "' ". $message['reviewtext'] ." ' ".'</a>'.'</button>'.'</li>';;
               }
           }
            ?>
						

            <?php

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
 else {

  echo '<a href="login.php">Log in</a>'.'</p>';
  


}
  }
}


?>


	</section>
					</article>


					<hr />
				


<?php
require 'footer.php';
?>