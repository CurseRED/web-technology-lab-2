<?php
    $username = 'root';
    $servername = 'localhost';
    $password = '';
    $dbname = 'server_stats';
    $connection = new mysqli($servername, $username, $password, $dbname);
    $connection->set_charset('UTF8');
    $connection->query("SET CHARACTER SET 'UTF8'");
    $connection->query("SET CHARSET 'UTF8'");
    $connection->query("SET NAMES 'UTF8'");
    $ip = getRealIpAddr();
    // $_SERVER['HTTP_HOST'];
    // $_SERVER['REQUEST_URI'];
    $query = "INSERT INTO visits (visit_time) VALUES (now())";
    $connection->query($query);

    function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        { $ip=$_SERVER['HTTP_CLIENT_IP']; }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        { $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; }
        else { $ip=$_SERVER['REMOTE_ADDR']; }
        return $ip;
    }