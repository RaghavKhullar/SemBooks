
<?php
session_start();

require_once 'connection.php';
if(!isset($_SESSION['username'])){
    header('location:login.php');

}
$user=$_SESSION['username'];
if(isset($_POST['submit'])){
 $content=$_POST['data'];
$sql="UPDATE `books` SET `Book1`='$content' where `username`='$user'";
$fire = mysqli_query($con, $sql);
if($fire==true){
    echo '<script>
         alert("Your changes have been submitted");
         window.location.assign("dashboard.php");
         </script>';}
}
$query = "SELECT * FROM `books` WHERE `username`='$user'";
    $fire = mysqli_query($con, $query);
    $confirm=mysqli_fetch_array($fire);
    $data=$confirm['Book1'];
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

    <div id="toolbar"></div>
    <form method="post" action="book1.php">

<div id="quill_editor"><?php echo $data;?></div>
<input type="hidden" id="quill_html" name="data"></input>
<input type="submit" name="submit" value="submit">
    </form>
    <script>
     var toolbarOptions=[['bold','underline','italic','strike'],
    ['blockquote'],[{'header':[1,2,3,4,5,6]}],
[{'list':'ordered'},{'list':'bullet'}],
[{'script':'sub'},{'script':'super'}],
[{'indent':'-1'},{'indent':'+1'}],
[{'direction':'rt1'}],
[{'size':['small',false,'large','huge']}], [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],

    ];
        var quill = new Quill('#quill_editor', {
         modules:{toolbar:toolbarOptions},
            theme: 'snow'
        });

        
  
   quill.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("quill_html").value = quill.root.innerHTML;
    });

      </script>
</body>
</html>

