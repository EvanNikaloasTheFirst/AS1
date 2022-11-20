<?php 
error_reporting(0); 

?>
<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		<div class="loginClass">
			<ul>
			<?php
			// https://stackoverflow.com/questions/1519818/how-do-check-if-a-php-session-is-empty

// this line of code was sourced from StackOverflow
// if the user is logged in the their user name will be displayed with log out option.
				$registerIn ='<li><a href="register.php">Create an account</a></li> 
				<p>or</p>
				<li><a href="login.php">Log in</a></li>';

				$logOut = '<a href="logout.php">Log out</a>';


				$admin = '
				<li><a href="adminCatagories.php">Catagories</a></li>
				<a href="manageAdmins.php">Manage Admin</a>
				<a href="addAdmin.php">Add Admin</a>
				<a href="editCategory.php">Edit Category</a>';

if ($_SESSION['loggedIn'] == true && $_SESSION['adminLoggedIn'] == false)
	{
		echo 'Welcome back...  '. $_SESSION['email'];
		$string = preg_replace ('/<[^>]*>/', '', $registerIn); 
		echo '<p>'.$logOut.'</p>';
	}

	else if ($_SESSION['loggedIn'] == false) {
		$_SESSION['loggedIn'] = false;
		;
echo $registerIn;
	}

	else if ($_SESSION['adminLoggedIn'] == true)
	{
		echo 'Welcome back...  '. $_SESSION['email'];
		echo '<p>'.$logOut.'</p>';
		echo $admin;
	}


	?> 
	</ul>
	</div>

	<div class="navigationLinks">
		<ul>
			<li><a href="index.php"> Home</a></li>
			<li><a href="addAuction.php"> Add auction</a></li>
		</ul>
	</div>
	<link rel="stylesheet" href="ibuy.css" />
	</head>

	<body>
		<header>
			
			<h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>

			<form action="searchbox">
				<input type="text" name="search" placeholder="Search for anything" />
				<input type="submit" name="submit" value="Search" />
			</form>
		</header>

		<?php


// if(isset($_POST['submit'])){

// $name = $_POST['searchbox'];
//  $results = $pdo->query('SELECT * FROM CSY2028.user_accounts id = id');
//  $results->execute();

//  while($result = $stmt->fetch()){
// 	echo $result;

//  }
 
// }

		?>


		<nav>
			<ul>
				<?php
				$server = 'mysql';
				$username = 'student';
				$password = 'student';
				$schema = 'CSY2028';
				$pdo = new PDO ('mysql:dbname=' . 
				$schema . ';host='. $server,$username,$password);

				$stmt = $pdo->prepare('SELECT * FROM category');

				$stmt->execute();

				echo '<li>';
				while ($category =$stmt->fetch())
				{
					echo '<a href=auctions.php?id='. $category['id'] . '>'  .'<a class="categoryLink" "'. $category['id']. '">'.$category['name'].'</a>'.'</a>';

					// echo '<a href=auction.php?id='. $category['id'] . '>' . $category['name'] .'</a>';


				}
				echo '</li>';

				?>
			</ul>
		</nav>
		<img src="banners/1.jpg" alt="Banner" />



