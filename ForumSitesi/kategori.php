<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <?php 
    session_start();
    include 'ayar.php';
    include 'ukas.php';
    include 'func.php';

    $q = @$_GET["q"];

    $data = $db -> prepare("SELECT * FROM kategoriler WHERE
     k_kategori_link=?
     ");
    $data -> execute([
        $q
    ]);
    $_data = $data -> fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="container my-4">
        <?php include 'header.php'; ?>

        <h2 class="text-center"><?=$_data["k_kategori"]?></h2>

        <a href="konuac.php?kategori=<?=$_data["k_kategori_link"]?>"><button class="btn btn-success">Konu Aç</button></a>

        <ul class="list-group list-group-flush">
            <?php
            $dataList = $db -> prepare("SELECT * FROM konular WHERE konu_kategori_link=? ORDER BY konu_id DESC");
            $dataList -> execute([
                $q
            ]);
            $dataList = $dataList -> fetchALL(PDO::FETCH_ASSOC);
            
            foreach($dataList as $row){
                echo ' <li class="list-group-item"><a href="konu.php?link='.$row["konu_link"].'">'.$row["konu_ad"].'</a></li>';
            }
            ?>
            
        </ul>
    </div>

    <!-- Bootstrap JS ve bağımlılıkları -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
