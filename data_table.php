<!-- Include Connection to DB -->
<?php require_once "connection_database.php"; ?> 

<!-- Include Modal for Delete Items-->
<?php include "modal.php"; ?>

<?php 
  $name="";
  if(isset($_GET["name"])){
    $name = $_GET["name"];
  }
?>

<form method="get">
<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" >
  </div>
    <button class="btn btn-outline-warning" type="submit" name="btnSearch" id="btnSearch">Search</button>
</form>

<h2> List of Animal</h2>
<div class="container">
     <!--#region Table with all items(with paggination)  -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>type</th>
            <th>image</th>
            <th></th>
            <th></th>
        </tr>
        </thead>

        <?php

        //Pagination
        $page_size = 3; // count of element on one page
        $page_number = 1; //current page

        //get and set current page
        if(isset($_GET["page"])){
          $page_number = $_GET["page"];
        }

        $where = "where name LIKE :name";
        $sql = "SELECT COUNT(*) as animal_count FROM `animals` ".$where;


        //select count/(lenght) of all items from table animals in DB
        //$sql = "SELECT COUNT(*) AS animal_count FROM animals" .$where;
        $command = $dbh->prepare($sql);
        $command->execute(["name"=> '%'.$name.'%']);

        //get and write count/(lenght) in our value
        $count_items=0;
        if ($count_animals = $command->fetch(PDO::FETCH_ASSOC)){
          $count_items = $count_animals["animal_count"];
        }

        //calculate how many pages we need (ceil - get number int)
        $pages = ceil($count_items / $page_size);

        //select items from table animals in DB in right amount(such as page_size = 3 -> first select 0-3 next 3-6 and next) //$page_number - which started, $page_size - how many element show 
        //$command = $dbh->prepare("SELECT id, name, type, image FROM animals LIMIT " . ($page_number - 1)* $page_size .", " . $page_size);
        $command = $dbh->prepare("SELECT id, name, type, image FROM animals " . $where . " LIMIT ". ($page_number - 1)* $page_size . ", " . $page_size);
        //$command->execute();
        $command->execute(["name"=> '%'.$name.'%']);

        //show our animals
        while ($row = $command->fetch(PDO::FETCH_ASSOC))
        {
            echo"
            <tr>
            <td>{$row["id"]}</td>
            <td>{$row["name"]}</td>
            <td>{$row["type"]}</td>
            <td><img style='width: 200px; height=200px;' src='img/{$row["image"]}' class='img-thumbnail' alt='Animal image'></td>
            <td><a class='btn btn-dark' href='edit.php?id={$row["id"]}'>Edit  <i class='far fa-edit'></i></td>
            <td>
                <button  onclick='loadDeleteModal({$row["id"]}, `{$row["name"]}`)' data-toggle='modal' data-target='#modalDelete' class='btn btn-danger' >Delete  <i class='fas fa-trash-alt'></i></button>
            </td>
            </tr>";
        }

        ?>
  </table>
