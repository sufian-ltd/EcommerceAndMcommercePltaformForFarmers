<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBOrder.php";
include "database/DBProduct.php";
include "database/DBSupplier.php";
$dbOrder = new DBOrder();
$dbProduct=new DBProduct();
$dbSupplier = new DBSupplier();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'deliver') {
    $id = $_GET['id'];

    $productId=$_GET['productId'];
    $qtn=$_GET['qtn'];
    if ($dbOrder->deliverOrder($id)) {
        $dbProduct->sellProduct($productId);
    $dbProduct->updateStock($productId,$qtn);
        $msg = "Order successfully delivered...!!!!!!";
    }
}
?>
<?php
    if (isset($_GET['deliver']) && $_GET['status']!="Sending") {
        $orderId=$_GET['orderId'];
        $supplierId=$_GET['supplierId'];
        $dbSupplier->makeOrder($orderId,$supplierId);
        $dbOrder->setAdminStatus("Sending",$orderId);
        $dbOrder->setSupplierStatus("Delivery Pending",$orderId);
        $dbOrder->setUserStatus("Not Received",$orderId);
        //header('Location: transaction.php');
        //exit();
    }
?>
<?php
 function fetch_data($orderId)  
 {  
      $output = ''; 
      $dbOrder = new DBOrder(); 
      $orderRes=$dbOrder->getOrderByOrderId($orderId);      
      $output .= '
        <tr>  
            <td>'.'Order ID : '.'</td>  
            <td>'.$orderRes['id'].'</td>
        </tr>
        <tr>
            <td>'.'User ID : '.'</td>  
            <td>'.$orderRes['userId'].'</td>
        </tr>
        <tr>
            <td>'.'Product ID : '.'</td>  
            <td>'.$orderRes['productId'].'</td>
        </tr>
        <tr>
            <td>'.'Product Name : '.'</td>  
            <td>'.$orderRes['productName'].'</td>
        </tr>
        <tr>
            <td>'.'Product Quantity : '.'</td>  
            <td>'.$orderRes['qtn'].'</td>
        </tr>
        <tr>
            <td>'.'Total Cost : '.'</td>  
            <td>'.$orderRes['cost'].'</td>
        </tr>
        <tr>
            <td>'.'Order Date : '.'</td>  
            <td>'.$orderRes['orderDate'].'</td>
        </tr>
        <tr>
            <td>'.'Payment Method : '.'</td>  
            <td>'.$orderRes['payment'].'</td>
        </tr>
        <tr>
            <td>'.'Delivery Date : '.'</td>  
            <td>'.$orderRes['deliveryDate'].'</td>
        </tr>  
                          ';   
      return $output;  
 }  
?>
<?php 
if(isset($_GET["generateReport"])) {  

        $orderId=$_GET['orderId'];
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
                <th>Description</th>  
                <th>Values</th>  
           </tr>  
        ';  
        $content .= fetch_data($orderId);
        $content .= '</table>';  
        $obj_pdf->writeHTML($content);  
        $obj_pdf->Output('file.pdf', 'I');  
 }  
?> 
<?php
if (isset($_GET['action']) && $_GET['action'] == 'reject') {
    $id = $_GET['id'];
    if ($dbOrder->rejectOrder($id)) {
        $msg = "Order successfully removed...!!!!!!";
    }
}
?>
<?php
$orderRes=$dbOrder->getSendngAppOrders();
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $orderRes=$dbOrder->searchOrder($key);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Approved-Orders</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>

<div class="container" style="min-height: 400px;">
    <br/><br/>

    <!-- <div align="center">
        <form action="" method="post">
            <table style="width: 500px;">
                <tr>
                    <td><input style="width: 485px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><input class="btn btn-success" type="submit" name="search" value="Search Order"></td>
                </tr>
            </table>
        </form>
        <br/>
    </div> -->
    <form action="" method="get">
    <select class="form-control" name="supplierId" style="width: 150px;float: right;margin-bottom: 10px;">
        <?php $supplierRes=$dbSupplier->getSupplier(); ?>
        <?php foreach ($supplierRes as $values) { ?>
            |<option value="<?php echo $values['id'] ?>"><?php echo $values['name'] ?></option>
        <?php } ?>
    </select>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total cost</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Action</th>
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
                <td><?php echo $values['orderDate'] ?></td>
                <td><?php echo $values['deliveryDate'] ?></td>
                <td><?php echo $values['payment'] ?></td>
                <td><?php echo $values['status'] ?></td>
                <input type="hidden" name="orderId" value="<?php echo $values['id']?>">
                <input type="hidden" name="status" value="<?php echo $values['status']?>">
                <td>
                    <input class="btn btn-success" type="submit" name="generateReport" value="Report">
                </td>
                <td>
                    <input class="btn btn-success" type="submit" name="deliver" value="Deliver">
                </td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='approved-order.php?action=reject&id=" . $values['id'] . "'>Reject</a>"; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    </form>
</div>

<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>