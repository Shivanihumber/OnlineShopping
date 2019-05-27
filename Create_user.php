<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ABC Company</title>
    <link rel ="stylesheet" type="text/css" href ="css/style.css">
</head>
<body>
<header>ABC Company <br><br> Create User</header>
<form method="post" >
    Username : <input type="text" name="puname" id="puname"/> <br>
    Password : <input type="password" name="ppass"/><br>
    Cell phone : <input type="text" name="pcell"/><br>
    Email : <input type="text" name="pmail"/><br>
    Name : <input type="text" name="pname"/><br>
    Address : <input type="text" name="paddr"/><br>
    <input type="submit" value="Register" name="register"/>
    <input type ="submit" value="Back" name="back"/>
</form>




<?php
include('Include_DB_Connect.php');
include('Include_find_user.php');

if (isset($_POST["register"])) {

    if (empty($_POST["puname"]) || empty($_POST["ppass"]) || empty($_POST["pcell"]) ||
        empty($_POST["pmail"]) || empty($_POST["pname"]) || empty($_POST["paddr"]))
        echo "Please fill all the fields..";
    else {
        $con = db_connect();

        $puname = mysqli_real_escape_string($con, $_POST["puname"]);
        $ppass = mysqli_real_escape_string($con, $_POST["ppass"]);
        $pcell = mysqli_real_escape_string($con, $_POST["pcell"]);
        $pmail = mysqli_real_escape_string($con, $_POST["pmail"]);
        $pname = mysqli_real_escape_string($con, $_POST["pname"]);
        $paddr = mysqli_real_escape_string($con, $_POST["paddr"]);

        $result = find_user($con,$puname);

        if (mysqli_num_rows($result) != 0)
            echo "User is already created...";
        else {
            $query = "insert into User values ('$puname','$ppass','$pcell','$pmail','$pname','$paddr')";
            $result = mysqli_query($con, $query);
            if ($result)
                echo "User created succesfully...";
            else
                echo "Insert is failed : " . mysqli_error($con);
        }
//close connection
        mysqli_close($con);
    }

}
if (isset($_POST["back"])) {
    header('location:Main_page.html');
}
?>

</body>
</html>