</div>
<!--#region Paggination(Controls(buttons))  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <?php 

    
    //button '-' if we click -> current page-1 (we must back on 1 page)
    if(isset($_GET['page']))
    {
      $current_page = $_GET['page']; //get current page
      if($_GET['page'] == 1) //if page == 1 we cant do -1 -> we need back to last
      { 
        $current_page = $pages;
      }
      else{
        $current_page-=1;
      }
      echo "<li class='page-item'><a class='page-link' href='?page=" . $current_page . "'> &laquo; </a></li>";
    }
    else{ 
      //page not exist -> began from last page
      echo "<li class='page-item'><a class='page-link' href='?page=" . $pages . "'> &laquo; </a></li>";
    }

    // $elem_count=5;
    // $centre_elem_count = 8;
    // $begin_elem_count=2;
    // $step = 2;

    // // $current_page = 1;
    // // try {
    // //   $current_page = $_GET['page']; //get current page
    // // }
    // // catch (Exception $e) {
    // //   $current_page = 1;
    // // }

    // $current_page=1;
    // if(isset($_GET['page'])){
    //   $current_page = $_GET['page'];
    // }
    // else{
    //   $current_page=1;
    // }

    // if($current_page < $elem_count)
    // {
    //     for ($i=1; $i <= $elem_count; $i++) { 
    //       $active="active";
    //       if($current_page != $i){
    //         $active = "";
    //       }
    //         echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
    //     }

    //     echo "<li class='page-item'><a class='page-link' href='#'> ... </a></li>";
    //     echo "<li class='page-item'><a class='page-link' href='?page=$pages'>$pages</a></li>";
    // }
    // else if($current_page >= $elem_count && $current_page <= ($pages - $elem_count)){

      
    //   for ($i=1; $i <= $begin_elem_count; $i++) { 
    //       echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
    //   }

    //   echo "<li class='page-item'><a class='page-link' href='#'> ... </a></li>";

    //   $elem_back = $current_page - $step;
    //   $elem_to = $current_page + $step;

    //   for ($i=$elem_back; $i <= $elem_to; $i++) { 
    //     $active="active";
    //       if($current_page != $i){
    //         $active = "";
    //       }
    //         echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
    //   }

    //   echo "<li class='page-item'><a class='page-link' href='#'> ... </a></li>";
    //   echo "<li class='page-item'><a class='page-link' href='?page=$pages'>$pages</a></li>";
    // }
    // else{
    //     for ($i=1; $i <= $begin_elem_count; $i++) { 
    //       echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
    //   }

    //   echo "<li class='page-item'><a class='page-link' href='#'> ... </a></li>";
      
    //   $elem_back = $pages - $elem_count;

    //   for ($i=$elem_back; $i <= $pages; $i++) { 
    //     $active="active";
    //       if($current_page != $i){
    //         $active = "";
    //       }
    //         echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
    //   }
    // }


    $show_begin=13;
        for($i=1;$i<=$pages;$i++)
        {
            $active ="active";
            if($i!=$current_page)
                $active = "";
            if($current_page<=8 and $i<=$show_begin)  {
                echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}&name={$name}'>{$i}</a></li>";
            }

            if($current_page>=9)
            {
                if($i<=3) {
                    echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}&name={$name}'>{$i}</a></li>";
                }
                else if($i==4) {
                    echo "<li class='page-item'><a class='page-link' href='?page={$i}&name={$name}'>...</a></li>";
                }
                else if(($current_page-4)<=$i && $i<=($current_page+5)) {
                    echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}&name={$name}'>{$i}</a></li>";
                }
            }

            //echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
        }
        if(($current_page+6)<$i) {
            $i--;
            echo "<li class='page-item'><a class='page-link' href='?page={$i}&name={$name}'>...</a></li>";
            echo "<li class='page-item'><a class='page-link' href='?page={$i}&name={$name}'>$i</a></li>";
        }




    //show all page with clickabed buttons(pages)
    // for ($i=1; $i <= $pages; $i++) { 

    //   $active="active";
    //   if($current_page != $i){
    //     $active = "";
    //   }
    //     echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
      
    //   //echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
    //   //<li class="page-item active" aria-current="page"><a class="page-link" href="#">2</a></li>
    // }

    //button '+' if we click -> current page+1 (we must forward on 1 page)
    if(isset($_GET['page']))
    {
      $current_page = $_GET['page']; //get current page
      if($_GET['page'] == $pages) //if page == last page we cant do +1 -> we need back to first
      {
        $current_page = 1;
      }
      else{
        $current_page+=1;
      }
      echo "<li class='page-item'><a class='page-link' href='?page=" . $current_page . "'> &raquo; </a></li>";
    }
    else{
      echo "<li class='page-item'><a class='page-link' href='?page=1'> &raquo; </a></li>";
    }
    ?>
    
  </ul>
</nav>
 <!--#endregion-->
 <!--#endregion-->

 <!-- Include AJAX-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- There script for delete items (it call modal) -->
<script src="js/deleteItem.js" ></script>

