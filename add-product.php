<?php
session_start();
if (isset($_SESSION['USER']) != "admin") {
    header('Location: index.php');
    exit();
}
?>
<?php

    include "database/DBProduct.php";
    include "database/DBBrand.php";
    $msg = "";
    $dbProduct=new DBProduct();
    $dbBrand = new DBBrand();

    if (isset($_POST['add'])) {
        $category = $_POST['selectCategory'];
        $name = $_POST['productName'];
        $afterDiscount = $_POST['afterDiscount'];
        $beforeDiscount = $_POST['beforeDiscount'];
        $unit=$_POST['unit'];
        $image = $_FILES['image']['tmp_name'];
        if(!empty($image))
            $image = file_get_contents($image);
        $qtn = $_POST['quantity'];
        $sells=0;
        if ($category=="nothing") {
            $msg = $msg . "<br/>Category name must be required";
        }
        if (empty($name)) {
            $msg = $msg . "<br/>Product name must be required";
        }
        if (empty($beforeDiscount)) {
            $msg = $msg . "<br/>Before discount must be required";
        }
        if (empty($afterDiscount)) {
            $msg = $msg . "<br/>After discount must be required";
        }
        if (empty($unit)) {
            $msg = $msg . "<br/>Unit must be required";
        }
        if (empty($qtn)) {
            $msg = $msg . "<br/>Quantity must be required";
        }
        if (empty($image)) {
            $msg = $msg . "<br/>Image must be required";
        }
        if ($msg == "") {
            if($dbProduct->addProduct($category, $name,$unit, $beforeDiscount, $afterDiscount,$qtn,$image,$sells)){
                $dbBrand->addQtnToCategory($category,$qtn);
                $msg="This product is successfully added";
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

<div align="center">
    <br/><br/>
    <form action="add-product.php" method="post"
      style="width: 500px" enctype="multipart/form-data">
        <div class="input-group">
            <?php
            if ($msg != "") {
                echo '<div class="alert alert-danger">' . $msg . '</div>';
            }
            ?>
        </div>
        <button style="background: black;color: #ffffff;font-family: serif" class="form-control btn-primary">Please Fill The Specific Field</button>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <select class="form-control" name="selectCategory">
                <option value="nothing">Select Category</option>
                <?php foreach ($dbProduct->getCategories() as $values) {?>
                    <option value="<?php echo $values['name']?>"><?php echo $values['name']?></option>
                <?php }?>
            </select>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input type="text" class="form-control" name="productName" id="productName1"
                   placeholder="Enter Product Name : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <select name="unit" class="form-control">
                <option value="Kilogram(KG)">Kilogram(KG)</option>
                <option value="Unit(U)">Unit(U)</option>
                <option value="Litre(L)">Litre(L)</option>
            </select>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input type="number" class="form-control" name="beforeDiscount" id="beforeDiscount1"
                   placeholder="Enter price before discount : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input type="number" class="form-control" name="afterDiscount" id="afterDiscount1"
                   placeholder="Enter price after discount : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input type="file" class="form-control" name="image" id="image"/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
            <input type="number" class="form-control" name="quantity" id="quantity1"
                   placeholder="Enter Product Quantity"/>
        </div>
        <br/>
        <div class="form-group">
            <button name="add" style="width: 500px" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Add Product
            </button>
        </div>
    </form>
</div>
<br/>
<br/>
<?php include "includes/footer.php" ?>
</body>
</html>