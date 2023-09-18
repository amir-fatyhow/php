<?php
    require_once('mysql.php');
    use mysql\mySql;

    $ax = floatval($_POST["ax"]);
    $ay = floatval($_POST["ay"]);
    $az = floatval($_POST["az"]);

    $bx = floatval($_POST["bx"]);
    $by = floatval($_POST["by"]);
    $bz = floatval($_POST["bz"]);

    $cx = floatval($_POST["cx"]);
    $cy = floatval($_POST["cy"]);
    $cz = floatval($_POST["cz"]);

    $mySql = new mySql();
    echo $answer = $mySql->connectToMysql($ax, $ay, $az, $bx, $by, $bz, $cx, $cy, $cz);








