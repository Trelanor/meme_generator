<?php

	function memegen_build_image( $settings ) {
        list( $width, $height ) = getimagesize( $settings['memebase'] );

        $settings['textsize'] = empty( $settings['textsize'] ) ? round( $height/10 ) : $settings['textsize'];

        extract( $settings );

        // alright, lets make an image
        $im = imagecreatefromjpeg( $settings['memebase'] );

        // make base image transparent
        $black = imagecolorallocate( $im, 0, 0, 0 );
        imagecolortransparent( $im, $black );

        $textcolor = imagecolorallocate( $im, 255, 255, 255 );

        $angle = 0;

        $top_text = strtoupper( trim( $settings['top_text'] ) );
        $bottom_text = strtoupper( trim( $settings['bottom_text'] ) );

        $fit = isset( $textfit ) ? $textfit : true;
        // top layer text
        extract( memegen_font_size_guess( $textsize, ($width-$padding*2), $font, $top_text, $fit ) );
        $from_side = ($width - $box_width)/2;
        $from_top = $box_height + $padding;

        memegen_imagettfstroketext( $im, $fontsize, $angle, $from_side, $from_top, $textcolor, $black, $font, $top_text, 1 );
        // bottom layer text
        extract( memegen_font_size_guess( $textsize, ($width-$padding*2), $font, $bottom_text, $fit ) );
        $from_side = ($width - $box_width)/2;
        $from_top = $height - $padding;

        memegen_imagettfstroketext( $im, $fontsize, $angle, $from_side, $from_top, $textcolor, $black, $font, $bottom_text, 1 );

        $basename = basename( $settings['memebase'], '.jpg' );

        // output

        global $bdd;
        $bdd = connect();
        $basename2 = $basename.".jpg";
        $generatedFilename = uniqid().'.jpg';
        imagejpeg( $im , __DIR__.'/../generated_img/'.$generatedFilename);
        $base_id_request = $bdd->prepare("SELECT id FROM base WHERE file_name LIKE ?");
        $base_id_request->execute(array($basename2));
        $base = $base_id_request->fetch();
        $base_id = $base["id"];
        $upload = $bdd->prepare("INSERT INTO usermeme(file_name, base_id, creator_ip) VALUES('$generatedFilename','$base_id', '".get_ip()."')");
        $upload->execute();
        $server_url = $_SERVER['SERVER_NAME']."/meme_generator/";
        $img_name = $top_text.$basename2;
        header("Location: http://".$server_url."index.php?page=result&img_name=$img_name&file_name=$generatedFilename");
    }

    function memegen_font_size_guess( $fontsize, $imwidth, $font, $text, $fit ) {

        $angle = 0;
        $_box = imageftbbox( $fontsize, $angle, $font, $text );
        $box_width = $_box[4] - $_box[6];
        $box_height = $_box[3] - $_box[5];

        if ( $box_width > $imwidth && $fit ) {
            $sub = 1;
            $fontsize = $fontsize - $sub;
            return memegen_font_size_guess( $fontsize, $imwidth, $font, $text, $fit );
        }

        return compact( 'fontsize', 'box_width', 'box_height' );
    }

    function memegen_imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

        return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }

    function memegen_sanitize( $input ) {
        $input = preg_replace( '/[^a-zA-Z0-9-_]/', '-', $input );
        $input = preg_replace( '/--*/', '-', $input );
        return $input;
    }

?>
