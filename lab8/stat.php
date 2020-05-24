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
    $query = "INSERT INTO visits (visit_time) VALUES (now())";
    $connection->query($query);