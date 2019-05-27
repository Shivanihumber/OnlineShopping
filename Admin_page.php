<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ABC Company</title>
    <link rel ="stylesheet" type="text/css" href ="css/style.css">
</head>
<body>
<header>ABC Company <br><br>Admin</header>
<form method="post" >
    Username : <input type="text" name="name"/>
    <input type="submit" value="Search" name="srcUsr"/>
    <input type="submit" value="Update" name="updUsr"/>
    <input type="submit" value="Delete" name="delUsr"/><br><br>

    Product : <input type="text" name="product"/>
    <input type="submit" value="Search" name="srcProduct"/>
    <input type="submit" value="Update" name="updProduct"/>
    <input type="submit" value="Create" name="crtProduct"/><br><br>

    Registered Product :
    <input type="submit" value="Search" name="srcRegProduct"/>
    <input type="submit" value="Delete" name="delRegProduct"/>
    <input type="submit" value="Create" name="crtRegProduct"/><br><br>

    <input type ="submit" value="Back" name="back"/>
</form>

<?php

include ("Include_DB_Connect.php");
include ("Include_find_user.php");
include ("Include_find_product.php");
include ("Include_find_registered.php");

function goAdmin_Product($product,$cr_up){
    session_start();
    $_SESSION['session_product']=$product;
    $_SESSION['update_insert']=$cr_up;
    header('location:Admin_product.php');
}
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "ADMIN")
    die("Session die");

if (isset($_POST["srcUsr"])){
    $con = db_connect();
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $result = find_user($con,$name);
    if (mysqli_num_rows($result) == 0)
        echo "No User found";
    else
    {
        echo "Number of users found:".mysqli_num_rows($result);
        echo "<table border='1' <tr><th>Username</th><th>Password</th><th>Name</th><th>Cellphone</th><th>Email</th><th>Address</th></tr>";
        while (($row = mysqli_fetch_row($result)) == true ) {
            echo "<tr> <td>$row[0]</td> <td>$row[1]</td> <td>$row[5]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td> </tr> ";
        }
    }
    mysqli_close($con);
}

if (isset($_POST["delUsr"])) {
    $con = db_connect();
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    if (empty($name))
        echo "Enter user name to be deleted...";
    else{
        $result = find_user($con,$name);
        if (mysqli_num_rows($result) == 0)
            echo "User not found...";
        else{
            $query = "delete from User where username = '$name'";
            $result = mysqli_query($con, $query)
                or die ("Query is failed : " . mysqli_error($con));
            if (mysqli_affected_rows($con) != 0)
                echo "User $name deleted succesfully...";
        }
    }
}
if (isset($_POST["updUsr"])) {
    $con = db_connect();
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    if (empty($name))
        echo "Enter user name to be updated...";
    else{
        $result = find_user($con,$name);
        if (mysqli_num_rows($result) == 0)
            echo "User not found...";
        else{
            session_start();
            $_SESSION['session_user']=$name;
            header('location:Admin_user.php');
        }
    }
}

if (isset($_POST["srcProduct"])){

    $con = db_connect();
    $product = mysqli_real_escape_string($con, $_POST["product"]);
    $result = find_product($con,$product);

    if (mysqli_num_rows($result) == 0)
        echo "No product found...";
    {
        echo "Number of products found : ".mysqli_num_rows($result);
        echo "<table border='1' <tr><th>Product Name</th><th>Serial</th><th>Purchase date</th><th>Color</th></tr>";

        while (($row = mysqli_fetch_row($result)) == true ) {
            echo "<tr> <td>$row[0]</td> <td>$row[1]</td> <td>$row[2]</td><td>$row[3]</td></tr> ";
        }
    }
    mysqli_close($con);
}


if (isset($_POST["updProduct"])){
    $con = db_connect();
    $product = mysqli_real_escape_string($con, $_POST["product"]);
    if (empty($product))
        echo "Please enter product name to be updated !!";
    else{
        $result = find_product($con,$product);
        if (mysqli_num_rows($result) == 0)
            echo "No product is found with this name...";
        else{
            goAdmin_product($product,"updated");
        }
    }
}

if (isset($_POST["crtProduct"])){
    $con = db_connect();
    $product = mysqli_real_escape_string($con, $_POST["product"]);
    if (empty($product))
        echo "Please enter product name to be created !!";
    else{
        $result = find_product($con,$product);
        if (mysqli_num_rows($result) != 0)
            echo "There is a product with this name...";
        else{
            goAdmin_product($product,"inserted");
        }
    }
}

if (isset($_POST["srcRegProduct"])){

    $con = db_connect();
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $product = mysqli_real_escape_string($con, $_POST["product"]);
    $result = find_registered_product($con,$name,$product);
    if (mysqli_num_rows($result) == 0)
        echo "No registered product found";
    else{
        echo "Number of registered products found:".mysqli_num_rows($result);
        echo "<table border='1' <tr><th>User Name</th><th>Product Name</th></tr>";

        while (($row = mysqli_fetch_row($result)) == true ) {
            echo "<tr> <td>$row[0]</td> <td>$row[1]</td> </tr> ";
        }
    }
    mysqli_close($con);
}
if (isset($_POST["delRegProduct"])){
    $con = db_connect();
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $product = mysqli_real_escape_string($con, $_POST["product"]);
    if (empty($name) || empty($product))
        echo "Enter user name and product name...";
    else{
        $result = find_registered_product($con,$name,$product);
        if (mysqli_num_rows($result) == 0)
            echo "No registered product found to be deleted...";
        {
            $query = "delete from Registered_product where username = '$name' and product_name='$product'";
            $result = mysqli_query($con, $query)
                or die ("Query is failed : " . mysqli_error($con));
            if (mysqli_affected_rows($con) != 0)
                echo "Reqistered product deleted succesfully...";
        }
    }
    mysqli_close($con);
}
if (isset($_POST["crtRegProduct"])){
    $con = db_connect();
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $product = mysqli_real_escape_string($con, $_POST["product"]);
    if (empty($name) || empty($product))
        echo "Enter user name and product name...";
    else{
        $result = find_registered_product($con,$name,$product);
        if (mysqli_num_rows($result) != 0)
            echo "Product $product is already registered to user $name ...";
        {
            $query = "insert into Registered_product values('$name','$product')";
            $result = mysqli_query($con, $query)
            or die ("Query is failed : " . mysqli_error($con));
            if (mysqli_affected_rows($con) != 0)
                echo "Product $product is succesfully registered to user $name ...";
        }
    }
    mysqli_close($con);
}

if (isset($_POST["back"])) {
    header('location:Main_page.html');
}

?>

</body>
</html>