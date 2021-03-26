<html>
  <head>
  <meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
  </head>
  <body>
      <center>
  <?php
include_once("db.php");
$lnk = $_GET['t'];
if (!$lnk){
    
    header("Location: $sitelink/index.php");

}


$linko = $db->prepare("SELECT * FROM linkler WHERE token=?");
$linko ->execute([$lnk]);
$_linko = $linko->fetch(PDO::FETCH_ASSOC);
$lnko = $_linko["link"];
$ido = $_linko["id"];

    if(!@$_COOKIE["hit".$ido]){
    $hit = $db->prepare("UPDATE linkler SET hit = hit +1 WHERE id=?");
    $hit->execute(array($_linko["id"]));
    setcookie("hit".$_linko["id"],"_",time ()+(60*60*24*30));
}

?>
    <img src="images/reklam2.jpg" title="Reklam" border="10" width="600" height="250"/>
<br>
    <div id="dv"><font size="5" color="cyan">Linke gitmenize kalan süre: <span id="seconds">8</span></font></div>
    <br>
   <font size="4" color="red">Bu linke toplam <?php echo $_linko["hit"];?> kez tıklandı!</font>
   <br>
    <img src="images/reklam.jpg" title="Reklam" border="10" width="300" height="250"/>
<br><br>
    <script>
         
     var seconds = 8;
      setInterval(
        function (){
           
          if (seconds <= 0) {
            var x = document.getElementById("dv");
 
                x.style.display = "none";


                document.getElementById("btn").disabled = false;
          
          
          }
          else {
            document.getElementById('seconds').innerHTML = --seconds;
          }
        },
        1000
      );
    </script>
 
    <button disabled="disabled" id="btn" class="btn btn-primary" onclick="window.location = '<?php echo $_linko['link']; ?>';">Linke Git!</button><br/>
    </center>
  </body>
</html>


