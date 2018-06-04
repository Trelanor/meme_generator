<?php
    include( 'functions.php' );
    // if form not submitted, show it and bail
    if ( !isset($_GET['first_paragraphe']) ){
        ?>
        <center>
            <form>
                <p>zone-texte1:<br/><input name="first_paragraphe"/></p>
                <p>zone-texte2:<br/><input name="second_paragraphe"/></p>
                <input hidden name="base" value="<?php echo $_GET['base'] ?>" />
                <p><input type="submit" /></p>
            </form>

            <?php
                $base = $_GET['base'];
                echo "<img src='../assets/img/".$base."'>";
            ?> 
        </center>
        <?php
        die();
    }

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
        'font'        => dirname(__FILE__) .'/font/Anton.ttf',
        'memebase'    => dirname(__FILE__) ."/assets/img/".$base."",
        'textsize'    => 40,
        'textfit'     => true,
        'padding'     => 10,
    );

    // create and output image
    memegen_build_image( $settings );
?>