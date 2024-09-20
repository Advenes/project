<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    
</head>

<?php    
    require_once "conn.php"; 
    
    if(mysqli_connect_error()) {
        die("conn" . mysqli_connect_error());
    }

?>

<body>
    <a href="index.php"><div class="header"><ht><div class="textup">FIRMA</div></ht></a>
    <div class="formtop"><form action="index_search.php" method="POST" style="margin:0px;display:inline-block"><input type="text" name="searchbar" class="inputtop" placeholder="wyszukaj...">
    <input type="submit" value="search" style="width:60px; font-size:16px; background-color: rgb(0, 69, 90); height:37px"></form></div>
    <div class="username" style="font-size: 20px; margin-top: 30px; padding-left:100px;">Użytkownik: <?php echo($username)?></div>
    </div>

    <div class="all">

        <div class="sctitle">Wszystkie oferty naszego sklepu</div>
      
        <div class="oferty">  

        <?php

        $sql = "SELECT id, zdj1, nazwa, opis, telefon, stan, cena from oferty";
        $result = $conn-> query($sql);

        if($result-> num_rows > 0){
            while ($row = $result-> fetch_assoc()) {
                $zdj = $row["zdj1"];
                $cena = $row["cena"];
                $id = $row['id'];
                echo "<div class='oferta'><img src='$zdj' class='pic' width='125px' 
                height='125px'>" . "<div class='inside'>" . $row["nazwa"] . "<opis>" 
                . $row["opis"] . "</opis></div><div class='inside2'>
                <cena2 style='font-family: 'Nunito Sans', sans-serif;font-optical-sizing: 
                auto;'><b>$cena</b> zł</cena2><form><a href='index_oferta.php?id={$row['id']}'.'><button type='button' class='btn' style='width:90px;height:37px;cursor:pointer;font-size:14px;'>ZAMÓW</button></a></form></div></div> ";
            }
        }
        else{
            echo "no results";
        }

        $conn-> close();

        ?>

        </div>

    </div>

</body>
</html>