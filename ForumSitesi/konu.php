<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konu Başlığı</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <?php 
    session_start();
    include 'ayar.php';
    include 'ukas.php';
    include 'func.php';

    $link = @$_GET["link"];

    $data = $db -> prepare("SELECT * FROM konular WHERE
    konu_link=?
    ");
    $data -> execute([
    $link
    ]);
    $_data = $data -> fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="container my-4">
        <?php include 'header.php'; ?>

        <h2 class="text-center"><?=$_data["konu_ad"]?></h2>
        <p class="text-center">
        

        </p>
        <p>
        <?=$_data["konu_mesaj"]?>
        </p>

        <small><?=$_data["konu_tarih"]?></small>

        <hr>

        <h3>Cevaplar</h3>

        <?php 
    $dataList = $db -> prepare("SELECT * FROM yorumlar WHERE y_konu_id=?");
    $dataList -> execute([
        $_data["konu_id"]
    ]);
    $dataList = $dataList -> fetchAll(PDO::FETCH_ASSOC);
    
    foreach($dataList as $row){
        echo '
        <a href="profil.php?kadi='.uye_ID_den_kadi($row["y_uye_id"]).'" id="yorum"'.$row["y_id"].
        '">
        <strong>
        '.uye_ID_den_isme($row["y_uye_id"]).'
        </strong>
        </a><br>
        <p>
            '.$row["y_yorum"].' 
        </p>
        <small><b>Tarih:</b>'.$row["y_tarih"].'</small>
        <hr>';
    }
?>




        <?php 
        if(@$_SESSION["uye_id"]){

            if($_POST){
                $yorum = $_POST["yorum"];

                $dataAdd = $db -> prepare("INSERT INTO yorumlar SET
    y_uye_id=?,
    y_konu_id=?,
    y_yorum=?
");
$dataAdd -> execute([
    $_SESSION["uye_id"],
    $_data["konu_id"],
    $yorum
]);

if ( $dataAdd ) {

    $yorumcek = $db -> prepare("SELECT * FROM yorumlar WHERE
  y_uye_id=?
  &&
  y_konu_id=?

    ORDER BY y_id DESC

");
$yorumcek -> execute([
    $_SESSION["uye_id"],
    $_data["konu_id"],
]);
$yorumcek = $yorumcek -> fetch(PDO::FETCH_ASSOC);

    echo '<p class="alert alert-success">Yorumunuz başarıyla eklendi :)</p>';
    
    header("REFRESH:1;URL=konu.php?link=" . $link . "#yorum" . $_yorumcek["y_id"]);
} else {
    echo '<p class="alert alert-danger">Hay aksi bir hata ile karşılaşıldı. Tekrar deneyiniz :/</p>';
    
    header("REFRESH:1;URL=konu.php?link=".$link. "#yorumyap");
}
            }

            echo '<h4 id="yorumyap">Cevap Yaz:</h4>
        <form action="" method="post">
            <div class="form-group">
                <textarea name="yorum" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gönder</button>
        </form>';
        }
        else{
            echo '';
        }
        ?>

        
    </div>

    <!-- Bootstrap JS ve bağımlılıkları -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
