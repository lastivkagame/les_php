//<script>
    function updateAnimal() {
        $(`#name_error`).attr("hidden", true);
        var name = document.forms[`editAnimal`][`name`];
        if (name.value == '') {
            $(`#name_error`).attr("hidden", false);
            event.preventDefault()
        }
    }
//</script>