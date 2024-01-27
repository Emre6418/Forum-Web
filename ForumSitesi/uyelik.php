<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>


<?php
    session_start();
    include 'ayar.php';
    include 'ukas.php';

    $p = @$_GET["p"];

    switch ($p) {
        case 'cikis':
            if (@$_SESSION["uye_id"]) {
                ukas_cikis("index.php");
            }else{
                header("LOCATION:index.php");
            }
            break;

        case 'kayit':
            if (@$_SESSION["uye_id"]) {
                // ...
            } else {
                ukas_kayit("<p class='text-warning'>Lütfen boş bırakmayınız!</p>", "<p class='text-danger'>Böyle bir eposta mevcut! Lütfen başka bir tane deneyiniz!</p>", "<p class='text-warning'>Böyle bir kullanıcı adı mevcut! Lütfen başka bir tane deneyiniz!</p>", "<p class='text-success'>Başarıyla kaydoldun! :)</p>", "index.php", "<p class='text-danger'>Kullanıcı adı veya şifre hatalı!</p>", "<p class='text-danger'>Kayıt başarısız!</p>", "<p>Şifreniz bir birine eşleşmiyor!</p>", "<p>Lütfen gerçek bir eposta giriniz!</p>");
                echo '
                <div class="container mt-4">
                    <h1 class="text-center"><strong>Şimdi Kayıt Ol!</strong></h1>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="adsoyad"><strong>Ad Soyad:</strong></label>
                                    <input type="text" class="form-control" name="adsoyad" id="adsoyad">
                                </div>
                                <div class="form-group">
                                    <label for="kadi"><strong>Kullanıcı adı:</strong></label>
                                    <input type="text" class="form-control" name="kadi" id="kadi">
                                </div>
                                <div class="form-group">
                                    <label for="sifre"><strong>Şifre:</strong></label>
                                    <input type="password" class="form-control" name="sifre" id="sifre">
                                </div>
                                <div class="form-group">
                                    <label for="sifret"><strong>Şifre (Tekrar):</strong></label>
                                    <input type="password" class="form-control" name="sifret" id="sifret">
                                </div>
                                <div class="form-group">
                                    <label for="eposta"><strong>E-Posta:</strong></label>
                                    <input type="text" class="form-control" name="eposta" id="eposta">
                                </div>
                                <input type="hidden" name="_token" value="'.@$_SESSION["_token"].'">
                                <button type="submit" class="btn btn-block btn-dark" name="kayit">Kayıt Ol</button>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <a href="uyelik.php?p=giris" class="btn btn-block btn-secondary">Şimdi giriş yap!</a>
                    <a href="index.php" class="text-dark"><small>&larr; Anasayfaya dön</small></a>
                </div>';
            }
            break;

        default:
            if (@$_SESSION["uye_id"]) {
                // ...
            } else {
                ukas_giris("index.php", "<p class='text-warning'>Lütfen boş bırakmayınız!</p>", "<p class='text-danger'>Kullanıcı adı veya şifre hatalı!</p>");
                echo '
                <div class="container mt-4">
                    <h1 class="text-center"><strong>Giriş Yap</strong></h1>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="kadi"><strong>Kullanıcı Adı:</strong></label>
                                    <input type="text" class="form-control" name="kadi" id="kadi">
                                </div>
                                <div class="form-group">
                                    <label for="sifre"><strong>Şifre:</strong></label>
                                    <input type="password" class="form-control" name="sifre" id="sifre">
                                </div>
                                <input type="hidden" name="_token" value="'.@$_SESSION["_token"].'">
                                <button type="submit" class="btn btn-block btn-dark" name="giris">Giriş Yap</button>
                            </form>
                            <a href="uyelik.php?p=sifremiunuttum" class="btn btn-block btn-secondary mt-3">Şifremi unuttum</a>
                            <a href="uyelik.php?p=kayit" class="btn btn-block btn-secondary mt-3">Şimdi kayıt ol!</a>
                        </div>
                    </div>
                    <hr>
                    <a href="index.php" class="text-dark"><small>&larr; Anasayfaya dön</small></a>
                </div>';
            }
            break;
    }
?>
