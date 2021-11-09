<?php
    session_start();
    if($_SESSION['status_login'] != true) {
        echo '<script>window.location="login.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan | UKK RPL</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
    <!--loader-->
    <div class="bg-loader">
        <div class="loader"></div>
    </div>
    <!--header-->
    <header>
        <div class="container">
        <h1><a href="home.php"><img src="image/logo.png" width="33px"></a></h1>
        <h1><a href="home.php">PERPUSTAKAAN</a></h1>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php">Profil Admin</a></li>
            <li><a href="kategori.php">Kategori</a></li>
            <li><a href="databuku.php">Data Buku</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
        </div>
    </header>

    <!--banner-->
    <section class="banner">
        <h2>Welcome Admin <?php echo $_SESSION['a_global']->admin_name ?> ♡</h2>
    </section>

    <!--about-->
    <section class="about">
        <div class="container">
            <h3>ABOUT</h3>
            <p><b>Halo, selamat datang di website pengelolaan data buku. Setiap admin 
                yang telah login dapat melakukan penambahan, pengeditan, penghapusan, 
                dan juga memeriksa setiap data buku yang ada di perpustakaan. 
                Jangan lupa untuk menyimpan perubahan yang dilakukan, ya! Makan makanan bergizi, 
                tidur yang cukup, dan selalu setia berolahraga, Min!
                Sehat selalu Mimin!</b></p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2020 - Shefira. All Rights Reserved</small>
        </div>
    </footer>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".bg-loader").hide();
        })
    </script>
</body>
</html>