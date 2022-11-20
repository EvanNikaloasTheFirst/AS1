<?php 
session_start();
	$title = "Admin categories";
		require 'layout.php';


        $stmt = $pdo->prepare('SELECT * FROM CSY2028.category');
        $stmt->execute();

        while($category = $stmt->fetch()){
            echo '<p>'.'<button>'.'<a href=editcategory.php?id='. $category['id'] . '>' .'Edit'.'   ' .$category['name'].'</a>'.'</button>'.'</p>';
            echo '<p>'.'<button>'.'<a href=deletecategory.php?id='. $category['id'] . '>' .'Delete'.'   ' .$category['name'].'</a>'.'</button>'.'</p>';

        }
        echo '<p>'.'<button>'.'<a href=addcategory.php>' .'Add category'.'</a>'.'</button>'.'</p>';


	?>	


<?php 

		require 'footer.php';
	?>	