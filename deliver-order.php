<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>

<?php
include "database/DBOrder.php";
include "database/DBSupplier.php";
$dbOrder = new DBOrder();
$dbSupplier = new DBSupplier();
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'deliveryorder') {
    
    $id = $_GET['id'];
    $productId=$_GET['productId'];
    $qtn=$_GET['qtn'];
    $orderRes=$dbOrder->getOrderByOrderId($id);
}

?>
<?php
 function fetch_data($id)  
 {  
      $output = ''; 
      $dbOrder = new DBOrder(); 
      $orderRes=$dbOrder->getOrderByOrderId($id);      
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
if(isset($_GET["generatePdf"])) {  

        $id = $_GET['id'];
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
        $content .= fetch_data($id);
        $content .= '</table>';  
        $obj_pdf->writeHTML($content);  
        $obj_pdf->Output('file.pdf', 'I');  
 }  
?> 
<?php
    if (isset($_GET['deliver'])) {
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
<!DOCTYPE html>
<html>
<head>
    <title>DELIVER ORDER</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>
	<div class="container" align="center">
		<br/><br/><br/>
        <form action="" method="get">
            <input type="hidden" name="id" value="<?php echo $orderRes['id'] ?>">
            <input class="form-control btn btn-primary" style="width: 200px" type="submit" name="generatePdf" value="Generate Report">
        </form>
        <br/><br/><br/>
		<button style="background: black;color: #ffffff;font-family: serif;width: 400px" class="form-control">Please Fill The Specific
                Field
            </button>
		<table class="table table-striped table-bordered table-hover" style="width: 400px">
			<tr align="center">
            	<th>Description</th>
            	<th>Values</th>
            </tr>
            <tr align="center">
            	<td>Order ID : </td>
            	<td><?php echo $orderRes['id'] ?></td>
            </tr>
            <tr align="center">
            	<td>User ID : </td>
            	<td><?php echo "".$orderRes['userId'] ?></td>
            </tr>
            <tr align="center">
            	<td>Product ID : </td>
            	<td><?php echo "".$orderRes['productId'] ?></td>
            </tr>
            <tr align="center">
            	<td>Product Name : </td>
            	<td><?php echo "".$orderRes['productName'] ?></td>
            </tr>
            <tr align="center">
            	<td>Product Quantity : </td>
            	<td><?php echo "".$orderRes['qtn'] ?></td>
            </tr>
            <tr align="center">
            	<td>Total Cost : </td>
            	<td><?php echo "".$orderRes['cost'] ?></td>
            </tr>
            <tr align="center">
            	<td>Order Date : </td>
            	<td><?php echo "".$orderRes['orderDate'] ?></td>
            </tr>
            <tr align="center">
            	<td>Payment Method : </td>
            	<td><?php echo "".$orderRes['payment'] ?></td>
            </tr>
            <tr align="center">
            	<td>Delivery Date : </td>
            	<td><?php echo "".$orderRes['deliveryDate'] ?></td>
            </tr>
            <form action="" method="get">
        	<input type="hidden" name="orderId" value="<?php echo $orderRes['id'] ?>">
            <tr align="center">
            	<td>Enter Supplier ID : </td>
            	<td><input style="width: 120px" class="form-control" type="number" name="supplierId" placeholder=""></td>
            </tr>
            <tr align="center">
            	<td>Action</td>
            	<td>
            		<input class="btn btn-success" type="submit" name="deliver" value="Click Here To Confirm Delivery">
            	</td>
            </tr>
            </form>
        </table>
	</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>