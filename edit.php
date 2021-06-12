<!-- Include connection to DB -->
<?php require_once "connection_database.php"; ?>

<!-- Include some need functions(for exaple base64_to_jpeg - that save image) -->
<?php include "funtions.php"; ?>

<!-- Edit Animal -->
<?php

//variables
$id = null;
$name = "";
$type = "";
$image = "";
$old_image = "";
$file_loading_error = [];

//initialize all fields
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //get item thar we edit
    $id = $_GET["id"];
    $command = $dbh->prepare("SELECT id, name, type, image FROM animals WHERE id = :id");
    $command->bindParam(':id', $id);
    $command->execute();
    $row = $command->fetch(PDO::FETCH_ASSOC);

    //initialize
    $name = $row['name'];
    $type = $row['type'];
    $image = $row['image']; 
    $old_image = $row['image']; //if we change image we must compare images
    //echo $old_image;
    //$image_to_show = $row['image']; //image_to_show
    //echo $old_image;
}

//after change that user do heck and update item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //get new value
    $name = $_POST['name'];
    $type = $_POST['type'];
    $image = $_POST['image'];
    $old_image = $_POST['old_image'];
    $id = $_POST['id'];
    $errors = [];

    //check
    if (empty($name)) {
        $errors["name"] = "Name is required";
      }
    else if (empty($type)) {
        $errors["type"] = "Type is required";
      }
    else if (empty($image)) {
        $errors["image"] = "Image is required";
      }
    else {

        $stmt = $dbh->prepare("UPDATE animals SET name = :name, type = :type, image = :image WHERE animals.id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);

        //if image change thenfore we must re-save it
        if($old_image == $image)
        {
          $stmt->bindParam(':image', $image);
        }
        else
        {
          //$image_name = "";//uniqid() . ".png";
          base64_to_jpeg($image, "img/" . $old_image);
          $stmt->bindParam(':image', $old_image);
        }

        $stmt->execute();
        
        header("Location: index.php");

       //This can be useful henfore clean it a bit later
        // Allow certain file formats
                // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                //     && $imageFileType != "gif") {
                //     array_push($file_loading_error, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                //     $uploadOk = 0;
                // }
                
        // Check if image file is a actual image or fake image
                // if (isset($_POST["submit"])) {
                //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                //     if ($check !== false) {
                //         $uploadOk = 1;
                //     } else {
                //         array_push($file_loading_error, "File is not an image.");
                //         $uploadOk = 0;
                //     }
                // }
                
        // Check file size
                // if ($_FILES["fileToUpload"]["size"] > 500000) {
                //     array_push($file_loading_error, "Sorry, your file is too large.");
                //     $uploadOk = 0;
                // }
                
        // Check if $uploadOk is set to 0 by an error
        //         if ($uploadOk == 0) {
        //             array_push($file_loading_error, "Sorry, your file was not uploaded.");
        // // if everything is ok, try to upload file
        //         } else {
        //             if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //                 $stmt = $dbh->prepare("UPDATE animals SET name = :name, image = :image WHERE animals.id = :id;");
        //                 $stmt->bindParam(':id', $id);
        //                 $stmt->bindParam(':name', $name);
        //                 $stmt->bindParam(':image', $target_file);
        //                 $stmt->execute();
        //                 header("Location: index.php");
        //                 exit;
        //             } else {
        //                 array_push($file_loading_error, "Sorry, there was an error uploading your file.");
        //             }
        //         }


    }
}
?>

<!-- Include Up Menu(Navbar and links) -->
<?php include "head.php"; ?>

<!-- Some style for Image (when user choose and crop it) -->
<style>
 .preview{
   overflow: hidden;
   width: 200px !important;
   height: 200px !important;
   border-radius: 50%;
 }
</style>

<!-- There script for edit items  -->
<script src="js/updateItem.js" ></script>

<!-- Edit Container -->
<div class="container">
    <div class="p-3">
        <h2>Edit animal</h2>
        <form name="editAnimal" onsubmit="return updateAnimal();" method="post" enctype="multipart/form-data" >

         <!--#region Item ID -->
            <?php
            if ($id != null)
                echo "<input name='id' value='$id' hidden>"
            ?>
          <!--#endregion  -->
          
          <!--#region Info -->
            <section class="d-flex">
              <div class="d-flex flex-column form-group " >
              <!-- <img src="img/no-image.png" alt="Choose photo" class="" style="cursor: pointer;" width="250" id="imgSelect" /> -->

              <!--#region Image -->
              <!-- If image exist -> show it if not -> show noimage.png -->
              <?php
               if(!empty($image)){
               echo "<img src='img/$image' alt='Choose photo' class='img-thumbnail' style='cursor: pointer;' width='350' id='imgSelect' />
                <input type='hidden' id='image' name='image' value='$image' />"; }
               else{
                  echo "<img src='img/no-image.png' alt='Choose photo' class='' style='cursor: pointer;' width='350' id='imgSelect' />
                  <input type='hidden' id='image' name='image' />
                  ";
                }
                echo "<input type='hidden' id='old_image' name='old_image' value='$old_image' />";
           ?>
  
            <label class="form-check-label" style="color: blue" for="exampleRadios1">
              Click on image and choose Image 
            </label>
            <?php if(isset($errors['image']))
                    echo "<small class='text-danger'>{$errors['image']}</small>" ?>
            </div>
            <!--#endregion  -->

            <!--#region Ino -->
            <div class="form-group" style="margin-left: 30px; width:100%;">

                 <!--#region Name -->
                <label for="exampleInputEmail1">Animal name: </label>

                <?php
                if (isset($errors['name']))
                    echo "<small class='text-danger'>{$errors['name']}</small>"
                ?>
                <small class='text-danger' id="name_error" hidden>Name is required!</small>
                
                <?php
                echo "<input type='text' name='name' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal name' style='width:100%;' value={$name}>"
                ?>
                <!--#endregion  -->

                <!--#region Name -->
                <label for="exampleInputEmail1" style='margin-top: 30px;'>Animal type: </label>
                <?php
                if (isset($errors['type']))
                    echo "<small class='text-danger'>{$errors['type']}</small>"
                ?>
                <small class='text-danger' id="type_error" hidden>Type is required!</small>
                              
                <?php
                echo "<input type='text' name='type' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal type' style='width:100%;' value={$type}>"
                ?>
                <!--#endregion  -->
            </div>
            </section>
             <!--#endregion  -->
         <!--#endregion  -->
            <button type="submit" class="btn btn-warning mt-2" style="width: 100%;" >Save changes</button>
        </form>
    </div>
</div>

<!-- Image Modal (where image crop (cropersjs)) -->
<?php include "modal_image.php"; ?>

<!-- Scripts -->
<!-- <script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script> -->
<script src="js/cropper.min.js"></script> 

<!-- Script that show modal for Crop Image -->
<script src="js/cropperjsModalEditor.js"></script>

<?php include "footer.php"; ?>