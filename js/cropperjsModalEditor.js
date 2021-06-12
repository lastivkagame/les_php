//<script>
  $(function() {

    //get image whick we must edit
    const image = document.getElementById('image-modal');

    const cropper = new Cropper(image, {
            aspectRatio: 1 / 1,  //its do square
            preview: ".preview"
            // crop(event) {
            //     console.log(event.detail.x);
            //     console.log(event.detail.y);
            //     console.log(event.detail.width);
            //     console.log(event.detail.height);
            //     console.log(event.detail.rotate);
            //     console.log(event.detail.scaleX);
            //     console.log(event.detail.scaleY);
            // },
      });


    //if we click on image we must create uploader window 
    let $uploader;
    $("#imgSelect").on("click", function(){

      //create uploader window a
      $uploader=$('<input type="file" name="" accept="image/*" style="display: none;" />');
      $uploader.click();

      //when choosen image -> read it and write in our variable
      $uploader.on("change", function(){

        const [file] = $uploader[0].files

        if(file){
          var reader = new FileReader();
          reader.onload = function(event){
            var data = event.target.result;

            // console.log("--data--", data);

            //show modal for crop
            $("#croppedModal").modal("show");
            cropper.replace(data);
          }

          reader.readAsDataURL($uploader[0].files[0]);
        }
        
      });

    });

    //when we click 'crop image'
    $("#btnCropped").on("click", function(){
      var dataCropper = cropper.getCroppedCanvas().toDataURL(); //take image that user crop
      $("#imgSelect").attr("src", dataCropper); // set image
      $( "#imgSelect" ).addClass( 'img-thumbnail'); //class='img-thumbnail'
      $("#image").attr("value", dataCropper); //set value for elem where name='image'
      $("#croppedModal").modal("hide"); //close modal
    });
  });
//</script>