<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ABC Company</title>
    <link rel ="stylesheet" type="text/css" href ="css/style.css">
</head>
<body>
<header>ABC Company <br><br> Product</header>
<form method ="post" >
    Serial Number:<input type ='text' name="search2">
    <br><br>
    Purchase date:<input type ='date' name="search3">
    <br><br>
    Colour:<input type ='text' name="search5">

    <p>
        <input type ="submit" value="Register" name="submit"/>
        <input type ="submit" value="Back" name="back"/>
    </p>

</form>


<?php
include('Include_DB_Connect.php');

session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "ADMIN")
    die("Session die");
$product = $_SESSION['session_product'];
$update_insert = $_SESSION['update_insert'];

if (isset($_POST["submit"])) {

    if (empty($_POST["search2"]) || empty($_POST["search3"]) || empty($_POST["search5"]) )
        echo "Please fill all the fields..";
    else {

//connect to MySql and Select DB
        $con = db_connect();

        $data2 = mysqli_real_escape_string($con, $_POST["search2"]);
        $data3 =  mysqli_real_escape_string($con,$_POST["search3"]);
        $data5 =mysqli_real_escape_string($con, $_POST["search5"]);

//formulate the query and execute
        if ($update_insert !="updated")
            $query = "insert into Product values('$product','$data2','$data3','$data5')";
        else
            $query = "update Product set serial = '$data2', purchasedate = '$data3', colour = '$data5' where name = '$product' ";
        $result = mysqli_query($con, $query);
        if ($result)
            echo "Product is $update_insert succesfully...";
        else
            echo "Transaction failed : " . mysqli_error($con);

//close the connection

        mysqli_close($con);
    }
}
if (isset($_POST["back"])) {
    header('location:Admin_page.php');
}
?>
</body>
</html>

