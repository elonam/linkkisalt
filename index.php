<html>

<head>
<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  -webkit-animation-name: fadeIn; /* Fade in the background */
  -webkit-animation-duration: 0.4s;
  animation-name: fadeIn;
  animation-duration: 0.4s
}

/* Modal Content */
.modal-content {
  position: fixed;
  bottom: 0;
  background-color: #fefefe;
  width: 100%;
  -webkit-animation-name: slideIn;
  -webkit-animation-duration: 0.4s;
  animation-name: slideIn;
  animation-duration: 0.4s
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

/* Add Animation */
@-webkit-keyframes slideIn {
  from {bottom: -300px; opacity: 0} 
  to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
  from {bottom: -300px; opacity: 0}
  to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
  from {opacity: 0} 
  to {opacity: 1}
}

@keyframes fadeIn {
  from {opacity: 0} 
  to {opacity: 1}
}
</style>
</head>

<body>







<center>
  <?php
  include_once("db.php");
$veri = $db->query("SELECT * FROM linkler" , PDO::FETCH_ASSOC);
$sayi = $veri->rowCount();

$hitveri=$db->prepare("SELECT SUM(hit) AS hit FROM linkler");
$hitveri->execute();
$hitveriy= $hitveri->fetch(PDO::FETCH_ASSOC);
$topla=$hitveriy['hit'];
?>



<?php

$token = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,5);
$verci = $db->prepare("SELECT * FROM linkler WHERE token=?");
$verci ->execute([$token]);
if($token = $verci){
  $token = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,5);
 }
 
?>
<br><br><br><br><br><br><br>
<form method="POST" action="">

<span class="fa-stack fa-4x">
  <i class="fa fa-circle fa-stack-2x icon-background" style="color: #d6d6d6;"></i>
  <i class="fa fa-link fa-stack-1x" style="color: black;"></i>
 
</span><br> <?php
  if ($sayi < 1){
    echo '<font color="white">Şuana kadar hiç link kısaltılmamış :(</font>';
  }else{
    echo '<font color="white">Toplam kısaltılmış link sayısı: '.$sayi.'!</font>';
  }
  ?><br><?php 
  if($topla < 1){ 
    echo '<font color="white">Hiçbir link hit almamış</font>';
    }else{
      echo '<font color="white">Toplam hit sayısı: '.$topla.'!</font>';
       }?>
       <br><input type="text" name="link" id="link" class="form-control" style="width:900px; height:40px; "placeholder="https://"></input><br/>


</form>
<font color="red">

<?php


 if($_POST){
   
  $link = $_POST["link"];
  $kisalink = "$sitelink/l.php?t=$token";

  echo '

  <!-- Trigger/Open The Modal -->
  <button id="myBtn" type="button" class="btn btn-outline-success">Link bilgilerine bak</button>
  
  <!-- The Modal -->
  <div id="myModal" class="modal">
  
    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>Link kısaltma sitesi</h2>
      </div>
      <div class="modal-body">
        <p>Uzun Link: <a href="'.$link.'">'.$link.'</a></p>
        <p>Kısa link: <a href="'.$kisalink.'">'.$kisalink.'</a></p>
      </div>
      <div class="modal-footer">
        <h3>Hizmetimizi kullandığınız için teşekkürler!</h3>
      </div>
    </div>
  
  </div>';
  $ek = $db->prepare("insert into linkler set 
			             
  link=?,
  token=?,
  kisalink=?


");				

 $durum = $ek->execute(array($link,$token,$kisalink));

  if (!$link){
    echo '<center>Lütfen bir link giriniz</center>';
  }
 echo'<script>
 if(window.history.replaceState){
     window.history.replaceState(null, null, window.location.href)
 }
</script>';
 }
  ?>
</font>
</center>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>

</html>