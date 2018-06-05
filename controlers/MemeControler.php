<?php

	function getAllPictures() {
        global $bdd;
		global $twig; 
        $allPictures = $bdd->prepare("SELECT * FROM `base`");
        $allPictures->execute();
        $results = $allPictures->fetchAll();
        //echo '<pre>'; var_dump($results); echo '</pre>'; die();
    
		//foreach($results as $result){
		//	echo "<a href='index.php?page=create&base=".$result['file_name']."'><img src='assets/img/".$result['file_name']."'></a>";
		//}
		
		echo $twig->render('home.html.twig', [
			'pictures' => $results
		]);
    }
	
	function createMeme() {
		global $twig; 
		echo $twig->render('create.html.twig', [
			'base' => $_GET['base']
		]);
	}
	
	function generateMeme() {
		// get form submission (or defaults)
		$firstP    = $_GET['first_paragraphe'];
		$secondP = $_GET['second_paragraphe'];
		$filename    = memegen_sanitize( $secondP ? $secondP : $firstP );
		$base = $_GET['base'];
		// setup args for image
		$settings = array(
			'top_text'    => $firstP,
			'bottom_text' => $secondP,
			'filename'    => $filename,
			'font'        => dirname(__FILE__) .'/assets/font/Anton.ttf',
			'memebase'    => dirname(__FILE__) ."/assets/img/".$base."",
			'textsize'    => 40,
			'textfit'     => true,
			'padding'     => 10,
		);
	
		// create and output image
		memegen_build_image( $settings );
	}
	
    
?>

