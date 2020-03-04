<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php

	include "database/DBSupplier.php";
    $msg = "";
    $dbSupplier = new DBSupplier();

    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password=$_POST['password'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $salary = $_POST['salary'];
       
		if (empty($name)) {
            $msg = $msg . "Supplier name must be required";
        }
		if (empty($email)) {
            $msg = $msg . "<br/>Supplier username must be required";
        }
        if (empty($password)) {
            $msg = $msg . "<br/>Supplier password must be required";
        }
		if (empty($contact)) {
            $msg = $msg . "<br/>Supplier contact must be required";
        }
		if (empty($address)) {
            $msg = $msg . "<br/>Supplier address must be required";
        }
		if (empty($salary)) {
            $msg = $msg . "<br/>Supplier salary must be required";
        }
        if ($msg == "") {
			if($dbSupplier->addSupplier($name,$email,$password,$contact,$address,$salary))
                $msg="This Supplier is successfully added";
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
				<input type="text" class="form-control" name="name" id="name" placeholder="Enter Supplier Name :"/>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="text" id="" placeholder="Enter Supplier Username : "/>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" id="" placeholder="Enter Supplier Password : "/>
			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="contact" id="contact" placeholder="Enter Supplier Contact : "/>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" name="address" id="address" placeholder="Enter Supplier Address :"/>
			</div>
			<div class="form-group">
				<input type="number" class="form-control" name="salary" id="salary" placeholder="Enter Supplier Salary"/>
			</div>
			<div class="form-group">
				<input style="width: 500px" type="submit" class="btn btn-success" name="add" value="Click here to Add Supplier"/>
			</div>
		</form>
	</div>
	<br/>
	<br/>
<?php include "includes/footer.php" ?>
</body>
</html>