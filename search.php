<?php

    require_once 'header.php';
    require_once 'database.php';

    if(!isset($_GET['q'])){
        header('Location: /index.php');
        exit();
    }

    $q = $_GET['q'];
    if(!isset($_GET['page'])){
        $page = 1;
    }
    else{
        $page = htmlspecialchars(($_GET['page']));
    };

    $num_results_on_page = 5;
    $calc_page = ($page - 1) * $num_results_on_page;
    $pattern = '%'.$q.'%';

    $pdo = Database::connect();
    $sql = 'SELECT Count(*) as count FROM customers where name like ? or last_name Like ?';
    $stmt = new mysqli_stmt($pdo, $sql);
    $stmt->bind_param('ss',$pattern, $pattern);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $count_rows = $data['count'];
    $stmt->close();
?>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading"><i class="bi bi-info-circle-fill btn-lg"></i>Result search: `<i><?php echo $q?></i>`</h4>
    <hr>
    <p><i class="bi bi-search"></i> <span class="badge bg-secondary">Count: <?php echo $count_rows?></span></p>
</div>

<?php
    $pdo = Database::connect();
    $sql = 'SELECT * from customers where name like ? or last_name Like ? LIMIT ?,?';
    $stmt = new mysqli_stmt($pdo, $sql);
    $stmt->bind_param('ssii',$pattern, $pattern, $calc_page, $num_results_on_page);
    $stmt->execute();
    $data = $stmt->get_result();

    if($count_rows > 0){ ?>
        <div>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Img</th>
                  <th>Name</th>
                  <th>Last name</th>
                  <th>Email Address</th>
                  <th>Mobile Number</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                    <?php
                        foreach ($data->fetch_all() as $row) {
                            echo '<tr>';
                            echo "<td width=105><div class='profile_photo'>";
                            $picture = !is_null($row[5])?$row[5]:"empty.jpg";
                            echo "<img src='img/$picture' class='img-thumbnail profile_photo'>";
                            echo "</div></td>";
                            echo '<td>' . $row[1] . '</td>';
                            echo '<td>' . $row[2] . '</td>';
                            echo '<td>' . $row[3] . '</td>';
                            echo '<td>' . $row[4] . '</td>';
                            echo '<td width=250>';
                            echo '<a class="btn btn-success" href="read.php?id='.$row[1].'"><i class="bi bi-eye"></i></a>';
                            echo ' ';
                            echo '<a class="btn btn-warning" href="update.php?id='.$row[1].'"><i class="bi bi-pencil-square"></i></a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$row[1].'"><i class="bi bi-trash-fill"></i></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
              </tbody>
            </table>
        </div>

        <?php
            $stmt->close();
            Database::disconnect();

            if (ceil($count_rows / $num_results_on_page) > 0): ?>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=<?php echo $page-1 ?>&q=<?php echo $q ?>">Prev</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=1&q=<?php echo $q ?>">1</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page-2 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=<?php echo $page-2 ?>&q=<?php echo $q ?>">
                                <?php echo $page-2 ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page-1 > 0): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=<?php echo $page-1 ?>&q=<?php echo $q ?>"><?php echo $page-1 ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="search.php?page=<?php echo $page ?>&q=<?php echo $q ?>"><?php echo $page ?></a>
                    </li>

                    <?php if ($page+1 < ceil($count_rows / $num_results_on_page)+1): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=<?php echo $page+1 ?>&q=<?php echo $q ?>">
                                <?php echo $page+1 ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($page+2 < ceil($count_rows / $num_results_on_page)+1): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=<?php echo $page+2 ?>&q=<?php echo $q ?>">
                                <?php echo $page+2 ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($count_rows / $num_results_on_page)-2): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=<?php echo ceil($count_rows / $num_results_on_page) ?>&q=<?php echo $q ?>">
                                <?php echo ceil($count_rows / $num_results_on_page) ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < ceil($count_rows / $num_results_on_page)): ?>
                        <li class="page-item">
                            <a class="page-link" href="search.php?page=<?php echo $page+1 ?>&q=<?php echo $q ?>">Next</a>
                        </li>
                    <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="/">Back</a>
                        </li>
                </ul>
            <?php endif;
            } else
            { ?>
                <div class="alert alert-warning" role="alert">
                    <strong>
                        <i class="bi bi-info-square"></i> Not found...(((
                    </strong>
                </div>
            <?php
            }
?>




//<?php

//search.php

// if(isset($_GET["query"]))
// {
// 	$query = urldecode($_GET["query"]);

// 	$query = preg_replace("#[^a-z 0-9?!]#i", "", $query);
// }

// if(!isset($query))
// {
//     header("Location: index.php");
// }
// else
// {
// 	include('head.php');

// ?>
	
// 		<div class="row">
// 			<div class="col-md-9">
// 				<h3>Search Result for <b><?php echo $query; ?></b></h3>
// 				<div id="search_result_area">
// 					<div class="wrapper-preview">
// 						<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
// 					</div>
// 				</div>
// 			</div>
// 		</div>


// 		<script>
// 		$(document).ready(function(){
// 			var query_result = "<?php echo $query; ?>";

// 			$('#searchbar').val(query_result);

// 			load_data(query_result, 1);

// 			function load_data(query_result, page)
// 			{
// 				$.ajax({
// 					url:"search_action.php",
// 					method:"POST",
// 					data:{query_result:query_result, page:page},
// 					success:function(data)
// 					{
// 						$('#search_result_area').html(data);
// 					}
// 				})
// 			}

// 			$(document).on('click', '.page-link', function(){
// 				var page = $(this).data('page_number');

// 				if(page > 0)
// 				{
// 					load_data(query_result, page);
// 				}
// 			});

// 			$(document).on('click', '.request_button', function(){
// 				var to_id = $(this).data('userid');

// 				var action = 'send_request';

// 				if(to_id > 0)
// 				{	
// 					$.ajax({
// 						url:"friend_action.php",
// 						method:"POST",
// 						data:{to_id:to_id, action:action},
// 						beforeSend:function()
// 						{
// 							$('#request_button_'+to_id).attr('disabled', 'disabled');
// 							$('#request_button_'+to_id).html('<i class="fa fa-circle-o-notch fa-spin"></i> Sending...');
// 						},
// 						success:function(data)
// 						{
// 							$('#request_button_'+to_id).html('<i class="fa fa-clock-o" aria-hidden="true"></i> Request Send');
// 						}
// 					});
// 				}

// 			});

// 		});
// 		</script>
// <?php

// 	include('footer.php');
// }

// ?>


// <!-- <?php 

// //search.php

// if(isset($_GET["query"])){

//     $query = urldecode($_GET["query"]);

//     $query = preg_replace("#[^a-z 0-9?!]#i", "", $query);
// }

// if(isset($query)){
//     header("Location: index.php");
// }
// else{
//     include('head.php');
    ?>
    
    <div class="row">
        <div class="col-md-9">
            <h3>Search Resalt for <b><?php echo $query; ?></h3>
            </b></h3>
            <div id="search_result_area">
                <div class="wrapper-preview">
                    <i class="fa fa-circle-o-notch fa-spin" style="font-size: 24px"></i>
                </div> 
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            var query_result = "<?php echo $query; ?>";

            $('#searchbar').val(query_result);

            function load_data(query_result, page){
                $.ajax({
                    url: "search_action.php",
                    method: "POST",
                    data: {query_result: query_result, page: page},
                    success: function(data){
                        $('#search_result_area').html(data);
                    }
                });
            }
        });
    </script>

    <?php
    include('footer.php');
}

?> -->