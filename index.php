<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CIMERWA | Invoice Management System</title>
  <link rel="shortcut icon" href="img/495dc385-rw-cmr-logo.webp" type="image/x-icon">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/sweetalert2.all.min.js"></script>
</head>
<body class="authPage">
  <div class="authForm">
    <h1 class="authForm-title">Login To <span>CIMERWA Invoice Management System</span></h1>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
      <div class="auth-logo">
        <img src="img/495dc385-rw-cmr-logo.webp" alt="CIMERWA Logo">
      </div>
      <div class="auth-body">
        <div class="auth-crd">
          <label>Username: </label>
          <input type="text" placeholder="Enter Your Username" name="username" required>
        </div>
        <div class="auth-crd">
          <label>Password: </label>
          <div class="auth-pw-inp">
            <input type="password" id="password" placeholder="Enter Your Password" name="password" required>
            <span id="toggler" draggable="false">Show</span>
          </div>
        </div>
      </div>
      <button type="submit" name="login">LOGIN</button>
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
    include 'config.php';

    if(isset($_POST['login'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE user_name = '$username' AND `password` = '$password' ");
      if(mysqli_num_rows($checkUser) > 0) {
        $fetchUser = mysqli_fetch_array($checkUser);
        $_SESSION['userLog'] = $fetchUser['user_id'];
        $_SESSION['userLogName'] = $fetchUser['names'];
        $_SESSION['userLogLvl'] = $fetchUser['user_level'];
        echo '<script>
          Swal.fire({
            title: "Login Successful!",
            text: "Redirecting To Dashboard...!",
            icon: "success"
          })
          setTimeout(() => {
            window.location.replace("./dash/");
          }, 2000);
        </script>';
      } else {
        echo '<script>
          Swal.fire({
            title: "Invalid Credentials!",
            text: "User Not Found!",
            icon: "error"
          })
        </script>';
      }
    }

    // Log Out
    if(isset($_GET['logout'])) {
      session_destroy();
      echo '<script>
        Swal.fire({
          title: "Logout Successful!",
          text: "You were logged out successfully...!",
          icon: "success"
        })
        setTimeout(() => {
          window.location.replace("./");
        }, 2000);
      </script>';
    }
  ?>
</body>
</html>