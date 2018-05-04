<?php
    require_once('lib/session.php');
    $msg="";
    if (isset($_POST['receiverLogin'])) {
        // receiving the post parameters
        $username = $_POST['receiverUsername'];
        $password = $_POST['receiverPassword'];

        // call the method to receiver login and show msg based on result
        $result = $db->validateReceiver($username,$password);
        if(is_null($result)){
            $msg= '<p class="red-text"> Username or password is not correct of Receiver. </p>';
        }else{
            header("Location: index.php");
        }
    }
    if (isset($_POST['hospitalLogin'])) {
        // receiving the post parameters
        $username = $_POST['hospitalUsername'];
        $password = $_POST['hospitalPassword'];

        // call the method to hospital login and show msg based on result
        $result = $db->validateHospital($username,$password);
        if(is_null($result)){
            $msg= '<p class="red-text"> Username or password is not correct of Hospital. </p>';
        }else{
            header("Location: view_requests.php");
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

        <title>Login Page</title>
  </head>
  <body>

    <!--Header-->
     <?php include('header/header.html'); ?>
    <!--/.Header-->
    <!-- Container -->
    <div class="container-fluid">
      <!-- Row 1 -->
      <div class="row text-center justify-content-center mt-4">
          <?php echo $msg; ?> 
      </div>
      <!-- /. Row 1 -->
      <!-- Row 2 -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            <!--Modal: Login  tabs-->
            <div class="modal-dialog cascading-modal" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Modal cascading tabs-->
                    <div class="modal-c-tabs">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tabs-2 light-blue darken-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab"><i class="fa fa-male mr-1"></i> Receiver</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#panel2" role="tab"><i class="fa fa-hospital mr-1"   ></i> Hospital</a>
                            </li>
                        </ul>
                        <!-- /. Nav tabs -->
                        <!-- Tab panels -->
                        <div class="tab-content">
                            <!--Panel 1-->
                            <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
                                <!--Body-->
                                <div class="modal-body mb-1">
                                    <!--Form recevier login-->
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <!-- Input recevier username -->
                                        <div class="md-form form-sm mb-5" >
                                            <i class="fa fa-user prefix"></i>
                                            <input type="text"  id="receiverUsername" name="receiverUsername" class="form-control form-control-sm validate" required>
                                            <label for="receiverUsername">Your username</label>
                                        </div>
                                        <!-- Input recevier password -->
                                        <div class="md-form form-sm mb-4">
                                            <i class="fa fa-lock prefix"></i>
                                            <input type="password" id="receiverPassword" name="receiverPassword" class="form-control form-control-sm validate" required>
                                            <label for="receiverPassword" >Your password</label>
                                        </div>
                                        <!-- Input recevier submit form -->
                                        <div class="text-center mt-2">
                                            <input type="submit" value="Login" name="receiverLogin" class="btn btn-indigo">
                                        </div>
                                    </form>
                                    <!-- /.Form login recevier --> 
                                </div>
                                <!-- /.Body -->
                                <!--Footer-->
                                <div class="modal-footer">
                                    <div class="text-right mt-1">
                                        <p>Not a member? <a href="registration_receiver.php" class="blue-text">Sign Up</a></p>
                                    </div>
                                </div>
                                <!-- /.Footer-->
                            </div>
                            <!--/.Panel 1-->
                            <!--Panel 2-->
                            <div class="tab-pane fade" id="panel2" role="tabpanel">
                                <!--Body-->
                                <div class="modal-body mb-1">
                                    <!--Form hospital login-->
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <!-- Input hospital username -->
                                        <div class="md-form form-sm mb-5" >
                                            <i class="fa fa-user prefix"></i>
                                            <input type="text"  id="hospitalUsername" name="hospitalUsername" class="form-control form-control-sm validate" required>
                                            <label for="hospitalUsername">Your username</label>
                                        </div>
                                        <!-- Input hospital password -->
                                        <div class="md-form form-sm mb-4">
                                            <i class="fa fa-lock prefix"></i>
                                            <input type="password" id="hospitalPassword" name="hospitalPassword" class="form-control form-control-sm validate" required>
                                            <label for="hospitalPassword" >Your password</label>
                                        </div>
                                        <!-- Input hospital submit form -->
                                        <div class="text-center mt-2">
                                            <input type="submit" value="Login" name="hospitalLogin" class="btn btn-indigo">
                                        </div>
                                    </form>
                                    <!-- /.Form login hospital -->   
                                </div>
                                <!-- /.Body-->
                                <!--Footer-->
                                <div class="modal-footer">
                                    <div class="text-right mt-1">
                                        <p>Not a member? <a href="registration_hospital.php" class="blue-text">Sign Up</a></p>
                                    </div>
                                </div>
                                <!-- /.Footer-->
                            </div>
                            <!--/.Panel 2-->
                        </div>
                        <!-- /.Tab panels -->
                    </div>
                    <!-- /.Modal cascading tabs-->
                </div>
                <!--/.Content-->
            </div>
            <!--/Modal: Login tabs-->
        </div>
      </div> 
      <!-- /. Row 2 -->
    </div>
    <!-- /. Container -->

    <!-- Bootstrap js -->
    <script src="js/compiled.min.js"></script>
    <!-- FontAwesome -->
    <script defer src="js/fontawesome-all.min.js"></script>
  </body>
</html>