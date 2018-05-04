<?php
  require_once('lib/session_hospital.php');
  $bloodgroup_list = $db->getAll("SELECT * FROM blood_group");
  $even = 0;
  $msgAdd = "";
  $msgAvail = "";
  if (isset($_POST['addBloodInfo'])) {
        // receiving the post parameters
        $donor_name = $_POST['donorName'];
        $blood_type = $_POST['blood_type'];
        $mobile_no = $_POST['mobile'];
        // call the method to add new blood sample infp and show msg based on result
        $result = $db->addBloodInfo($_SESSION['username'],$donor_name,$mobile_no,$blood_type);
        if(is_null($result)){
            $msgAdd = '<p class="red-text"> Some error occured. Please try again.</p>';
        }else{
            $msgAdd = '<p class="green-text"> New blood info successfully added.</p>';
        }
    }

  if(isset($_POST['availability'])){
        $checked_list = $_POST['check_list'];
        // call the method to update availability and show msg based on result
        $result = $db->changeAvailability($_SESSION['username'],$checked_list);
        if(is_null($result)){
            $msgAvail = '<p class="red-text"> Some error occured. Please try again.</p>';
        }else{
            $msgAvail = '<p class="green-text">Changes in availability of blood samples successful.</p>';
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

      <title>Add Blood Info</title>
  </head>
  <body>

    <!--Header-->
    <?php include('header/header_hospital.html'); ?>
    <!--/.Header-->
    <!-- Container -->
    <div class="container-fluid">
      <!-- Row 1 -->
      <div class="row mt-5">

        <div class="col-lg-8 col-sm-12 mt-5">
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
                      <th>Donar Name</th>
                      <th>Mobile number</th>
                      <th>Date Time</th>
                    </tr>
                  </thead>
                  <!-- /.Table head-->
                  <!-- Table body-->
                  <tbody>
                    <?php
                      $even=2;
                      $request_array = $db->getDonorsData($_SESSION['username'],$bloodgroup["bloodgroup_id"]);
                      if (!empty($request_array)) { 
                         foreach($request_array as $key=>$value){ 
                    ?>
                          <tr>
                            <td><?php echo $request_array[$key]["donor_name"]; ?></td>
                            <td><?php echo $request_array[$key]["mobile_no"]; ?></td>
                            <td><?php echo $request_array[$key]["datetime"]; ?></td>
                          </tr>
                    <?php
                          }
                      }
                    ?>  
                  </tbody>
                  <!-- /.Table body-->
                </table>
                <!-- /.Table-->
              </div>
              <?php } ?>
            </div>
            <!--/. Tab Panels -->
        </div>

        <div class="col-lg-4 col-sm-12 mt-4">
          <!-- Modal: Add blood info  -->
          <div class="modal-dialog cascading-modal" role="document">
              <!--Content-->
              <div class="modal-content">
                  <!--Header-->
                  <div class="modal-header primary-color white-text">
                      <h4 class="title"><i class="fas fa-hospital"></i> Add Blood Info </h4>
                  </div>
                  <!-- /.Header-->
                  <!-- Body-->
                  <div class="modal-body m-0 py-0">
                      <div class="text-center">
                          <?php echo $msgAdd; ?>
                      </div>
                      <!--Form: Add blood info-->
                      <form name="addBloodInfoForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                          <!-- Input donor name -->
                          <div class="md-form form-sm " >
                              <i class="fa fa-user prefix"></i>
                              <input type="text"  id="donorName" name="donorName" class="form-control form-control-sm validate" pattern="[a-zA-Z][a-zA-Z ]*" title="Only alphabets are allowed" required>
                              <label for="donorName">Donor Name</label>
                          </div>
                          <!-- Input recevier mobile -->
                          <div class="md-form form-sm">
                              <i class="fas fa-mobile-alt prefix"></i>
                              <input type="text" id="mobile" name="mobile" class="form-control form-control-sm" pattern="^\d{10}$" title="10 digits mobile number" required>
                              <label for="mobile">Mobile number</label>
                          </div>
                          <!-- Input donor blood group -->
                          <div class="md-form form-sm mb-4">
                              <select class="mdb-select colorful-select dropdown-primary" name="blood_type" required>
                                  <option disabled selected value="" >Select Blood Group </option>
                                    <?php
                                        foreach($bloodgroup_list as $bloodgroup){
                                          echo '<option value="'.$bloodgroup['bloodgroup_id'].'">';
                                          echo  $bloodgroup['bloodgroup_name']. "</option>";
                                        }
                                    ?>
                              </select>
                          </div>
                          <!-- Input add blood submit form -->
                          <div class="text-center mt-2">
                              <input type="submit" value="Add details" name="addBloodInfo" class="btn btn-indigo">
                          </div>
                      </form>
                      <!-- /.Form: Add blood info -->
                  </div>
                  <!-- /.Body-->
              </div>
          </div>
          <!-- /.Modal: Add blood info  --> 

          <!--Modal: Change Availablity -->
          <div class="modal-dialog cascading-modal mt-5" role="document">
              <!--Content-->
              <div class="modal-content">
                  <!--Header-->
                  <div class="modal-header primary-color white-text">
                      <h4 class="title"><i class="fas fa-hospital"></i> Change availablity </h4>
                  </div>
                  <!-- /.Header-->
                  <!-- Body-->
                  <div class="modal-body">
                      <div class="text-center">
                           <?php echo $msgAvail;?>
                      </div>
                      <!-- Form Change availability-->
                      <form name="changeAvailability" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <!-- Table-->
                        <table class="table table-hover table-responsive table-fixed ">
                            <!--Table head-->
                            <thead class="blue-grey lighten-4">
                                <tr class="text-center">
                                    <th>Sr No. </th>
                                    <th>Blood Group</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <!-- /.Table head-->
                            <!-- Table body-->
                            <tbody>
                                <?php 
                                  $request_array = $db->getAvailableSamplesData($_SESSION['username']);
                                    if (!empty($request_array)) { 
                                        foreach($request_array as $key=>$value){  
                                ?>
                                <tr>
                                    <th scope="row"> <?php echo $request_array[$key]["bloodgroup_id"];?> </th>
                                    <td> <?php echo $request_array[$key]["bloodgroup_name"];?> </td>
                                    <td>
                                        <div class="switch">
                                            <label>
                                            Unavailable
                                                <input type="checkbox" class="form-control form-control-sm"
                                                               <?php 
                                                                  if($request_array[$key]["availability"]) 
                                                                       echo 'checked="unchecked"' ;
                                                                  echo 'value=" '.$request_array[$key]["bloodgroup_id"].' "'; 
                                                                ?>  
                                                    name="check_list[]">
                                                <span class="lever"></span>
                                            Available
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php } } ?>
                                <tr class="text-center">
                                    <td colspan="3"> 
                                        <input type="submit" value="Submit" name="availability" class="btn btn-indigo">
                                    </td>
                                </tr>
                            </tbody>
                            <!-- /.Table body-->
                        </table>
                        <!-- /.Table-->
                      </form>  
                      <!-- /.Form Change availability-->
                  </div>
                  <!-- /.Body-->
              </div>
          </div>
          <!-- /.Modal: Change Availablity -->
        </div>
      </div>
      <!-- /.Row 1 -->
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

    </script>
  </body>
</html> 