<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php    
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername,$username,$password, "firma");
    
    if(mysqli_connect_error()) {
        die("conn" . mysqli_connect_error());
    }

?>

<body>

    <a href="index.php"><div class="header"><ht><div class="textup">FIRMA</div></ht></a>    
    <div class="formtop"><form style="margin:0px;display:inline-block"><input type="text" class="inputtop" placeholder="wyszukaj...">
    <button style="
    width:70px;height:37px;cursor:pointer;padding-bottom:0px;
    ">Wyszukaj</button></form></div>
    <div class="username" style="font-size: 20px; margin-top: 30px; padding-left:100px;">Użytkownik: <?php echo($username)?></div>
    </div>

    <div class="all">

        <div class="oferta_box">
        
        <div class="galeria">
        <div class='carousel'>
        <div class='carousel-inner' id='carouselInner'>
        <?php
        $id = $_GET['id'];

$ilosczdjec = "SELECT `id`,`zdj1`,`zdj2`,`zdj3`,`zdj4`,`zdj5`,
(CASE WHEN `zdj1` IS NULL OR `zdj1` = '0' THEN 0 ELSE 1 END +
CASE WHEN `zdj2` IS NULL OR `zdj2` = '0' THEN 0 ELSE 1 END +
CASE WHEN `zdj3` IS NULL OR `zdj3` = '0' THEN 0 ELSE 1 END +
CASE WHEN `zdj4` IS NULL OR `zdj4` = '0' THEN 0 ELSE 1 END +
CASE WHEN `zdj5` IS NULL OR `zdj5` = '0' THEN 0 ELSE 1 END
) AS `ilosczdj`
FROM `oferty`
WHERE `id` = $id
;";
$resultilosc = $conn-> query($ilosczdjec);
$iloscid = 1;
$iloscidplus = $iloscid + 1;
$iloscidminus = $iloscid - 1;
if($resultilosc-> num_rows > 0){
    while ($row = $resultilosc-> fetch_assoc()) {
        $ilosczdjeczag = $row['ilosczdj'];
        while($iloscid <= $ilosczdjeczag){
            $zdj1 = $row['zdj1'];
            $zdj2 = $row['zdj2'];
            $zdj3 = $row['zdj3'];
            $zdj4 = $row['zdj4'];
            $zdj5 = $row['zdj5'];
            if ($iloscid == 1) {
                $akt = $zdj1;
            } elseif ($iloscid == 2) {
                $akt = $zdj2;
            } elseif ($iloscid == 3) {
                $akt = $zdj3;
            } elseif ($iloscid == 4) {
                $akt = $zdj4;
            } elseif ($iloscid == 5) {
                $akt = $zdj5;
            }
            if($iloscid == 1){
                echo 
                "   
                    <div class='carousel-item active'>
                        <img src='$akt' style='width:500px'>
                    </div>
                ";
            }
            else{
                echo 
                "   
                    <div class='carousel-item'>
                        <img src='$akt' style='width:400px'>
                    </div>
                ";
            }

            $iloscid = $iloscid +1;
            $iloscidplus = $iloscid + 1;
            if ($iloscidminus - 1 == 0) {
                $iloscidminus = 1;
            } else {
                $iloscidminus = $iloscid - 1;
            }
        }
    }
}
?>

</div>
<button class='carousel-control-prev' onclick='prevSlide()'>‹</button>
<button class='carousel-control-next' onclick='nextSlide()'>›</button>
</div>

<?php

        $sql = "SELECT id, zdj1, zdj2, zdj3, zdj4, zdj5, nazwa, opis, telefon, stan, cena, ilosc from oferty where id = $id";
        $result = $conn-> query($sql);

        
        if($result-> num_rows > 0){
            while ($row = $result-> fetch_assoc()) {
                $id = $row['id'];
                echo "<div id='$id'></div>";
                $cena = $row["cena"];
                $zdj = $row["zdj1"];
                $ilosc = $row["ilosc"];
                echo "<div class='titlein'>" . $row["nazwa"] . "</div><div class='stan_oferta'> Stan: "
                . $row["stan"] . "</div>"
                . "<div class='double_oferta'>";

                


                echo "<img src='$zdj' class='pic' width='400px' height='400px'>"

                . "<div class='cena_oferta'>Cena: <b>" . $row["cena"] . "</b> zł<br>
                <phone>od: " . $row['telefon'] . "</phone></div>"
                . "<div class='column'><div class='ilosc_cena'><div class='ilosc'>ilość: " . $row['ilosc'] . "</div>"
                . "<div class='ilosc-suw'>"
	            . "<button id='ilosc-mns' data-action='minus' type='button'>-</button>"
                . "<input id='ilosc-input' class='ilosc-inpt' type='number' name='ilosc-inpt' min='1' max='$ilosc' value='1'>"
                . "<button id='ilosc-add' data-action='add' type='button'>+</button></div>"
                . "<button type='button' class='btn' style='width:140px;height:47px;cursor:pointer;font-size:25px;'>" . $row["cena"] . "zł</button>"
                . "</div></div></div>"
                . "<br><br><div class='opis-oferta'>Opis produktu:<br><phone>" . $row['opis'] . "</phone></div>"
                . "<br><br><div class='opis-oferta'>Kontakt do sprzedawcy:<br><phone>" . $row['telefon'] . "</phone></div>";
            }
        }
        else{
            echo "no results";
        }

        $conn-> close();

        ?>

        </div>

    </div>

    <script>

const inputElement = document.getElementById('ilosc-input');
            const min = parseInt(inputElement.getAttribute('min'));
            const max = parseInt(inputElement.getAttribute('max'));

function setInputValue(value){
        document.getElementById('ilosc-input').value = value;
        }

        // Add event listeners to the buttons
        document.getElementById('ilosc-add').addEventListener('click', function() {
            value = document.getElementById('ilosc-input').value;
            if(value < max){
                setInputValue(parseInt(value)+1);
                console.log('add');
            }
        });

        document.getElementById('ilosc-mns').addEventListener('click', function() {
            value = document.getElementById('ilosc-input').value;
            if(value > min){
                setInputValue(parseInt(value)-1);
                console.log('min');
            }
        });

        let currentIndex = 0;

function showSlide(index) {
    const carouselInner = document.getElementById('carouselInner');
    const totalSlides = carouselInner.children.length;

    if (index >= totalSlides) {
        currentIndex = 0;
    } else if (index < 0) {
        currentIndex = totalSlides - 1;
    } else {
        currentIndex = index;
    }

    const offset = -currentIndex * 100;
    carouselInner.style.transform = 'translateX(' + offset + '%)';
}

function nextSlide() {
    showSlide(currentIndex + 1);
}

function prevSlide() {
    showSlide(currentIndex - 1);
}
</script>




</body>
</html>