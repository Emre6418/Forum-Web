<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <?php 
    session_start();
    include 'ayar.php';
    include 'ukas.php';
    include 'func.php';


    if(@$_SESSION["uye_onay"] == 0){
        echo '<div class="alert alert-danger text-center"><h1>SADECE YÖNETİCİLER GÖREBİLİR</h1></div>';
        exit;
    }
   
    ?>

    <div class="container my-4">
        <?php include 'header.php'; ?>

        <h2 class="text-center">Admin Paneli</h2>
        <hr>

        <h3>Kategori Ekle</h3>

        <?php 
        if($_POST){
            $kategori = $_POST["kategori"];
            $kategoriLink = permalink($kategori);
            // Veri tabanına kategori ekleme işlemi
            $dataAdd = $db -> prepare("INSERT INTO kategoriler SET k_kategori=?, k_kategori_link=?");
            $dataAdd -> execute([$kategori, $kategoriLink]);

            if ( $dataAdd ) {
                echo '<div class="alert alert-success">Kategori başarıyla eklendi. :)</div>';
                header("REFRESH:1;URL=index.php");
            } else {
                echo '<div class="alert alert-danger">Hay aksi bir sorunla karşılaştık. Lütfen tekrar deneyin :/</div>';
                header("REFRESH:1;URL=admin.php");
            }
        }
        ?>

        <form action="" method="post" class="mb-4">
            <div class="form-group">
                <label for="kategori"><strong>Kategori</strong></label>
                <input type="text" name="kategori" class="form-control">
            </div>
            <div class="form-group">
                <label for="yorum"><strong>Konu Mesajı</strong></label>
                <textarea name="yorum" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kategori Oluştur</button>
        </form>

        <hr>

        
    </div>

    <!-- Bootstrap JS ve bağımlılıkları -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
