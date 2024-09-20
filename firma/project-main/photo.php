<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    
</head>
<body>
    <div class="allphoto">

<?php    
    require_once "conn.php";
    
    if(mysqli_connect_error()) {
        die("conn" . mysqli_connect_error());
    }

?>

<?php
$id = $_GET['id'];

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
        
        echo "
            <div class='galeria'>
                <div class='carousel-notscalable'>
                    <div class='carousel-inner' id='carouselInner'>";

        // Loop through each image
        for ($iloscid = 1; $iloscid <= $ilosczdjeczag; $iloscid++) {
            // Determine the active image
            $akt = $row['zdj' . $iloscid];

            // Display the carousel items with active class for the first image
            if ($iloscid == 1) {
                echo "<div class='carousel-item active'>
                        <img src='$akt' style=''>
                      </div>";
            } else {
                echo "<div class='carousel-item'>
                        <img src='$akt' style=''>
                      </div>";
            }
        }

        echo "      </div>
                    <button class='carousel-control-prev' onclick='prevSlide()'>‹</button>
                    <button class='carousel-control-next' onclick='nextSlide()'>›</button>
                </div>
            </div>";
        }
    }

$conn-> close();
?>


<script>

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
</div>
</body>
</html>