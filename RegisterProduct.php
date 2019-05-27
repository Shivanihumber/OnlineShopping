<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ABC Company</title>
    <link rel ="stylesheet" type="text/css" href ="css/style.css">
    <script>
        function onload() {

            var e = document.getElementById ("search1");
            var strUser = e.options [e.selectedIndex] .value;
            document.getElementById("search2").value = strUser;

        }
        function onChange() {

            var e = document.getElementById ("search1");
            var strUser = e.options [e.selectedIndex] .value;
            document.getElementById("search2").value = strUser;

        }
    </script>

</head>
<body onload="onload()">
<header>ABC Company <br><br> Register Product</header>
<form method ="post" >
    Product Name:<select onChange="onChange()" id="search1" name="search1" >
        <?php

        // declaring some variables
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbName = "project";
        $Name='';
        $Serial='';
        $PurchaseDate='';
        $colour='';
        //$Search='Bottle';]
        $Selected=true;

        //Connect to the Server+Select DB
        $con = mysqli_connect($host, $user, $password, $dbName)
        or die("Connection is failed");

        //$Name = $_POST['name'];
        $query = "Select * from product";
        $result = mysqli_query($con, $query) or die ("query is failed" . mysqli_error($con));
        while (($row = mysqli_fetch_row($result)) == true) {
            $Name = $row[0];
            $Serial = $row[1];
            if($Selected==true) {
                echo '<option selected value="' . $Serial . '">' . $Name . '</option>"';
                $Selected = false;
            } else echo '<option value="' . $Serial . '">' . $Name . '</option>"';
            //$PurchaseDate=$row[2];
            //$colour=$row[3];
        }
        mysqli_close($con);
        ?>

    </select>
    <br><br>
    Serial Number:<input type ='text' id="search2" name="search2" disabled="false">
   <br><br>
    Purchase date:<input type ='date' name="search3">
<!--    <br><br>
    Colour:<input type ='text' name="search5">-->

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

    if (empty($_POST["search1"])/* || empty($_POST["search3"]) ||
        empty($_POST["search5"])*/ )
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
        //$data2 = mysqli_real_escape_string($con, $_POST["search2"]);
        $data3 =  mysqli_real_escape_string($con,$_POST["search3"]);
        //$data5 =mysqli_real_escape_string($con, $_POST["search5"]);

//formulate the query and execute
        //$query = "insert into Product values('$data1','$data2','$data3','$data5')";
        //$result = mysqli_query($con, $query);
        //if ($result){

            $query = "insert into Registered_Product values('$username','$data1','$data3')";
            $result = mysqli_query($con, $query);
            if ($result)
                echo "Product is registered succesfully...";
            else
                echo "Registeration failed(2): " . mysqli_error($con);
        //}
        //else
         //   echo "Registeration failed(1): " . mysqli_error($con);

//close the connection

        mysqli_close($con);
    }}

    ?>
</body>
</html>

