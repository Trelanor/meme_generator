<?php
    try{
    $bdd = new PDO('mysql:host=localhost;dbname=meme;charset=utf8', 'psaulay', '');
    }
    catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
    }
    $request = $bdd->prepare("SELECT *  FROM  usermeme  ORDER BY  id  DESC  LIMIT  10");
    $request->execute();
    $last_entries = $request->fetchAll();

    foreach($last_entries as $last_entrie){
        echo "<a href='generated_img/".$last_entrie["file_name"]."' download='".$last_entrie["file_name"]."'><img src='generated_img/".$last_entrie["file_name"]."'></a>";
    }
?>