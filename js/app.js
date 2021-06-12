let ImageToWriting = document.getElementById("ImageToWriting");


function NotReload(e) {
    e.preventDefault();
}


function ImageLogic(name_active, name_not_active) {
    let el = document.getElementById(name_active);
    let el2 = document.getElementById(name_not_active);

    // if(document.getElementById(name).disabled)
    // {
    //     document.getElementById(name).disabled =
    // }

    el.value = "";
    el2.value = "";
    el.disabled = true ? false : !document.getElementById(name_active).disabled;
    el2.disabled = !el.disabled;
    document.getElementById("imagePreview").src = "";

    let show_btn = document.getElementById("URLbuttton");

    if(show_btn.style.display == "block" || show_btn.style.display == ""){
        show_btn.style.display = "none";
    }
    else{
        show_btn.style.display = "block";
    }
}

function SetImage() {
    let el = document.getElementById("validationURLImage");
    let el2 = document.getElementById("validationFileImage");
    let my_img = document.getElementById("imagePreview");
    

    if (el.disabled) {
        my_img.src = el2.path;
    }
    else {
        my_img.src = el.value;
    }

    ImageToWriting.value = el.value;
}

function previewFile() {
    var preview = document.getElementById("imagePreview");//document.querySelector('img');
    var file = document.querySelector('input[type=file]').files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        let image = reader.result;
        preview.src = image;
        ImageToWriting.value = image;

    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}

function previewUrl(){
    var preview = document.getElementById("imagePreview");
    var previewURL = document.getElementById("validationURLImage");//document.querySelector('img');
    
    // alert(previewURL.value);
    //     preview.src = previewURL.value;
    //     ImageToWriting.value = previewURL.value;

    
}


//   var p;
// var canvas = document.createElement("canvas");
// var img1=document.createElement("img"); 

// function getBase64Image(){     
//     p=document.getElementById("fileUpload").value;
//     img1.setAttribute('src', p); 
//     canvas.width = img1.width; 
//     canvas.height = img1.height; 
//     var ctx = canvas.getContext("2d"); 
//     ctx.drawImage(img1, 0, 0); 
//     var dataURL = canvas.toDataURL("image/png");
//     alert("from getbase64 function"+dataURL );    
//     return dataURL;
// } 