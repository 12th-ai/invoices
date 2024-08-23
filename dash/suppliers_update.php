<?php
  session_start();
  include '../config.php';
  if(isset($_GET['upId'])) {
    $id = $_GET['upId'];
    $get = mysqli_query($conn, "SELECT * FROM suppliers WHERE company_no = '$id'");
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
    
    if($_SESSION['userLogLvl'] != 2 && $_SESSION['userLogLvl'] != 0) {
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
  <a href="./suppliers.php" class="backButton">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M33.960938 2.9804688 A 2.0002 2.0002 0 0 0 32.585938 3.5859375L13.585938 22.585938 A 2.0002 2.0002 0 0 0 13.585938 25.414062L32.585938 44.414062 A 2.0002 2.0002 0 1 0 35.414062 41.585938L17.828125 24L35.414062 6.4140625 A 2.0002 2.0002 0 0 0 33.960938 2.9804688 z"/></svg>
    Go Back
  </a>
  <div class="authForm">
    <h1 class="authForm-title">Update <span>Supplier</span></h1>
    <form method="POST">
      <div class="auth-logo">
        <img src="../img/495dc385-rw-cmr-logo.webp" alt="CIMERWA Logo">
      </div>
      <div class="auth-body">
        <div class="auth-crd">
          <label>Company Legal Name: </label>
          <input type="text" value="<?php echo $fetchGet['company_name']?>" placeholder="Enter Company Legal Name" name="names" required>
        </div>
        <div class="auth-crd">
          <label>Company Sector: </label>
          <select name="sector" id="" required>
            <option value="" hidden>Choose Company Sector</option>
            <option value="Private" <?php if($fetchGet['company_sector'] == 'Private' ){echo 'selected';}?>>Private</option>
            <option value="Government" <?php if($fetchGet['company_sector'] == 'Government' ){echo 'selected';}?>>Government</option>
            <option value="NGO" <?php if($fetchGet['company_sector'] == 'NGO' ){echo 'selected';}?>>NGO</option>
            <option value="Medical Institution" <?php if($fetchGet['company_sector'] == 'Medical Institution' ){echo 'selected';}?>>Medical Institution</option>
          </select>
        </div>
      </div>
      <button type="submit" name="add">UPDATE SUPPLIER</button>
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
      $sector = $_POST['sector'];

      $checkUser = mysqli_query($conn, "SELECT * FROM suppliers WHERE company_name = '$names' AND company_no != '$id'");
      if(mysqli_num_rows($checkUser) > 0) {
        echo '<script>
          Swal.fire({
            title: "Failed To Update Supplier!",
            text: "Supplier Name Already Exists!",
            icon: "error"
          })
        </script>';
      } else {
        $insert = mysqli_query($conn, "UPDATE suppliers SET company_name = '$names', company_sector = '$sector' WHERE company_no = '$id'");
        if($insert) {
          echo '<script>
            Swal.fire({
              title: "Supplier Updated Successfully!",
              text: "Redirecting To Supplier\'s Page...!",
              icon: "success"
            })
            setTimeout(() => {
              window.location.replace("./suppliers.php");
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