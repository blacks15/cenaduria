<div class="content" id="pagesContainer">
    <?php
        use app\http\Get;
        include(RUTA_HTTP."/get.php");
        
        Get::View($_GET);
    ?>
</div>