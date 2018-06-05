<?php
    
    require_once './vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem('./views');
    $twig = new Twig_Environment($loader, [
      'cache' => false
    ]);
    
    require 'pdo.php';
    require __DIR__.'/controlers/MemeControler.php';
    

    
    
    switch($_GET['page']) {
        case 'home':
            getAllPictures();
        break;
    
        case 'create':
            createMeme();
        break;
<<<<<<< HEAD

        case 'generated':
            generateMemeCtrl();
=======
        
        case 'render':
            memegen_build_image();
>>>>>>> a0afbb1a659fbf3f27c7887bc0a6e63787a42859
        break;
    }

?>