<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ABC Company</title>
    <link rel ="stylesheet" type="text/css" href ="css/style.css">
</head>
<body>
<header>ABC Company <br><br> Add Product</header>
<form method ="post" >
    Product Name:<input type ='text' name="search1">
    <br><br>
    Serial Number:<input type ='text' name="search2">
    <br><br>
    Purchase date:<input type ='date' name="search3">
    <br><br>
    Colour:<input type ='text' name="search5">

    <p>
        <input type ="submit" value="Register" name="submit"/>
    </p>

</form>


<?php
/**
 * Created by PhpStorm.
 * User: shi
 * Date: 18-10-2018
 * Time: 12:00
 */

session_start();
$username = $_SESSION['username'];

if (isset($_POST["submit"])) {

    if (empty($_POST["search1"]) || empty($_POST["search2"]) || empty($_POST["search3"]) ||
        empty($_POST["search5"]) )
        echo "Please fill all the fields..";
    else {

//connect to MySql and Select DB
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbName = "project";
        $con = mysqli_connect($host, $user, $password, $dbName)
        or die("Connection is Failed" . mysqli_connect_error());

        $data1 = mysqli_real_escape_string($con,$_POST["search1"]);
        $data2 = mysqli_real_escape_string($con, $_POST["search2"]);
        $data3 =  mysqli_real_escape_string($con,$_POST["search3"]);
        $data5 =mysqli_real_escape_string($con, $_POST["search5"]);

//formulate the query and execute
        $query = "insert into Product values('$data1','$data2','$data3','$data5')";
        $result = mysqli_query($con, $query);
        if ($result){
            $query = "insert into Registered_Product values('$username','$data1')";
            $result = mysqli_query($con, $query);
            if ($result)
                echo "Product is registered succesfully...";
            else
                echo "Registeration failed(2): " . mysqli_error($con);
        }
        else
            echo "Registeration failed(1): " . mysqli_error($con);

//close the connection

        mysqli_close($con);
    }}

?>
</body>
</html>

