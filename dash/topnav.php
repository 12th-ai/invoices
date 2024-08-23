<?php
  // Setting Title of the logged in user based on their user level
  $sessionLvl = $_SESSION['userLogLvl'];
  if($sessionLvl == 1) {
    $title = 'Receptionist';
  } else if($sessionLvl == 2) {
    $title = 'Buyer';
  } else if($sessionLvl == 3) {
    $title = 'Acc. Payable Off.';
  } else {
    $title = 'Admin';
  }
?>
<div class="topNav">
  <h1>Hello, <span><?php echo $_SESSION['userLogName'] ?> (<?php echo $title;?>)</span></h1>
  <p>INVOICE MANAGEMENT SYSTEM</p>
</div>