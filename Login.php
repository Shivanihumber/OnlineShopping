<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ABC Company</title>
    <link rel ="stylesheet" type="text/css" href ="css/style.css">
</head>
<body>
<header>ABC Company <br><br>User Login</header>
<form method ="post" >
    User Name:<input type ='text' name="searchFor" id="user"> <br><br>
    Password:<input type ='text' name="search">
    <p>
        <input type ="submit" value="Login" name="submit"/>
    </p>
</form>

<?php
/**
 * Created by PhpStorm.
 * User: shi
 * Date: 18-10-2018
 * Time: 12:23
 */


function insert_log($uname){
    $myFile = fopen("Project_LOG.txt",'a')
    or die ("Unable to open LOG file");
    fwrite($myFile,$uname);
    fwrite($myFile,date("Y-m-d"));  // date
    fwrite($myFile,date("h:i:sa")); // time
    fwrite($myFile,"\r\n");
    fclose($myFile);
}


//Read form data
//if we use name="submit " its easy for all form fields
if(isset($_POST["submit"])) {


    if (isset($_POST["searchFor"])) {

        if (empty($_POST["searchFor"]) || empty($_POST["search"]))
            echo "Please fill all the fields..";
        else {


            $host = "localhost";
            $user = "root";
            $password = "";
            $dbName = "project";


//connect to MySql and Select DB

            $con = mysqli_connect($host, $user, $password, $dbName)
            or die("Connection is Failed" . mysqli_connect_error());

            $keyword = mysqli_real_escape_string($con, $_POST['search']);
            $username = mysqli_real_escape_string($con, $_POST['searchFor']);



            insert_log($username);

            $query = "SELECT * FROM USER where username='" . $username . "' and password='" . $keyword . "'";
            $result = mysqli_query($con, $query);
            $row = mysqli_num_rows($result);
            // if(mysqli_num_rows($result)>0)
            if ($row != 0) {
                echo "successfully logged in";
                session_start();
                $_SESSION['username'] = $username;
                if ($username == 'ADMIN')
                    header('location:Admin_page.php');
                else
                    header('location:RegisterProduct.php');
            } else
                echo "Login failed...";
            mysqli_close($con);
        }
    }

}

?>

</body>
</html>