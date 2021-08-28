<?php
require_once "connection.php";
$user = $pass = $confirm_pass = "";
$user_err = $pass_err = $confirm_pass_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (empty(trim($_POST["username"]))) {
        $user_err = "Username cannot be blank";
        // echo `<script>
        // //  alert($user_err);
        // //  </script>`;
        // // header('location:signup.php');
    } else {
        $sql = "SELECT id FROM details WHERE username = ?";
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);


            $param_username = trim($_POST['username']);


            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $user_err = "This username is already taken";
        //             echo `<script>
        //  alert($user_err);
        //  </script>`;
        //             header('location:signup.php');
                } else {
                    $user = trim($_POST['username']);
                }
            } else {
                echo "something went wrong";
        //         echo `<script>
        //  alert('Something went wrong');
        //  </script>`;
        //         header('location:signup.php');
            }
        }
        mysqli_stmt_close($stmt);
    }




    // Check for password
    if (empty(trim($_POST['password']))) {
        $pass_err = "Password cannot be blank";
        // echo `<script>
        //  alert($pass_err);
        //  </script>`;
        // header('location:signup.php');
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $pass_err = "Password cannot be less than 5 characters";
        echo `<script>
        //  alert($pass_err);
        //  </script>`;
        // header('location:signup.php');
    } else {
        $pass = trim($_POST['password']);
    }

    // Check for confirm password field
    if (trim($_POST['password']) !=  trim($_POST['confirm_password'])) {
        $pass_err = "Passwords should match";
        // echo `<script>
        //  alert($pass_err);
        //  </script>`;
        // header('location:signup.php');
    }



    // If there were no errors, go ahead and insert into the database
    if (empty($user_err) && empty($pass_err) && empty($confirm_pass_err)) {
        $sql = "INSERT INTO details (`username`, `password`,`email`) VALUES (?, ?,?)";
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password,$param_email);

            // Set these parameters
            $param_username = $user;
            $param_password = password_hash($pass, PASSWORD_DEFAULT);
            $param_email=$_POST['email'];
            $insert_books_table="INSERT INTO books (`username`) VALUES ('$user')";
            $final_insert=mysqli_query($con, $insert_books_table);
            // $param_role=$_POST['role'];
            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "You have registered";
                header("location:login.php");
            } else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($con);
}

?>

<!doctype html>
<html lang="en">

<head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="login.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
  

    <title>SignUp</title>
</head>

<body text="white">




    <div class="container" class='main'>

        <h1>SignUp to Relive Memories</h1>
        

        <form method="POST" action="signup.php" class="form">



            <input name="username" type="text" placeholder="Enter your Username" id="username">
            <input name="email" type="email" placeholder="Enter your Email" id="email">
            <input name="password" type="password" placeholder="Password" id="password">
            <input name="confirm_password" type="password" placeholder="Confirm Password" id="confirm_password">


            <input type="submit" id="btn" name="submit" value="SignUp">
            <p id="ask">Already registered? Click here to <a href='login.php'>Login</a></p>
        </form>


    </div>
    </div>
    <div class="bottom">
        <p>Made with &#10084; by Raghav</p>
    </div>
</body>

</html>