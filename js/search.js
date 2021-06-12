function search(e){
    e.preventDefault();

    let search_line = document.querySelector('#search_line').value;
    if(search_line == null || search_line.length === 0)
    {
        return;
    }

    window.location.href = "/search.php?q=" + search_line;
}

document.querySelector('button#btn_search').addEventListener('click', search);