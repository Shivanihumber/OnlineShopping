<head>
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
Product Name:
    <select onChange="onChange()" id="search1" name="search1" >
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
</body>
