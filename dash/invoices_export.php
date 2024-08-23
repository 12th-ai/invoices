<?php 
  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; Filename = report.xlsx");

  include '../config.php';

  if(isset($_GET['searchq'])){
    $key = $_GET['searchq'];
    $get = mysqli_query($conn, "SELECT * FROM invoice INNER JOIN suppliers ON invoice.owner = suppliers.company_no WHERE invoice.amount LIKE '%$key%' OR invoice.currency LIKE '%$key%' OR invoice.description LIKE '%$key%' OR suppliers.company_name LIKE '%$key%' OR suppliers.company_sector LIKE '%$key%' ORDER BY invoice_number");
  } else if(isset($_GET['dateFilter'])) {
    $start = $_GET['s'];
    $end = $_GET['e'];
    $get = mysqli_query($conn, "SELECT * FROM invoice INNER JOIN suppliers ON invoice.owner = suppliers.company_no WHERE invoice.date BETWEEN '$start' AND '$end' ORDER BY invoice_number");
  } else {
    $get = mysqli_query($conn, "SELECT * FROM invoice INNER JOIN suppliers ON invoice.owner = suppliers.company_no ORDER BY invoice_number");
  }
?>
  <table border="1">
    <tr>
      <th>Invoice Number</th=>
      <th>Amount</th>
      <th>Owner</th>
      <th>Sector</th>
      <th>Description</th>
      <th>Date</th>
    </tr>
    <?php 
      $i = 1;
      while($fetch = mysqli_fetch_array($get)){
    ?>
    <tr>
      <td><center><?php echo $fetch['invoice_number'] ?></center></td>
      <td><center><?php echo number_format($fetch['amount'], 0, ',')." ".$fetch['currency']; ?></center></td>
      <td><center><?php echo $fetch['company_name']; ?></center></td>
      <td><center><?php echo $fetch['company_sector']?></center></td>
      <td><center><?php echo $fetch['description']; ?></center></td>
      <td><center><?php echo $fetch['date']; ?></center></td>
    </tr>
    <?php } ?>
  </table>