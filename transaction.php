<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBOrder.php";
$dbOrder = new DBOrder();
?>
<?php
	if (isset($_GET['action']) && $_GET['action'] == 'delivered') {
		$id = $_GET['id'];
		$dbOrder->setAdminStatus("Delivery Complete",$id);
	}
?>
<?php
$orderRes=$dbOrder->getTransactions();
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $status="Delivered";
    $orderRes=$dbOrder->searchOrder($key,$status);
}
?>
<?php
 function fetch_data()  
 {  
      $output = ''; 
      $dbOrder = new DBOrder();
      $orderRes=$dbOrder->getTransactions(); 
      foreach ($orderRes as $values)
      {       
      $output .= '
        <tr>  
            <td>'.$values['id'].'</td>  
            <td>'.$values['userId'].'</td>
            <td>'.$values['productId'].'</td>
            <td>'.$values['productName'].'</td>
            <td>'.$values['qtn'].'</td>
            <td>'.$values['cost'].'</td>
            <td>'.$values['deliveryDate'].'</td>
            <td>'.$values['payment'].'</td>
            <td>'.$values['status'].'</td>
            <td>'.$values['supplierStatus'].'</td>
            <td>'.$values['userStatus'].'</td> 
        </tr>  
                          ';  
      }  
      return $output;  
 }  
?>
<?php 
if(isset($_GET["generatePdf"])) {  

        require_once('tcpdf/tcpdf.php');  
        $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
        $obj_pdf->SetCreator(PDF_CREATOR);  
        $obj_pdf->SetTitle("Customer Order Report");  
        $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
        $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
        $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
        $obj_pdf->SetDefaultMonospacedFont('helvetica');  
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
        $obj_pdf->setPrintHeader(false);  
        $obj_pdf->setPrintFooter(false);  
        $obj_pdf->SetAutoPageBreak(TRUE, 10);  
        $obj_pdf->SetFont('helvetica', '', 11);  
        $obj_pdf->AddPage();  
        $content = '';  
        $content .= '  
        <h4 align="center">Customer Order Report</h4><br /> 
        <table border="1" cellspacing="0" cellpadding="3">  
           <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total cost</th>
            <th>Delivery Date</th>
            <th>Payment Method</th>
            <th>Admin Status</th>
            <th>Supplier Status</th>
            <th>User Status</th>
        </tr> 
        ';  
        $content .= fetch_data();
        $content .= '</table>';  
        $obj_pdf->writeHTML($content);  
        $obj_pdf->Output('file.pdf', 'I');  
 }  
?>

<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Transaction</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>

<div class="container-fluid">
    <br/><br/>
    <form action="" method="get">
        <input class="form-control btn btn-danger" style="width: 200px" type="submit" name="generatePdf" value="Generate Report">
    </form>
    <div align="center">
        <br/><br/>
        <!--        <a class="btn btn-success" style="width:600px" href="addSupplier.php">Add New Supplier</a><br/><br/>-->
        <form action="" method="post">
            <table style="width: 500px;">
                <tr>
                    <td><input style="width: 485px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><input class="btn btn-success" type="submit" name="search" value="Search"></td>
                </tr>
            </table>
        </form>
        <br/>
    </div>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total cost</th>
            <th>Delivery Date</th>
            <th>Payment Method</th>
            <th>Admin Status</th>
            <th>Supplier Status</th>
            <th>User Status</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orderRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['userId'] ?></td>
                <td><?php echo $values['productId'] ?></td>
                <td><?php echo $values['productName'] ?></td>
                <td><?php echo $values['qtn'] ?></td>
                <td><?php echo $values['cost'] ?></td>
                <td><?php echo $values['deliveryDate'] ?></td>
                <td><?php echo $values['payment'] ?></td>
                <td><?php echo $values['status'] ?></td>
                <td><?php echo $values['supplierStatus'] ?></td>
                <td><?php echo $values['userStatus'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-success' href='transaction.php?action=delivered&id=" . $values['id'] . "'>Delivery Complete</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-success' href='customer-transaction.php?action=customer&id=" . $values['userId'] . "'>View Customer</a>"; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>