<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php
include "database/DBProduct.php";
$msg = "";
$dbProduct = new DBProduct();
$productRes=$dbProduct->getProduct();
?>
<?php
if(isset($_POST['search']))
{
    $key=$_POST['key'];
    $productRes=$dbProduct->searchProduct($key);
}
?>
<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $beforeDiscount = $_POST['beforeDiscount'];
    $afterDiscount = $_POST['afterDiscount'];
    $image = $_FILES['image']['tmp_name'];
    if (!empty($image))
        $image = file_get_contents($image);
    $unit = $_POST['unit'];
    $qtn = $_POST['quantity'];
    $sells = $_POST['sells'];
    if (empty($name)) {
        $msg = $msg . "Product name must be required";
    }
    if (empty($beforeDiscount)) {
        $msg = $msg . "<br/>Before discount must be required";
    }
    if (empty($afterDiscount)) {
        $msg = $msg . "<br/>After discount must be required";
    }
    if (empty($qtn)) {
        $msg = $msg . "<br/>Quantity must be required";
    }
    if (empty($image)) {
        $msg = $msg . "<br/>Image must be required";
    }
    if ($msg == "") {
        if ($dbProduct->updateProduct($id, $name,$unit, $beforeDiscount,$afterDiscount,$qtn,$image,$sells)) {
            $msg = "Product successfully update..!!!!";
            $productRes=$dbProduct->getProduct();
        }
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

<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($dbProduct->deleteProduct($id)) {
        $msg = "Category successfully deleted...!!!!!!";
        $productRes=$dbProduct->getProduct();
    }
}
?>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $dbProduct->getProductById($id);
    ?>
    <div align="center" class="">
        <form action="product.php" method="post" style="width: 500px" enctype="multipart/form-data">
            <br/>
            <button style="background: black;color: #ffffff;font-family: serif" class="form-control">Please Fill The Specific
                Field
            </button>
            <br/>
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <input type="hidden" name="sells" value="<?php echo $result['sells'] ?>">
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="name"
                       value="<?php echo $result['name'] ?>" placeholder="Enter Product Name :"/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="beforeDiscount" id="beforeDiscount1"
                       value="<?php echo $result['beforeDiscount'] ?>" placeholder="Enter price before discount : "/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="afterDiscount" id="afterDiscount1"
                       value="<?php echo $result['afterDiscount'] ?>" placeholder="Enter price after discount : "/>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="image" id="image"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="unit" id="unit"
                       value="<?php echo $result['unit'] ?>" placeholder="Enter Product Unit :"/>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="quantity" id="quantity1"
                       value="<?php echo $result['qtn'] ?>" placeholder="Enter Product Quantity"/>
            </div>
            <div class="form-group">
                <input style="width: 500px" type="submit" class="btn btn-success" name="update" value="Click here to Save Changes"/>
            </div>
        </form>
    </div>
<?php } else{ ?>
    <div align="center">
        <br/><br/>
        <a class="btn btn-success" style="width:600px" href="add-product.php">Add New Product</a><br/><br/>
        <form action="" method="post">
            <table style="width: 500px;">
                <tr>
                    <td><input style="width: 490px;" class="form-control" name="key" type="text"
                               placeholder="Enter Keyword..."></td>
                    <td><input class="btn btn-success" type="submit" name="search" value="Search Product"></td>
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

    <button style="background: black;color: #ffffff;font-family: serif;font-size: 15px" class="form-control">The Available Product Added By
        Admin & Specific Authoriry
    </button>

    <table class="table table-striped table-bordered table-hover">
        <tr align="center">
            <th>Product ID</th>
            <th>Category</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Unit(KG,L,U)</th>
            <th>Before Discount</th>
            <th>After Discount</th>
            <th>Total Stock</th>
            <th>Total Sells</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        <?php foreach ($productRes as $values) { ?>
            <tr align="center">
                <td><?php echo $values['id'] ?></td>
                <td><?php echo $values['category'] ?></td>
                <td><?php echo $values['name'] ?></td>
                <td>
                    <?php echo '<img width="150" height="150" src="data:image/jpg;base64,' . base64_encode($values['image']) . '">' ?>
                </td>
                <td><?php echo $values['unit'] ?></td>
                <td><?php echo $values['beforeDiscount'] ?></td>
                <td><?php echo $values['afterDiscount'] ?></td>
                <td><?php echo $values['qtn'] ?></td>
                <td><?php echo $values['sells'] ?></td>
                <td>
                    <?php echo "<a class='btn btn-success' href='product.php?action=edit&id=" . $values['id'] . "'>Update</a>"; ?>
                </td>
                <td>
                    <?php echo "<a class='btn btn-danger' href='product.php?action=delete&id=" . $values['id'] . "'>Delete</a>"; ?>
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
