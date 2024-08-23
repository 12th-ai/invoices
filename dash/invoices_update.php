<?php
  session_start();
  include '../config.php';
  if(isset($_GET['upId'])) {
    $id = $_GET['upId'];
    $get = mysqli_query($conn, "SELECT * FROM invoice WHERE invoice_number = '$id'");
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
  ?>
  <a href="./invoices.php" class="backButton">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M33.960938 2.9804688 A 2.0002 2.0002 0 0 0 32.585938 3.5859375L13.585938 22.585938 A 2.0002 2.0002 0 0 0 13.585938 25.414062L32.585938 44.414062 A 2.0002 2.0002 0 1 0 35.414062 41.585938L17.828125 24L35.414062 6.4140625 A 2.0002 2.0002 0 0 0 33.960938 2.9804688 z"/></svg>
    Go Back
  </a>
  <div class="authForm">
    <h1 class="authForm-title">Update <span>Invoice</span></h1>
    <form method="POST" class="lg-form">
      <div class="auth-logo">
        <img src="../img/495dc385-rw-cmr-logo.webp" alt="CIMERWA Logo">
      </div>
      <div class="auth-body">
        <div class="form-split">
          <div class="auth-crd">
            <label>Invoice Number (Code): </label>
            <input type="text" value="<?php echo $fetchGet['invoice_number']?>" placeholder="Enter Invoice Number" name="invNumber" required>
          </div>
          <div class="auth-crd">
            <label>Invoice Owner: </label>
            <select name="owner" id="" required>
              <option value="" hidden>Choose Invoice Owner</option>
              <?php 
                $sel = mysqli_query($conn, "SELECT * FROM suppliers");
                while($getSel = mysqli_fetch_array($sel)){
              ?>
              <option value="<?php echo $getSel['company_no']?>" <?php if($getSel['company_no'] == $fetchGet['owner']){echo 'selected';}?>><?php echo $getSel['company_name']?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-split">
          <div class="auth-crd">
            <label>Amount: </label>
            <input type="number" value="<?php echo $fetchGet['amount']?>" min="0" required name="amount" placeholder="Enter Invoice Amount">
          </div>
          <div class="auth-crd">
            <label>Currency: </label>
            <select name="currency" id="" required>
              <option value="RWF" <?php if($fetchGet['currency'] == 'RWF') {echo 'selected';}?>>RWF</option>
              <option value="USD" <?php if($fetchGet['currency'] == 'USD') {echo 'selected';}?>>US Dollar $</option>
              <option value="ZAR" <?php if($fetchGet['currency'] == 'ZAR') {echo 'selected';}?>>ZAR</option>
              <option value="EUR" <?php if($fetchGet['currency'] == 'EUR') {echo 'selected';}?>>Euro €</option>
            </select>
          </div>
        </div>
        <div class="form-split">
          <div class="auth-crd">
            <label>Date: </label>
            <input type="date" value="<?php echo $fetchGet['date']?>" required name="date">
          </div>
          <div class="auth-crd">
            <label>Description: </label>
            <textarea name="descr" required placeholder="Enter Product/Service Small Description"><?php echo $fetchGet['description']?></textarea>
          </div>
        </div>
      </div>
      <button type="submit" name="add">UPDATE INVOICE</button>
    </form>
  </div>

<?php 
    include '../config.php';

    if(isset($_POST['add'])) {
      $number = $_POST['invNumber'];
      $owner = $_POST['owner'];
      $amt = $_POST['amount'];
      $curr = $_POST['currency'];
      $date = $_POST['date'];
      $descr = $_POST['descr'];

      // Fetch Values
      $fetchAmt = $fetchGet['amount'];
      $fetchCurr = $fetchGet['currency'];
      $fetchOwner = $fetchGet['owner'];
      $fetchDescr = $fetchGet['description'];
      $fetchDate = $fetchGet['date'];

      $checkUser = mysqli_query($conn, "SELECT * FROM invoice WHERE invoice_number = '$number' AND amount != '$fetchAmt' AND currency != '$fetchCurr' AND `owner` != '$fetchOwner' AND `description` != '$fetchDescr' AND `date` != '$fetchDate'");
      if(mysqli_num_rows($checkUser) > 0) {
        echo '<script>
          Swal.fire({
            title: "Failed To Update Invoice!",
            text: "Invoice Number Already Exists!",
            icon: "error"
          })
        </script>';
      } else {
        $insert = mysqli_query($conn, "UPDATE invoice SET invoice_number = '$number', amount = '$amt', currency = '$curr',`owner` = '$owner',`description` = '$descr', `date`='$date' WHERE invoice_number = '$id'");
        if($insert) {
          echo '<script>
            Swal.fire({
              title: "Invoice Updated Successfully!",
              text: "Redirecting To Invoice\'s Page...!",
              icon: "success"
            })
            setTimeout(() => {
              window.location.replace("./invoices.php");
            }, 2000);
          </script>';
        } else {
          echo '<script>
            Swal.fire({
              title: "Failed To Update Invoice!",
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