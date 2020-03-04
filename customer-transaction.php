<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBOrder.php";
include "database/DBCustomer.php";
$dbOrder = new DBOrder();
$dbCustomer = new DBCustomer;
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'customer') {
    $id = $_GET['id'];
    $orderRes=$dbOrder->getOrderById($id);
    $customerRes=$dbCustomer->getCustomerById($id);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Customer-Transaction</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>

<div class="container">
    <br/><br/>
    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Selected Customer Information</button>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
        </tr>
        <tr>
            <td><?php echo $customerRes['id'] ?></td>
            <td><?php echo $customerRes['name'] ?></td>
            <td><?php echo $customerRes['email'] ?></td>
            <td><?php echo $customerRes['contact'] ?></td>
            <td><?php echo $customerRes['address'] ?></td>
        </tr>
    </table>
    <br/><br/>
    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The List of Product Transaction By This Selected Customer</button>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total cost</th>
            <th>Delivery Date</th>
            <th>Status</th>
        </tr>
        <?php foreach ($orderRes as $values) { ?>
            <tr>
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['productId'] ?></td>
                <td><?php echo $values['productName'] ?></td>
                <td><?php echo $values['qtn'] ?></td>
                <td><?php echo $values['cost'] ?></td>
                <td><?php echo $values['deliveryDate'] ?></td>
                <td><?php echo $values['status'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>