<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php

	include "database/DBCustomer.php";
    $msg = "";
    $dbCustomer = new DBCustomer();

    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
       
		if (empty($name)) {
            $msg = $msg . "Customer name must be required";
        }
		if (empty($email)) {
            $msg = $msg . "<br/>Customer email must be required";
        }
		if (empty($contact)) {
            $msg = $msg . "<br/>Customer contact must be required";
        }
		if (empty($address)) {
            $msg = $msg . "<br/>Customer address must be required";
        }
        if ($msg == "") {
			if($dbCustomer->addCustomer($name,$email,$contact,$address))
                $msg="This Customer is successfully added";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-PRODUCT</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body
<body style="font-family: serif;color: black">
<?php include "includes/admin-navbar.php";?>
	<div align="center" class="">
		<form action="" method="post" style="width: 500px">
			<br/><br/><br/>
			<button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
				Field
			</button><br/>
			<div class="">
            <?php
            if ($msg != "") {
                echo '<div class="alert alert-danger">' . $msg . '</div>';
            }
            ?>
			</div>
			<input type="hidden" name="id" value="<?php echo $result['id'] ?>">
			<div class="form-group">
				<input type="text" class="form-control" name="name" id="name" placeholder="Enter Customer Name :"/>
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email" id="email" placeholder="Enter Customer Email : "/>
			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="contact" id="contact" placeholder="Enter Customer Contact : "/>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="address" id="address" placeholder="Enter Customer Address :"/>
			</div>
			<div class="form-group">
				<input style="width: 500px" type="submit" class="btn btn-success" name="add" value="Click here to Add Customer"/>
			</div>
		</form>
	</div>
	<br/>
	<br/>
<?php include "includes/footer.php" ?>
</body>
</html>