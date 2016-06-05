<?php
    include('vendor/autoload.php');

    $app = new \MidoriKocak\App('data/prezis.json');
    echo $app->prezis();
?>