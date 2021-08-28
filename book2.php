
<?php
require_once 'connection.php';
session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php');

}
$user=$_SESSION['username'];
if(isset($_POST['submit'])){
 $content=$_POST['data'];
$sql="UPDATE `books` SET `Book2`='$content' where `username`='$user'";
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
    $data=$confirm['Book2'];
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>

    <div id="toolbar"></div>
    <form method="post" action="book2.php">

<div id="quill_editor"><?php echo $data;?></div>
<input type="hidden" id="quill_html" name="data"></input>
<input type="submit" name="submit" value="submit">
    </form>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
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