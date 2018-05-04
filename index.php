<?php  
  require_once("lib/db_files/db_functions.php");
  $db = new db();
  session_start();
  $bloodgroup_list=$db->getAll("SELECT * FROM blood_group");
  $msg = "";
  $even=0;
  if (isset($_POST['requestBlood'])) {
      if(isset($_SESSION['username'])){
            if($_SESSION['user_type']=="receiver"){
                  // receiving the post parameters
                  $sample_id = $_POST['key'];
                  // call the method to request all samples available and show msg based on result
                  $result = $db->requestBlood($_SESSION['username'],$sample_id);
                  if(is_null($result)){
                      $msg = "Some error occured. Please try again.";
                  }else{
                      $msg = "Request of blood is successful.";
                  }
            }else{
                  $msg = "You are currently login as hospital user.<br>Login as recevier to request blood.
                         <a href='lib/logout.php'>Click here to Login</a>";
            }
      }else{
                  $msg = "<br>You have to Login to request blood. <a href='login_page.php'>Click here to Login</a>";
      }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/compiled.min.css">
    
    <title>Available Blood Samples</title>
  </head>
  <body>

    <!--Header-->
      <header>
        <nav class="navbar fixed-top navbar-expand-lg mb-5 navbar-dark unique-color scrolling-navbar">
            <a class="navbar-brand font-weight-bold" href="index.php">Blood Bank System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  ml-auto">
                  <?php 
                      if(isset($_SESSION['username'])){
                         echo '<li class="nav-item">
                               <a class="nav-link" href="lib/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                               </li> ';
                      }else{
                        echo '<li class="nav-item">
                               <a class="nav-link" href="login_page.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                               </li> ';
                      }
                  ?>  
                </ul>
            </div>
        </nav>
      </header>
    <!--/.Header-->
    <!-- Container -->
    <div class="container-fluid">
       <!-- Row 1 -->
       <div class="row text-center justify-content-center mt-5">
         <p class="red-text mt-5"> <?php echo $msg; ?> </p>
       </div>
       <!-- /. Row 1 -->
       <!-- Row 2 -->
       <div class="row text-center justify-content-center">
            <div class="card p-2">
                <input type="text" id="searchInput" class="form-control" onkeyup="searchFilter()" placeholder="Search hospital name">
            </div>    
       </div>
       <!-- /. Row 2 -->
       <!-- Row 3 -->
       <div class="row justify-content-center mt-5">
        <div class="col-md-8 col-sm-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified primary-color">
                  <?php foreach($bloodgroup_list as $bloodgroup){ ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if($even==0){echo "active";}?>" data-toggle="tab" href="<?php echo "#panel".$bloodgroup["bloodgroup_id"];?>" role="tab"> <?php echo $bloodgroup["bloodgroup_name"];?></a>
                    </li>
                  <?php
                          $even=1;
                        }      
                  ?>
            </ul>
            <!-- /. Nav tabs -->
            <!-- Tab Panels -->
            <div class="tab-content card" id="tableDetails">
              <?php foreach($bloodgroup_list as $bloodgroup){ ?>
              <div class="tab-pane fade <?php if($even==1){echo "in show active";}?>" id="<?php echo "panel".$bloodgroup["bloodgroup_id"];?>" role="tabpanel">
                <table  class="table table-hover table-responsive-md table-fixed">
                  <thead class="blue-grey lighten-4">
                    <tr >
                      <th>Hospital Name</th>
                      <th>Mobile number</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        $even=2;
                        $request_array = $db->getAllAvailableSamples($bloodgroup["bloodgroup_id"]);
                        if (!empty($request_array)) { 
                           foreach($request_array as $key=>$value){ 
                      ?>
                            <tr>
                              <td><?php echo $request_array[$key]["hospital_name"]; ?></td>
                              <td><?php echo $request_array[$key]["mobile_no"]; ?></td>
                              <td> 
                               <form name="requestBlood" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                 <input type="hidden" name="key" value="<?php echo $request_array[$key]["sample_id"];?>" >
                                 <button type="submit" name="requestBlood" class="btn btn-indigo btn-rounded btn-sm my-0"  >Request </button> 
                               </form>
                              </td>
                            </tr>
                      <?php
                            }
                        }
                      ?>  
                  </tbody>
                </table>
              </div>
              <?php } ?>
            </div>
            <!--/. Tab Panels -->
        </div>  
       </div>  
       <!-- /. Row 3 -->
    </div>
     <!-- /. Container -->

    <!-- Bootstrap js -->
    <script src="js/compiled.min.js"></script>
    <!-- FontAwesome -->
    <script defer src="js/fontawesome-all.min.js"></script>
    <!-- Material Select Initialization -->
    <script type="text/javascript">

      $(document).ready(function() {
        $('.mdb-select').material_select();
      });

      function searchFilter() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tableDetails");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }

    </script>
  </body>
</html>   