<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ABC Company</title>
    <link rel ="stylesheet" type="text/css" href ="css/style.css">
</head>
<body>
<header>ABC Company <br><br>Update User</header>
<form method="post" >
    Password : <input type="password" name="ppass"/><br>
    Name : <input type="text" name="pname"/><br>
    Cell phone : <input type="text" name="pcell"/><br>
    Email : <input type="text" name="pmail"/><br>
    Address : <input type="text" name="paddr"/><br>
    <input type="submit" value="Register" name="submit"/>
    <input type ="submit" value="Back" name="back"/>
</form>

<?php
include('DB_Connect.php');
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "ADMIN")
    die("Session die");
$name = $_SESSION['session_user'];

if (isset($_POST["submit"])) {

    if (empty($_POST["ppass"]) || empty($_POST["pname"]) || empty($_POST["pcell"]) ||
        empty($_POST["pmail"]) || empty($_POST["paddr"]))
        echo "Please fill all the fields..";
    else {

        $con = db_connect();

        $ppass = mysqli_real_escape_string($con, $_POST["ppass"]);
        $pname = mysqli_real_escape_string($con, $_POST["pname"]);
        $pcell = mysqli_real_escape_string($con, $_POST["pcell"]);
        $pmail = mysqli_real_escape_string($con, $_POST["pmail"]);
        $paddr = mysqli_real_escape_string($con, $_POST["paddr"]);


//query execution
        $query = "update User set password='$ppass', name='$pname', cellphone='$pcell', email='$pmail', address='$paddr' where username='$name'";
        $result = mysqli_query($con, $query);
        if ($result)
            echo "User $name updated succesfully...";
        else
            echo "Update failed : " . mysqli_error($con);

//close connection
        mysqli_close($con);
    }

}

if (isset($_POST["back"])) {
    header('location:Admin_page.php');
}

?>

</body>
</html>