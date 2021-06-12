<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cropper.js</title>
  <!-- <link rel="stylesheet" href="dist/cropper.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.css" />
  
  <style>
    .container {
      max-width: 640px;
      margin: 20px auto;
    }


    img {
      max-width: 100%;
    }
  </style>
</head>
<body>



  <div class="container">
    <h1>Cropper with a range of aspect ratio</h1>
	
    <div>
      <img id="image" src="https://fengyuanchen.github.io/cropperjs/images/picture.jpg" alt="Picture">
    </div>
	<button onclick="cropper.getCroppedCanvas()">Save</button>
  </div>



  <!-- <script src="dist/cropper.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.js"></script>
  <script>


//     window.addEventListener('DOMContentLoaded', function () {
//       var image = document.querySelector('#image');
//       var minAspectRatio = 1.0;
//       var maxAspectRatio = 1.0;

//       var cropper = new Cropper(image, {
//          ready: function () {
//           var cropper = this.cropper;
//       cropper.getCroppedCanvas().toBlob(function (blob) {
//   var formData = new FormData();


//   formData.append('croppedImage', blob);

var cropper;
window.addEventListener('DOMContentLoaded', function () 
{

    cropper = new Cropper(image, { 

    cropper.getCroppedCanvas().toBlob(function (blob) {
  var formData = new FormData();


  formData.append('croppedImage', blob);



  // Use `jQuery.ajax` method
  $.ajax('/path/to/upload', {
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function () {
      console.log('Upload success');
    },
    error: function () {
      console.log('Upload error');
    }
  });

});
});
  // Use `jQuery.ajax` method
//   $.ajax('/path/to/upload', {
//     method: "POST",
//     data: formData,
//     processData: false,
//     contentType: false,
//     success: function () {
//       console.log('Upload success');
//     },
//     error: function () {
//       console.log('Upload error');
//     }
//   });
});

    //   var cropper = new Cropper(image, {
    //     ready: function () {
    //       var cropper = this.cropper;
    //       var containerData = cropper.getContainerData();
    //       var cropBoxData = cropper.getCropBoxData();
    //       var aspectRatio = cropBoxData.width / cropBoxData.height;
    //       var newCropBoxWidth;



    //       if (aspectRatio < minAspectRatio || aspectRatio > maxAspectRatio) {
    //         newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);



    //         cropper.setCropBoxData({
    //           left: (containerData.width - newCropBoxWidth) / 2,
    //           width: newCropBoxWidth
    //         });
    //       }
    //     },
    //     cropmove: function () {
    //       var cropper = this.cropper;
    //       var cropBoxData = cropper.getCropBoxData();
    //       var aspectRatio = cropBoxData.width / cropBoxData.height;



    //       if (aspectRatio < minAspectRatio) {
    //         cropper.setCropBoxData({
    //           width: cropBoxData.height * minAspectRatio
    //         });
    //       } else if (aspectRatio > maxAspectRatio) {
    //         cropper.setCropBoxData({
    //           width: cropBoxData.height * maxAspectRatio
    //         });
    //       }
    //     }
    //   });
    });
  </script>

<?php include "footer.php"; ?>
  <!-- FULL DOCUMENTATION ON https://github.com/fengyuanchen/cropperjs -->
  <!-- My question is: How do i get the cropped image and upload via php ? -->
 
</body>
</html>