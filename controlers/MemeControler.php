<?php

	function getAllPictures() {
		
        global $bdd;
		$bdd = connect();
		global $twig; 
        $allPictures = $bdd->prepare("SELECT * FROM `base`");
        $allPictures->execute();
        $results = $allPictures->fetchAll();
        //echo '<pre>'; var_dump($results); echo '</pre>'; die();
    
		
		
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
		include 'models/MemeModel.php';
		// echo '<pre>'; var_dump($_POST); echo '</pre>'; 
		// get form submission (or defaults)
		$filename    = memegen_sanitize( $_POST['second_paragraphe'] ? $_POST['second_paragraphe'] : $_POST['first_paragraphe'] );
		$base = $_POST['base'];
		// setup args for image
		$settings = array(
			'top_text'    => $_POST['first_paragraphe'],
			'bottom_text' => $_POST['second_paragraphe'],
			'filename'    => $filename,
			'font'        => realpath(dirname(__FILE__) .'/../assets/font/Anton.ttf'),
			'memebase'    => realpath(dirname(__FILE__) ."/../assets/img/".$base.""),
			'textsize'    => 40,
			'textfit'     => true,
			'padding'     => 10,
		);
		$filename = memegen_build_image( $settings );
		//return generateMemeCtrl();
	}

	function showMemeResult() {
		$server_url = 'http://localhost/meme_generator/';
		global $twig; 
		echo $twig->render('show.html.twig', [
			'file_name' => $_GET['file_name'],
			'server_url' => $server_url,
			'img_name' => $_GET['img_name'],
		]);
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

