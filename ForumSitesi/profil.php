<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Profili</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <?php 
    session_start();
    include 'ayar.php';
    include 'ukas.php';
    include 'func.php';

    $kadi = @$_GET["kadi"];

    $data = $db -> prepare("SELECT * FROM uyeler WHERE
    uye_kadi=?
  ");
  $data -> execute([
    $kadi
  ]);
  $_data = $data -> fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="container my-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <?php include 'header.php'; ?>
            </div>
        </div>
    </div>
</nav>


        <h2 class="text-center"><?=$_data["uye_adsoyad"]?></h2>
        <a href="index.php"><button class="btn btn-warning">Ana Sayfaya Dön</button></a><br><br>
        <p><strong>E-posta:</strong> <?=$_data["uye_eposta"]?></p><br>
        <div class="row">
            <div class="col-md-6">
                <h3>Açtığı Konular</h3>
                <ul class="list-group">
                    <?php
                        $dataList = $db -> prepare("SELECT * FROM konular WHERE konu_uye_id=?");
                        $dataList -> execute([
                            $_data["uye_id"]
                    ]);
                        $dataList = $dataList -> fetchALL(PDO::FETCH_ASSOC);
                        
                        foreach($dataList as $row){
                            echo '<li class="list-group-item"><a href="konu.php?link='.$row["konu_link"].'">'.$row["konu_ad"].'</a></li>';
                        }
                    ?>
                </ul>
            </div>

            <div class="col-md-6">
                <h3>Yorumları</h3>
                <ul class="list-group">
                <?php
                        $dataList = $db -> prepare("SELECT * FROM yorumlar WHERE y_uye_id=? LIMIT 50");
                        $dataList -> execute([
                            $_data["uye_id"]
                    ]); 
                        $dataList = $dataList -> fetchALL(PDO::FETCH_ASSOC);
                        
                        $konu_idler = [];

                        foreach($dataList as $row){
                           array_push($konu_idler, $row["y_konu_id"]);
                        }

                        $konu_idler = array_unique($konu_idler);

                        foreach($konu_idler as $konuid){

                            $konu_cek = $db -> prepare("SELECT * FROM konular WHERE
                                    konu_id=?
                                ");
                                $konu_cek -> execute([
                                    $konuid
                                ]);
                                $_konu_cek = $konu_cek -> fetch(PDO::FETCH_ASSOC);

                                echo '<li class="list-group-item"><a href="konu.php?link='.$_konu_cek["konu_link"].'">'.$_konu_cek["konu_ad"].'</a></li>';
                                @$i++ ;          
                            if($i == 10){
                                break;
                            }
                        }

                    ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS ve bağımlılıkları -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
