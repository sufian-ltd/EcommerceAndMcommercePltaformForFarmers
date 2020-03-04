<?php
    session_start();
    $msg = "";
    if( isset($_POST['login']) ) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if($email =="admin@yahoo.com" && $password =="12345") {
            $_SESSION["USER"]="admin";
            header('Location: admin-panel.php');
            exit;
        }
        else {
            $msg = "You entered wrong information...!!!";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/bootstrap-theme.min.css">
    <script src="resources/js/bootstrap.min.js"></script>
</head>
<body style="font-family: serif;color:black" background="images/a.jpg">
<div class="container" align="center">
    <h2>E-commerce And M-commerce Platform For Farmers</h2>
    <hr/>
    <form action="index.php" method="post" style="background-color: #fff;width: 450px;padding: 15px">
        <img src="images/m.png" width="200" height="200">
        <div class="input-group">
            <h3>Admin Login</h3>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input type="email" class="form-control" name="email" id="email1" placeholder="Enter Valid Email Address : "/>
        </div>
        <br/>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" class="form-control" name="password" id="password1"
                   placeholder="Enter Valid Password : "/>
        </div>
        <br/>
        <div class="input-group">
            <button name="login" style="width: 415px" type="submit" class="btn btn-success glyphicon glyphicon-log-in"> Login</button>
        </div>
        <br/>
    </form>
</div>
<br/><br/>
<?php include "includes/footer.php" ?>

</body>
</html>
