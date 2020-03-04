<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<?php
include "database/DBBrand.php";
include "database/DBProduct.php";
$msg = "";
$dbBrand = new DBBrand();
$brandRes=$dbBrand->getBrand();
?>
<?php
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $status = $_POST['status'];
    if (empty($name)) {
        $msg = $msg . "Category name must be required";
    }
    if (empty($status)) {
        $msg = $msg . "<br/>"."Category status must be required";
    }
    if ($msg == "") {
        if ($dbBrand->addBrand($name, $status,0)) {
            $msg = "Category successfully added..!!!!";
            $brandRes=$dbBrand->getBrand();
        }
    }
}
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $brandRes=$dbBrand->searchBrand($key);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    if (empty($name)) {
        $msg = $msg . "Category name must be required";
    }
    if (empty($status)) {
        $msg = $msg . "Category status must be required";
    }
    if ($msg == "") {
        if ($dbBrand->updateBrand($id, $name, $status)) {
            $msg = "Category successfully update..!!!!";
            $brandRes=$dbBrand->getBrand();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>VIEW-PRODUCT-Category</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body
<body style="font-family: serif;color: black">

<?php include "includes/admin-navbar.php";?>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($dbBrand->deleteBrand($id)) {
        $msg = "Category successfully deleted...!!!!!!";
        $brandRes=$dbBrand->getBrand();
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $dbBrand->getBrandById($id);
    ?>
    <div align="center" class="">
        <form action="category.php" method="post" style="width: 500px">
            <br/>
            <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/>
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name"
                       value="<?php echo $result['name'] ?>" placeholder="Enter Category Name :"/>
            </div>
            <div class="form-group">
                   <input type="text" class="form-control" name="status" id="status"
                       value="<?php echo $result['status'] ?>" placeholder="Enter Category Status : "/>
            </div>
            <div class="form-group">
                <input style="width: 500px" type="submit" class="btn btn-success" name="update" value="Click here to Save Changes"/>
            </div>
        </form>
    </div>
<?php } else{ ?>
    <div align="center">
    
        <form action="category.php" method="post" style="width: 500px">
        <br/><br/>
        <button style="background: black;color: #ffffff;font-family: serif;width: 500px;" class="btn btn-success">Add New Category</button>
            <br/><br/>
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Category Name :"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="status" id="status" placeholder="Enter Category Status : "/>
            </div>
            <div class="form-group">
                <input style="width: 500px" type="submit" class="btn btn-success" name="add" value="Click here to Save"/>
            </div>
        </form>
        <br/><br/><br/>
        <form action="" method="post">
            <table style="width: 500px;">
                <tr>
                    <td><input style="width: 500px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><input class="btn btn-success" type="submit" name="search" value="Search Category"></td>
                </tr>
            </table>
        </form>
    </div>
<?php }?>
<div class="container">
    <br/>
    <?php
    if ($msg != "") {
        echo '<div class="alert alert-danger">' . $msg . '</div>';
    }
    ?>

    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Available Brands Added By
        Admin & Specific Authoriry
    </button>

    <table class="table table-striped table-bordered table-hover">
        <tr align="center">
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Category Status</th>
            <th>Total Product</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php foreach ($brandRes as $values) { ?>
            <tr align="center">
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['name'] ?></td>
                <td><?php echo $values['status'] ?></td>
                <?php
                    $dbProduct=new DBProduct();
                    $totalProduct=$dbProduct->getTotalProductByCategory($values['name']);
                ?>
                <td><?php echo $totalProduct['id'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-success' href='category.php?action=edit&id=" . $values['id'] . "'>Update</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='category.php?action=delete&id=" . $values['id'] . "'>Delete</a>"; ?>
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
