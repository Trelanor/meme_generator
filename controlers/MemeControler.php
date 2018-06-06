<?php

	function getAllPictures() {
		
        global $bdd;
		$bdd = connect();
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
	
	function generateMemeCtrl() {
		//$path = '/home/psaulay/projets/meme_generatorV2/generated_img';
		include 'models/MemeModel.php';

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
			'font'        => realpath(dirname(__FILE__) .'/../assets/font/Anton.ttf'),
			'memebase'    => realpath(dirname(__FILE__) ."/../assets/img/".$base.""),
			'textsize'    => 40,
			'textfit'     => true,
			'padding'     => 10,
		);
	
		$filename = memegen_build_image( $settings );
		// create and output image
		// move_uploaded_file( );
	}
	
    function get_ip() {
		
		// IP si internet partagé
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		
		// IP derrière un proxy
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		
		// Sinon : IP normale
		else {
			return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		}
	
	}

?>

