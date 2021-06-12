<!-- Modal for Image Crop (By croppeerjs) -->
<div class="modal" id="croppedModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image Editor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Image which we crop -->
                        <img src="/img/bear.jpg" id="image-modal" width="100%" /> 
                    </div>
                    <div class="col-md-4">
                        <div class="preview ml-4"></div>
                    </div>
                </div>
                    <!-- <img class="myborder"  src="img/bear.jpg" width="100%" id="image-modal"  /> -->
                    <!-- <img class="rounded-circle z-depth-2" alt="100x100" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(31).jpg" data-holder-rendered="true"> -->
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnCropped" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>