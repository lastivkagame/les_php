<?php
require_once "config.php";
try {
    $dbh = new PDO(DB_DRIVER.":host=".DB_HOST.";dbname=".DB_NAME,
        DB_USER, DB_PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".DB_CHARSET));

        //seedAuto($dbh);
    } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

//add animals to db every page update
function  seedAuto($dbh)
{
    for ($i=50; $i < 60; $i++) {
        $name="Leo " . $i;
        $type="Dog";
        $image="manu.jpg";

        $stmt = $dbh->prepare("INSERT INTO animals (id, name,type, image) VALUES (NULL, :name, :type, :image);");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':image', $image);
        $stmt->execute();
        // $name="Leo";
        // $type="Dog";
        // $imag="manu.jpg";

        // $myPDO = new PDO('mysql:host=localhost;dbname=db_spu926', 'root', '');
        // $sql = "INSERT INO"
    }
}