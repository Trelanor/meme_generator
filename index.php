<?php
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=meme;charset=utf8', 'root', 'root');
    }
    catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    //function getAllPictures() {
        //global $bdd;
        $allPictures = $bdd->prepare("SELECT * FROM `base`");
        $allPictures->execute();
        $results = $allPictures->fetchAll();
        //echo '<pre>'; var_dump($results); echo '</pre>'; die();
        
    //}

    //getAllPictures();
    foreach($results as $result){
        echo "<a href='index2.php/?base=".$result['file_name']."'><img src='assets/img/".$result['file_name']."'></a>";
    }
?>