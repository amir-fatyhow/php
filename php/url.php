<?php

    /**
     *  template :
     *              ?ax=0&ay=0&az=0&bx=3&by=0bz=0&cx=3&cy=0&cz=3
     */

    use mysql\mySql;

    try
    {

        $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        $ax = $query['ax'];
        $ay = $query['ay'];
        $az = $query['az'];

        $bx = $query['bx'];
        $by = $query['by'];
        $bz = $query['bz'];

        $cx = $query['cx'];
        $cy = $query['cy'];
        $cz = $query['cz'];

        $mySql = new mySql();

        $answer = $mySql->connectToMysql($ax, $ay, $az, $bx, $by, $bz, $cx, $cy, $cz);
    } catch (Exception $e)
    {

    }

