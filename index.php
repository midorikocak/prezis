<?php
    include('vendor/autoload.php');

    $app = new \MidoriKocak\PreziFinder('data/prezis.json');
    echo $app->prezis();
?>