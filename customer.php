<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
    include "database/DBCustomer.php";
    $dbCustomer = new DBCustomer;
    $customerRes=$dbCustomer->getCustomer();
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $customerRes=$dbCustomer->searchCustomer($key);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-Customer</title>
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
        <a class="btn btn-success" style="width:600px" href="add-customer.php">Add New Customer</a><br/><br/>
        <form action="" method="post">
            <table style="width: 500px;">
                <tr>
                    <td><input style="width: 480px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><input class="btn btn-success" type="submit" name="search" value="Search Customer"></td>
                </tr>
            </table>
        </form>
    </div>
    <br/>
    <table class="table table-hover table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
        </tr>
        <?php foreach ($customerRes as $values) { ?>
        <tr>
            <td><?php echo $values['id'] ?></td>
            <td><?php echo $values['name'] ?></td>
            <td><?php echo $values['email'] ?></td>
            <td><?php echo $values['contact'] ?></td>
            <td><?php echo $values['address'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>