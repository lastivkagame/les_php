//<script>
function loadDeleteModal(id, name)
{
  console.log("id: " + id + name);
    $(`#modalDeleteContent`).empty(); // do empty block

    //add info about item what delete and controls(ok / cancel)
    $(`#modalDeleteContent`).append(`<div class="modal-header"> 
        <h5 class="modal-title" id="exampleModalLabel">Delete animal ${name} (#${id})?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <form action="deleteAnimal.php" method="post">
            <input type='hidden' name='id' value='${id}'>
            <button type="submit" name="delete_submit" class="btn btn-danger">Delete</button>
        </form>
    </div>`);
}
//</script>