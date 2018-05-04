<?php
  require_once('lib/db_files/db_functions.php');
  $db = new db();
  $msg="";
  if (isset($_POST['submit'])) {
      // receiving the post parameters
      $username = $_POST['username'];
      $password = $_POST['password'];
      $hospitalname = $_POST['hospitalname'];
      $mobile_no = $_POST['mobile'];
      // call the method to register and show msg based on result
      $result = $db->registerHospital($username,$password,$hospitalname,$mobile_no);

      if(is_null($result)){
          $msg = '<p class="red-text"> User with given username already exist. Please try another username. </p>';
      }else{
          $msg = '<p class="green-text"> You are registered successfully.
                        <a href="login_page.php">Click here to Login </p> ';
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/compiled.min.css">

      <title>Hospital Registration</title>
  </head>
  <body>
    <!--Header-->
    <?php include('header/header.html'); ?>
    <!--/.Header-->

    <div class="container-fluid">

      <div class="row text-center justify-content-center mt-4">
          <?php echo $msg; ?> 
      </div>

      <div class="row justify-content-center">
          <div class="col-lg-6 col-sm-12">
            <!--Modal: hospital registration-->
            <div class="modal-dialog cascading-modal" role="document">
              <!-- Content-->
              <div class="modal-content">
                  <!--Header-->
                  <div class="modal-header primary-color white-text">
                      <h4 class="title">
                          <i class="fas fa-hospital"></i> Hospital Registration</h4>
                  </div>
                  <!-- /.Header-->
                  <!--Body-->
                  <div class="modal-body">
                    <!--Form hospital registration-->
                    <form name="hospitalRegistration" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <!-- Input hospital name -->
                        <div class="md-form form-sm">
                            <i class="fas fa-h-square prefix"></i>
                            <input type="text" id="hospitalname" name="hospitalname" class="form-control form-control-sm" pattern="[a-zA-Z][a-zA-Z ]*" title="Only alphabets are allowed" required>
                            <label for="hospitalname">Hospital name</label>
                        </div>
                        <!-- Input hospital username -->
                        <div class="md-form form-sm">
                            <i class="fas fa-id-badge prefix"></i>
                            <input type="text" id="username" name="username" class="form-control form-control-sm" pattern="[A-Za-z]{6,}" title="Username must be at least 6 characters and only alphabets are allowed" required>
                            <label for="username">Username</label>
                        </div>
                        <!-- Input hospital password -->
                        <div class="md-form form-sm">
                            <i class="fas fa-lock prefix"></i>
                            <input type="password" id="password" name="password" class="form-control form-control-sm" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$" title="Minimum six characters, at least one letter, one number and one special character" required>
                            <label for="password">Password</label>
                        </div>
                        <!-- Input hospital mobile -->
                        <div class="md-form form-sm">
                            <i class="fas fa-mobile-alt prefix"></i>
                            <input type="text" id="mobile" name="mobile" class="form-control form-control-sm" pattern="^\d{10}$" title="10 digits mobile number" required>
                            <label for="mobile">Mobile number</label>
                        </div>
                        <!-- Input hospital submit form --> 
                        <div class="text-center mt-4 mb-2">
                            <input type="submit" value="Signup" name="submit" class="btn btn-indigo">
                        </div>
                    </form>
                    <!--/.Form hospital registration-->
                  </div>
                  <!-- /.Body-->
              </div>
              <!-- /.Content-->
            </div>
            <!--/Modal: hospital registration-->
          </div>
      </div>

    </div>   

    <!-- Bootstrap js -->
    <script src="js/compiled.min.js"></script>
    <!-- FontAwesome -->
    <script defer src="js/fontawesome-all.min.js"></script>
  </body>
</html>  