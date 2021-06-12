<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Animal World</title>
    
    <!-- Bootstrap and JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    
    
    <!-- AJAX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.js"></script>
    
    <!-- Cropperjs (for image) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.css" />
    <link rel="stylesheet" href="css/cropper.min.css">
    
    <!-- My Styles -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
  <!--#region Header(menu and search)  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container" >
    <a class="navbar-brand" href="#">Animal World</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/php_animal/">Home <span class="sr-only"></span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/Animal_php/">Home2 <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="add.php">ADD Animal</a>
      </li>
    </ul>
    <!--#region Search  -->
    <form class="d-flex">
        <input class="form-control me-2" name="searchbar" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-warning" type="submit" onClick="SearchAnimals()" name="btnSearch" id="btnSearch">Search</button>
        <!-- <form class="d-flex col-4">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search_line">
            <button class="btn btn-outline-success" type="submit" id="btn_search"><i class="bi bi-search"></i></button>
        </form> -->
        <!-- <form action="">  
        Search: <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="term" /><br />  
        <input type="submit" class="btn btn-outline-warning" value="Search" />  </form>   -->

        <!-- ?php
        if (!empty($_REQUEST['term'])) {
        echo "s";
        $term = mysql_real_escape_string($_REQUEST['term']);     
        
        $sql = "SELECT * FROM animals WHERE name LIKE '%".$term."%'"; 
        $r_query = mysql_query($sql); 
        echo "something";
        
        while ($row = mysql_fetch_array($r_query)){  
        echo 'Primary key: ' .$row['PRIMARYKEY'];  
        echo '<br /> Code: ' .$row['name'];   
        }  }?> -->
      </form>
      <!--#endregion -->
    </div>
  </div>
</nav>
<!--#endregion -->
<!--#region Main  -->
    <div class="container mt-5" >