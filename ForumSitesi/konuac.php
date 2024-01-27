<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konu Paylaşma</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <?php 
    session_start();
    include 'ayar.php';
    include 'ukas.php';
    include 'func.php';

    if(!@$_SESSION["uye_id"]){

        echo '<center><h1>Üye olmayanlar konu paylaşamaz. </h1><a href="uyelik.php">Üyelik</a></center>';
        exit;
    }

    $kategori = @$_GET["kategori"];
    if(empty($kategori)) {
    // Hata mesajı göster veya varsayılan bir değer atama
    $kategori = 'default_value';
}


    ?>

    <div class="container my-4">
        <?php include 'header.php'; ?>

        <h2 class="text-center">Konu Paylaşma</h2>

        <?php 
            if($_POST){
                $ad = $_POST["ad"];
                $mesaj = $_POST["mesaj"];

                $link = permalink($ad) ."-". rand(000,999);

                $dataAdd = $db -> prepare("INSERT INTO konular SET
    konu_ad=?,
    konu_link=?,
    konu_mesaj=?,
    konu_uye_id=?,
    konu_kategori_link=?
");
$dataAdd -> execute([
    $ad,
    $link,
    $mesaj,
    @$_SESSION["uye_id"],
    $kategori
]);

if ( $dataAdd ) {
    echo '<p class="alert alert-success">Konunuz başarılıyla paylaşıldı. :)</p>';
    
    header("REFRESH:1;URL=konu.php?link=" . $link);
} else {
    echo '<p class="alert alert-danger">Hay aksi bir hata ile karşılandı. Lütfen tekrar deneyin :/</p>';
    
    header("REFRESH:1;URL=konuac.php");
}
            }
        ?>
    <strong><?=kategori_linkten_kategori_adi($kategori)?> Kategorisinde konu açmaktasınız</strong>
        <form action="" method="post" class="my-4">
            <div class="form-group">
                <label for="ad"><strong>Konu Adı:</strong></label>
                <input type="text" name="ad" class="form-control">
            </div>
            <div class="form-group">
                <label for="yorum"><strong>Konu Mesajı:</strong></label>
                <textarea name="mesaj" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Konuyu Aç</button>
        </form>
    </div>

    <!-- Bootstrap JS ve bağımlılıkları -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script
