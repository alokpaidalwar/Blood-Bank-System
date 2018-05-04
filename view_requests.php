<?php
  require_once('lib/session_hospital.php');
  $bloodgroup_list=$db->getAll("SELECT * FROM blood_group");
  $even=0;
?>
<!doctype html>
<html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/compiled.min.css">
      
      <title>View Requests</title>
  </head>
  <body>
    <!-- Header-->
    <?php include('header/header_hospital.html');?>
    <!-- /.Header-->
    <!-- Container -->
    <div class="container-fluid">
      <!-- Row 1 -->
      <div class="row justify-content-center mt-5">

        <div class="col-md-8 col-sm-12 mt-5">
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
            <!-- /.Nav tabs -->
            <!-- Tab Panels -->
            <div class="tab-content card">
              <?php foreach($bloodgroup_list as $bloodgroup){ ?>
              <div class="tab-pane fade <?php if($even==1){echo "in show active";}?>" id="<?php echo "panel".$bloodgroup["bloodgroup_id"];?>" role="tabpanel">
                <!--Table-->
                <table class="table table-hover table-responsive-md table-fixed">
                    <!-- Table head-->
                    <thead class="blue-grey lighten-4">
                      <tr>
                        <th>Requester Name</th>
                        <th>Mobile number</th>
                        <th>Date Time</th>
                      </tr>
                    </thead>
                    <!-- /.Table head-->
                    <!-- Table body-->
                    <tbody>
                        <?php
                          $even=2;
                          $request_array= $db->getRequestedSampleData($_SESSION['username'],$bloodgroup["bloodgroup_id"]);
                          if (!empty($request_array)) { 
                             foreach($request_array as $key=>$value){ 
                        ?>
                              <tr>
                                <td><?php echo $request_array[$key]["receiver_name"]; ?></td>
                                <td><?php echo $request_array[$key]["mobile_no"]; ?></td>
                                <td><?php echo $request_array[$key]["datetime"]; ?></td>
                              </tr>
                        <?php
                              }
                          }
                        ?>  
                    </tbody>
                    <!-- /. Table body-->
                </table>
                <!-- /.Table-->
              </div>
              <?php } ?>
            </div>
            <!--/. Tab Panels -->
        </div>

      </div>
      <!-- /.Row 1 -->   
    </div>
    <!-- /. Container -->

    <!-- Bootstrap js -->
    <script src="js/compiled.min.js"></script>
    <!-- FontAwesome -->
    <script defer src="js/fontawesome-all.min.js"></script>
  </body>
</html> 