<!-- Include connection to DB -->
<?php require_once "connection_database.php"; ?>

<!-- Include some need functions(for exaple base64_to_jpeg - that save image) -->
<?php include "funtions.php"; ?>


<?php

//fields in our table
$name = "";
$type = "";
$image = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  //get all value 
  $name = $_POST['name'];
  $type = $_POST['type'];
  $image = $_POST['image'];

  //it need becouse image contain image not name (and we need unique name)
  $image_name = uniqid() . ".png";
  
  //always something can went wrong
  $errors = [];

  //check
    if (empty($name)) {
        $_POST['image'] = $image; //if we reload page we need save image 
        $errors["name"] = "Name is required";
    } 
    else if (empty($type)) {
      $errors["type"] = "Type is required";
    }
    else if (empty($image)) {
        $errors["image"] = "Image is required";
    }else{
      //save image
        base64_to_jpeg($image, "img/" . $image_name);

        //save it in DB
        $stmt = $dbh->prepare("INSERT INTO animals (id, name,type, image) VALUES (NULL, :name, :type, :image);");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':image', $image_name);
        $stmt->execute();

      //return on home page
       header("Location: index.php");
        exit;
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

<!-- Add Animal Form -->
<div class="container">
    <div class="p-3">
        <h2>Add new animal</h2>
        <form validate method="post" class="d-flex">
          <div class="d-flex flex-column form-group " >

            <!--#region Image -->
            <?php if(!empty($image)){
              echo "<img src='$image' alt='Choose photo' class='img-thumbnail' style='cursor: pointer;' width='250' id='imgSelect' />
              <input type='hidden' id='image' name='image' value='$image' />"; }
            else{
              echo "<img src='img/no-image.png' alt='Choose photo' class='' style='cursor: pointer;' width='250' id='imgSelect' />
              <input type='hidden' id='image' name='image' />";
            } ?>

            <!-- <input type="hidden" id="image" name="image" /> -->
            <label class="form-check-label" style="color: blue" for="exampleRadios1">
              Click on image and choose Image 
            </label>
            <?php if(isset($errors['image']))
                    echo "<small class='text-danger'>{$errors['image']}</small>" ?>
            </div>
            <!--#endregion -->

            <!--#region Name and Type -->
            <div class="form-group" style="width:100%;margin-left: 30px;">
                <!--#region Name -->
                <label for="exampleInputEmail1">Animal name: </label>

                <?php
                if(isset($errors['name']))
                    echo "<small class='text-danger'>{$errors['name']}</small>"
                ?>

                <?php
                echo "<input type='text' name='name' class='form-control' style='width:100%;' id='exampleInputEmail1'
                           placeholder='Enter animal name' value={$name}>"
                ?>
                <!--#endregion -->

                <!--#region Type -->
                <label for="exampleInputEmail1" style='padding-top: 30px;'>Animal type: </label>

                <?php
                if(isset($errors['type']))
                    echo "<small class='text-danger'>{$errors['type']}</small>"
                ?>

                <?php
                echo "<input type='text' name='type' class='form-control' style='width:100%;' id='exampleInputEmail1'
                           placeholder='Enter animal type' value={$type}>"
                ?>

                <!--#endregion -->
            </div>
            <!--#endregion -->
             
  </div>
            <button style="width:100%;" type="submit" class="btn btn-warning mt-2">Submit</button>
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