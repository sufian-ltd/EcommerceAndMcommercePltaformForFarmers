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
if (isset($_GET['action']) && $_GET['action'] == 'accept') {
    $id = $_GET['id'];
    if ($dbOrder->acceptOrder($id)) {
        $msg = "Order successfully approved...!!!!!!";
    }
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
    $orderRes=$dbOrder->getOrders("Pending");
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
    <title>VIEW-Pending-Orders</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>

<div class="container">
    <br/><br/>

    <div align="center">
<!--        <a class="btn btn-success" style="width:600px" href="addSupplier.php">Add New Supplier</a><br/><br/>-->
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
    </div>
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
                <td>
                    <?php echo "<a class='btn btn-success' href='pending-order.php?action=accept&id=" . $values['id'] . "'>Accept</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='pending-order.php?action=reject&id=" . $values['id'] . "'>Reject</a>"; ?>
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