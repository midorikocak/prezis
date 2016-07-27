<?php
    include('vendor/autoload.php');
    $preziFinder = new \MidoriKocak\PreziFinder(new \MidoriKocak\URLQueryParser(), new \MidoriKocak\PDOPreziList());
    echo $preziFinder->request($_SERVER['REQUEST_URI']);
?>
