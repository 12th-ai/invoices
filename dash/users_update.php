<?php
  session_start();
  include '../config.php';
  if(isset($_GET['upId'])) {
    $id = $_GET['upId'];
    $get = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id'");
    $fetchGet = mysqli_fetch_array($get);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CIMERWA | Invoice Management System</title>
  <link rel="shortcut icon" href="../img/495dc385-rw-cmr-logo.webp" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/sweetalert2.all.min.js"></script>
</head>
<body class="authPage">
  <?php 
    if(!isset($_SESSION['userLog'])) {
      echo '<script>
        Swal.fire({
          title: "Unauthorized Access!",
          text: "Please Login First!, Logging Out...",
          icon: "error",
        })
        setTimeout(() => {
          window.location.replace("../");
        }, 3000);
      </script>';
      return 0;
    }
    
    if($_SESSION['userLogLvl'] != 0) {
      echo '<script>
        Swal.fire({
          title: "Unauthorized Access!",
          text: "You are not allowed to access this page",
          icon: "error",
        })
        setTimeout(() => {
          window.location.replace("./");
        }, 3000);
      </script>';
      return 0;
    }
  ?>
  <a href="./users.php" class="backButton">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M33.960938 2.9804688 A 2.0002 2.0002 0 0 0 32.585938 3.5859375L13.585938 22.585938 A 2.0002 2.0002 0 0 0 13.585938 25.414062L32.585938 44.414062 A 2.0002 2.0002 0 1 0 35.414062 41.585938L17.828125 24L35.414062 6.4140625 A 2.0002 2.0002 0 0 0 33.960938 2.9804688 z"/></svg>
    Go Back
  </a>
  <div class="authForm">
    <h1 class="authForm-title">Update <span>User</span></h1>
    <form method="POST" class="lg-form">
      <div class="auth-logo">
        <img src="../img/495dc385-rw-cmr-logo.webp" alt="CIMERWA Logo">
      </div>
      <div class="auth-body">
        <div class="form-split">
          <div class="auth-crd">
            <label>Names: </label>
            <input type="text" value="<?php echo $fetchGet['names']?>" placeholder="Enter User's Names" name="names" required>
          </div>
          <div class="auth-crd">
            <label>Username: </label>
            <input type="text" value="<?php echo $fetchGet['user_name']?>" placeholder="Enter User's Username" name="username" required>
          </div>
        </div>
        <div class="form-split">
          <div class="auth-crd">
            <label>Password: </label>
            <div class="auth-pw-inp">
              <input type="password" value="<?php echo $fetchGet['password']?>" id="password" placeholder="Enter User's Password" name="password" required>
              <span id="toggler" class="active" draggable="false">Show</span>
            </div>
          </div>
          <div class="auth-crd">
            <label>User Level: </label>
            <select name="level" id="" required>
              <!-- <option value="0">Administrator</option> -->
              <option value="1" <?php if($fetchGet['user_level'] == 1){echo 'selected';}?>>Receptionist</option>
              <option value="2" <?php if($fetchGet['user_level'] == 2){echo 'selected';}?>>Buyer</option>
              <option value="3" <?php if($fetchGet['user_level'] == 3){echo 'selected';}?>>Account Payable Officer</option>
            </select>
          </div>
        </div>
      </div>
      <button type="submit" name="add">UPDATE USER</button>
    </form>
  </div>

  <script>
    let toggler = document.querySelector('#toggler');
    let passwordInp = document.querySelector('#password');
    
    // Toggle Show/Hide on password
    passwordInp.addEventListener('keyup', ev => {
      if(ev.target.value.length > 0){
        toggler.classList.add('active');
      } else {
        toggler.classList.remove('active');
      }
    });

    // Configuring the Show/Hide functionalities
    toggler.addEventListener('click', ev => {
      if(passwordInp.type == 'text') {
        passwordInp.type = 'password';
        toggler.innerHTML = 'Show';
      } else {
        toggler.innerHTML = 'Hide';
        passwordInp.type = 'text';
      }
    });
  </script>

<?php 
    include '../config.php';

    if(isset($_POST['add'])) {
      $names = $_POST['names'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $level = $_POST['level'];

      $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE user_name = '$username' AND user_id != '$id'");
      if(mysqli_num_rows($checkUser) > 0) {
        echo '<script>
          Swal.fire({
            title: "Failed To Update User!",
            text: "Username Already Exists!",
            icon: "error"
          })
        </script>';
      } else {
        $insert = mysqli_query($conn, "UPDATE users SET names = '$names', user_name = '$username',`password` = '$password',user_level = '$level' WHERE user_id = '$id'");
        if($insert) {
          echo '<script>
            Swal.fire({
              title: "User Updated Successfully!",
              text: "Redirecting To User\'s Page...!",
              icon: "success"
            })
            setTimeout(() => {
              window.location.replace("./users.php");
            }, 2000);
          </script>';
        } else {
          echo '<script>
            Swal.fire({
              title: "Failed To Update User!",
              text: "An Error Occured!",
              icon: "error"
            })
          </script>';
        }
      }
    }
  ?>
</body>
</html>