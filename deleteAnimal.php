<?php require_once "connection_database.php"; ?>
<?php include "head.php"; ?>

<?php
echo $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];

    //select it element
    $command = $dbh->prepare("SELECT image FROM animals WHERE animals.id = :id");
    $command->bindParam(':id', $id);
    $command->execute();

    //now find image name and delete it image
    $res = $command->fetch(PDO::FETCH_OBJ);
    
    //get image
    $filename = "img/" . $res->image; //$_POST['delete_file'];
    //echo "file: " . $filename;

    //if exist delete
    if (file_exists($filename)) {
       unlink($filename);
    }
    else{
        echo 'Could not delete '.$filename.', file does not exist';
    }
      //echo 'File '.$filename.' has been deleted';
    // } else {
    //   echo 'Could not delete '.$filename.', file does not exist';
    // }
     

    //delete element from DB
   $command = $dbh->prepare("DELETE FROM animals WHERE animals.id = :id");
   $command->bindParam(':id', $id);
   $command->execute();
}

header("Location: index.php");
exit;
?>