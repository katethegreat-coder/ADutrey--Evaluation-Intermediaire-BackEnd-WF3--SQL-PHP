<?php
    // Connect to the DB
    try {
        $db=new PDO('mysql:host=localhost;dbname=immobilier', 'root', '');
        $db->exec('SETNAMES"UTF8"');
    } catch(PDOException $e) {
        echo"Error:".$e->getMessage();
        die;
}