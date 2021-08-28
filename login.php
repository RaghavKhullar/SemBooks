<?php
session_start();

// check if the user is already logged in
require_once "connection.php";
if (isset($_SESSION['username'])) {
    header("location: dashboard.html");
    exit;
}
$user = $pass = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username + password";

        echo `<script>
         alert('$err');
         </script>`;
        header('location:login.php');
    } else {
        $user = trim($_POST['username']);
        $pass = trim($_POST['password']);
    }


    if (empty($err)) {
        $sql = "SELECT `id`, `username`, `password` FROM details WHERE `username` = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $user;


        // Try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $user, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($pass, $hashed_password)) {
                        // this means the password is corrct. Allow user to login

                        $_SESSION["username"] = $user;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

                        //Redirect user to welcome page
                        header("location:dashboard.php");
                    }
                }
            } else {
                echo `<script>
         alert('Enter correct username and password.');
         </script>`;
                header('location:signup.php');
            }
        }
    }
}


?>


<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="login.css" rel="stylesheet">



    <title>LOGIN</title>
</head>

<body text="white">

    <div class="container">

        <h1>LogIn to Relive Memories</h1>
      

        <form method="POST" action="login.php" class="form">



            <input name="username" type="text" placeholder="Enter your Username" id="username">
            <input name="password" type="password" placeholder="Password" id="password">


            <input type="submit" id="btn" name="submit" value="Log In">
            <p id="ask">Haven't registered? Click here to <a href='signup.php'>SignUp</a></p>
        </form>


    </div>
    </div>
    <div class="bottom">
        <p>Made with &#10084; by Raghav</p>
    </div>
</body>

</html>