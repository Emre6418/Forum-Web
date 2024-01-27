

<?php 

    if(@$_SESSION["uye_id"]){
        echo '<a href="profil.php?kadi=' . @$_SESSION["uye_kadi"] . '" class="btn btn-primary">Profilime git</a> ';
        echo '<a href="uyelik.php?p=cikis" class="btn btn-danger">Çıkış yap</a>';

    }
    else{
        echo '<a href="uyelik.php?p=kayit" class="btn btn-success">Üye Ol</a>  <a href="uyelik.php" class="btn btn-primary">Giriş Yap</a>';

    }

?>