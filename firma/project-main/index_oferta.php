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
    <div class="formtop"><form action="index_search.php" method="POST" style="margin:0px;display:inline-block"><input type="text" name="searchbar" class="inputtop" placeholder="wyszukaj...">
    <input type="submit" value="search" style="width:60px; font-size:16px; background-color: rgb(0, 69, 90); height:37px"></form></div>
    <div class="username" style="font-size: 20px; margin-top: 30px; padding-left:100px;">Użytkownik: <?php echo($username)?></div>
    </div>

    <div class="all">

        <div class="oferta_box">
        

        <?php
        $id = $_GET['id'];

?>




<?php

$sql = "SELECT `id`,`zdj1`,`zdj2`,`zdj3`,`zdj4`,`zdj5`,
(CASE WHEN `zdj1` IS NULL OR `zdj1` = '0' OR `zdj1` = '' THEN 0 ELSE 1 END +
CASE WHEN `zdj2` IS NULL OR `zdj2` = '0' OR `zdj1` = '' THEN 0 ELSE 1 END +
CASE WHEN `zdj3` IS NULL OR `zdj3` = '0' OR `zdj1` = '' THEN 0 ELSE 1 END +
CASE WHEN `zdj4` IS NULL OR `zdj4` = '0' OR `zdj1` = '' THEN 0 ELSE 1 END +
CASE WHEN `zdj5` IS NULL OR `zdj5` = '0' OR `zdj1` = '' THEN 0 ELSE 1 END
) AS `ilosczdj`, `nazwa`, `opis`, `telefon`, `stan`, `cena`, `ilosc` from `oferty` where id = $id";
$result = $conn-> query($sql);

if($result-> num_rows > 0){
    while ($row = $result-> fetch_assoc()) {
        $id = $row['id'];
        echo "<div id='$id'></div>";
        $cena = $row["cena"];
        $ilosc = $row["ilosc"];
        $ilosczdjeczag = $row['ilosczdj'];
        
        echo "<div class='titlein'>" . $row["nazwa"] . "</div>
        <div class='stan_oferta'> Stan: " . $row["stan"] . "</div>
        <div class='double_oferta'>
            <div class='galeria'>
                <div class='carousel'>
                    <div class='carousel-inner' id='carouselInner'>";

        // Loop through each image
        for ($iloscid = 1; $iloscid <= $ilosczdjeczag; $iloscid++) {
            // Determine the active image
            $akt = $row['zdj' . $iloscid];

            // Display the carousel items with active class for the first image
            if ($iloscid == 1) {
                echo "<div class='carousel-item active'>
                        <a href='photo.php?id={$row['id']}'.'><img src='$akt' style='width:400px'></a>
                      </div>";
            } else {
                echo "<div class='carousel-item'>
                        <a href='photo.php?id={$row['id']}'.'><img src='$akt' style='width:400px'></a>
                      </div>";
            }
        }

        echo "      </div>
                    <button class='carousel-control-prev' onclick='prevSlide()'>‹</button>
                    <button class='carousel-control-next' onclick='nextSlide()'>›</button>
                </div>
            </div>";

        // Continue with the rest of the code
        echo "<div class='cena_oferta'>Cena: <b>" . $row["cena"] . "</b> zł<br>
            <phone>od: " . $row['telefon'] . "</phone></div>
            <div class='column'>
                <div class='ilosc_cena'>
                    <div class='ilosc'>ilość: " . $row['ilosc'] . "</div>
                    <div class='ilosc-suw'>
                        <button id='ilosc-mns' data-action='minus' type='button'>-</button>
                        <input id='ilosc-input' class='ilosc-inpt' type='number' name='ilosc-inpt' min='1' max='$ilosc' value='1'>
                        <button id='ilosc-add' data-action='add' type='button'>+</button>
                    </div>
                    <button type='button' class='btn' style='width:140px;height:47px;cursor:pointer;font-size:25px;'>" . $row["cena"] . "zł</button>
                </div>
            </div>
            <br><br>
            <div class='opis-oferta'>Opis produktu:<br><phone>" . $row['opis'] . "</phone></div>
            <br><br>
            <div class='opis-oferta'>Kontakt do sprzedawcy:<br><phone>" . $row['telefon'] . "</phone></div>";
    }
} else {
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