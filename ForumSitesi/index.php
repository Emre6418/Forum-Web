<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Sitesi</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <?php 
    session_start();
    include 'ayar.php';
    include 'ukas.php';
    include 'func.php';
    ?>

    <!-- Üst Navigasyon -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Forum Sitesi</a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <?php include 'header.php'; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Ana İçerik -->
    <div class="container my-4">
    <div class="text-center mb-4">
        <h1>Forum Dünyası</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><strong>Yeni Açılan Konular</strong></div>
                <div class="card-body text-center">
                    <ul class="row-list-group text-center">
                        <?php
                        $dataList = $db->prepare("SELECT * FROM konular ORDER BY konu_id DESC");
                        $dataList->execute();
                        $dataList = $dataList->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($dataList as $row) {
                            echo '<li><a href="konu.php?link=' . $row["konu_link"] . '">' . $row["konu_ad"] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><strong>Son Cevaplar</strong></div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <?php
                                    $dataList = $db->prepare("SELECT * FROM yorumlar ORDER BY y_id DESC  LIMIT 50");
                                    $dataList->execute();
                                    $dataList = $dataList->fetchAll(PDO::FETCH_ASSOC);

                                    $konu_idler = [];

                                    foreach ($dataList as $row) {
                                        array_push($konu_idler, $row["y_konu_id"]);
                                    }

                                    $konu_idler = array_unique($konu_idler);

                                    foreach ($konu_idler as $konuid) {

                                        $konu_cek = $db->prepare("SELECT * FROM konular WHERE
                                            konu_id=?
                                            ");
                                        $konu_cek->execute([
                                            $konuid
                                        ]);
                                        $_konu_cek = $konu_cek->fetch(PDO::FETCH_ASSOC);

                                        echo '<li class="list-group-item"><a href="konu.php?link=' . $_konu_cek["konu_link"] . '">' . $_konu_cek["konu_ad"] . '</a></li>';
                                        @$i++;
                                        if ($i == 10) {
                                            break;
                                        }
                                    }

                                    ?>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <ul class="list-group">
                                </ul>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 offset-md-0">
            <div class="card">
                <div class="card-header"><h2>Kategoriler</h2></div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php
                        $dataList = $db->prepare("SELECT * FROM kategoriler LIMIT 10");
                        $dataList->execute();
                        $dataList = $dataList->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($dataList as $row) {
                            echo '<li class="list-group-item"><a href="kategori.php?q=' . $row["k_kategori_link"] . '">' . $row["k_kategori"] . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

<nav class="navbar navbar-light bg-light fixed-bottom">
    <div class="container">
        <span>Emre Ermin</span>
        <span class="navbar-text ml-auto">
            Tüm Hakları Saklıdır.
        </span>
    </div>
</nav>
</html>

