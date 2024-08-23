<?php
  session_start();
  include '../config.php';  
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
<body>
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

    // echo $_SESSION['userLogLvl'] ;
  ?>
  <main>
    <aside>
      <div class="top">
        <div class="logo">
          <img src="../img/495dc385-rw-cmr-logo.webp" alt="CIMERWA Logo">
        </div>
        <nav>
          <a href="./">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"/></svg>
            Home
          </a>
          <?php 
            if($_SESSION['userLogLvl'] == 0) {
          ?>
          <a href="./users.php">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M13 21c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6S16.309 21 13 21zM24 31c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6S27.309 31 24 31zM24 13c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5S26.757 13 24 13zM35 21c-3.309 0-6-2.691-6-6s2.691-6 6-6 6 2.691 6 6S38.309 21 35 21zM24 45c-5.047 0-9-2.636-9-6v-2.5c0-1.93 1.57-3.5 3.5-3.5h11c1.93 0 3.5 1.57 3.5 3.5V39C33 42.364 29.047 45 24 45zM13.21 35c.001 0 .002.001.003.001C13.868 32.696 15.988 31 18.5 31h.229C17.061 29.533 16 27.391 16 25c0-.692.097-1.359.263-2H7.5C5.57 23 4 24.57 4 26.5V29c0 3.36 3.95 6 9 6H13.21zM34.79 35c-.001 0-.002.001-.003.001C34.132 32.696 32.012 31 29.5 31h-.229C30.939 29.533 32 27.391 32 25c0-.692-.097-1.359-.263-2H40.5c1.93 0 3.5 1.57 3.5 3.5V29c0 3.36-3.95 6-9 6H34.79z"/></svg>
            Users
          </a>
          <?php } ?>
          <?php 
            if($_SESSION['userLogLvl'] == 2 || $_SESSION['userLogLvl'] == 0) {
          ?>
          <a href="./suppliers.php" class="active">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M24 24c-5.514 0-10-4.486-10-10S18.486 4 24 4s10 4.486 10 10S29.514 24 24 24zM24 43V29c0-.343.035-.677.101-1H12.5C10.019 28 8 30.019 8 32.5V34c0 5.607 7.028 10 16 10 .034 0 .067-.003.1-.003C24.035 43.675 24 43.341 24 43zM43 26H29c-1.657 0-3 1.343-3 3v14c0 1.657 1.343 3 3 3h14c1.657 0 3-1.343 3-3V29C46 27.343 44.657 26 43 26zM38.5 35h-5c-.828 0-1.5-.672-1.5-1.5s.672-1.5 1.5-1.5h5c.828 0 1.5.672 1.5 1.5S39.328 35 38.5 35z"/></svg>
            Suppliers
          </a>
          <?php } ?>
          
          <a href="./invoices.php">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M6.5 8C4.57 8 3 9.57 3 11.5L3 34L16.960938 34C19.340938 34 21.51 35.059063 23 36.789062L23 12C22.02 9.66 19.7 8 17 8L6.5 8 z M 31 8C28.3 8 25.98 9.66 25 12L25 36.789062C26.49 35.059063 28.659062 34 31.039062 34L45 34L45 11.5C45 9.57 43.43 8 41.5 8L31 8 z M 8.5 12L15.5 12C16.328 12 17 12.672 17 13.5C17 14.328 16.328 15 15.5 15L8.5 15C7.672 15 7 14.328 7 13.5C7 12.672 7.672 12 8.5 12 z M 35 12C35.83 12 36.5 12.67 36.5 13.5L36.5 14.109375C37.72 14.369375 38.689062 15.090703 39.289062 16.220703C39.639063 16.880703 39.510156 17.749453 38.910156 18.189453C38.140156 18.769453 37.070156 18.499922 36.660156 17.669922C36.490156 17.319922 36.220938 17 35.460938 17L34.619141 17C33.899141 17 33.269531 17.58 33.269531 18.25C33.269531 18.94 33.829531 19.5 34.519531 19.5L35.550781 19.5C37.740781 19.5 39.710703 21.070234 39.970703 23.240234C40.240703 25.550234 38.65 27.539922 36.5 27.919922L36.5 28.5C36.5 29.33 35.83 30 35 30C34.17 30 33.5 29.33 33.5 28.5L33.5 27.960938C31.86 27.770937 30.750937 26.759531 30.210938 25.769531C29.860937 25.119531 29.980078 24.260547 30.580078 23.810547C31.360078 23.230547 32.429844 23.500078 32.839844 24.330078C32.899844 24.440078 33.219062 25 34.039062 25L35.75 25C36.44 25 37 24.44 37 23.75C37 23.06 36.44 22.5 35.75 22.5L34.759766 22.5C32.859766 22.5 31.080469 21.349062 30.480469 19.539062C29.680469 17.109063 31.27 14.769922 33.5 14.169922L33.5 13.5C33.5 12.67 34.17 12 35 12 z M 8.5 19L15.5 19C16.328 19 17 19.672 17 20.5C17 21.328 16.328 22 15.5 22L8.5 22C7.672 22 7 21.328 7 20.5C7 19.672 7.672 19 8.5 19 z M 8.5 26L11.5 26C12.328 26 13 26.672 13 27.5C13 28.328 12.328 29 11.5 29L8.5 29C7.672 29 7 28.328 7 27.5C7 26.672 7.672 26 8.5 26 z M 3 36L3 36.5C3 38.43 4.57 40 6.5 40L22.609375 40C21.769375 37.6 19.500937 36 16.960938 36L3 36 z M 31.039062 36C28.499062 36 26.230625 37.6 25.390625 40L41.5 40C43.43 40 45 38.43 45 36.5L45 36L31.039062 36 z"/></svg>
            Invoices
          </a>
        </nav>
      </div>
      <a href="../?logout">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M24 4C18.624631 4 13.709541 6.0816752 10.107422 9.5625 A 2.0002 2.0002 0 1 0 12.886719 12.4375C15.758599 9.6623248 19.651369 8 24 8C32.860089 8 40 15.139911 40 24C40 32.860089 32.860089 40 24 40C19.698374 40 15.755383 38.301028 12.882812 35.552734 A 2.0002743 2.0002743 0 1 0 10.117188 38.443359C13.716617 41.887065 18.645626 44 24 44C35.021911 44 44 35.021911 44 24C44 12.978089 35.021911 4 24 4 z M 11.960938 15.980469 A 2.0002 2.0002 0 0 0 10.585938 16.585938L4.5859375 22.585938 A 2.0002 2.0002 0 0 0 4.5859375 25.414062L10.585938 31.414062 A 2.0002 2.0002 0 1 0 13.414062 28.585938L10.828125 26L29 26 A 2.0002 2.0002 0 1 0 29 22L10.828125 22L13.414062 19.414062 A 2.0002 2.0002 0 0 0 11.960938 15.980469 z"/></svg>
        Logout
      </a>
    </aside>
    <div class="main">
      <?php 
        include 'topnav.php';
        if(isset($_GET['del'])) {
          $delId = $_GET['del'];
          $del = mysqli_query($conn, "DELETE FROM suppliers WHERE company_no = '$delId'");
          if($del) {
            echo '<script>
              Swal.fire({
                title: "Supplier Deleted Successfully!",
                icon: "success",
              })
              setTimeout(() => {
                window.location.replace("./suppliers.php");
              }, 3000);
            </script>';
          }
        }
        $get = mysqli_query($conn, "SELECT * FROM suppliers");
      ?>
      <div class="main-data">
        <div class="data-table">
          <h1 class="title">
            All Suppliers (<?php echo mysqli_num_rows($get); ?>)
            <a href="./suppliers_add.php">
              Add Supplier
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><path d="M23.970703 4.9726562 A 2.0002 2.0002 0 0 0 22 7L22 22L7 22 A 2.0002 2.0002 0 1 0 7 26L22 26L22 41 A 2.0002 2.0002 0 1 0 26 41L26 26L41 26 A 2.0002 2.0002 0 1 0 41 22L26 22L26 7 A 2.0002 2.0002 0 0 0 23.970703 4.9726562 z"/></svg>
            </a>
          </h1>
          <?php 
            if(mysqli_num_rows($get) > 0){
          ?>
          <table>
            <tr>
              <th>Company No</th>
              <th>Company Name</th>
              <th>Company Sector</th>
              <th>Action</th>
            </tr>
            <?php 
              $i = 1;
              while($fetch = mysqli_fetch_array($get)){
            ?>
            <tr>
              <td><?php echo $fetch['company_no']; ?></td>
              <td><?php echo $fetch['company_name']; ?></td>
              <td><?php echo $fetch['company_sector']; ?></td>
              <td>
                <a href="./suppliers_update.php?upId=<?php echo $fetch['company_no'];?>">Update</a>
                <button onclick="deleteRecord(<?php echo $fetch['company_no']; ?>)">Delete</button>
              </td>
            </tr>
            <?php } ?>
          </table>
          <?php } else { ?>
            <p class="center">No Suppliers Found</p>
          <?php } ?>
        </div>
      </div>
    </div>
  </main>
  <script>
    function deleteRecord(deleteId) {
      Swal.fire({
        title: 'Are you sure to delete?',
        text: "You won't be able to revert this!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = './suppliers.php?del='+deleteId;
        }
      })
    }
  </script>
</body>
</html>