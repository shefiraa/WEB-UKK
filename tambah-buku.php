<?php
    session_start();
    include 'db.php';
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
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
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

    <!-- Content -->
    <div class="section">
        <div class="container">
            <h3>Tambah Buku</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" required>
                            <option value="">--Pilih--</option>
                            <?php
                                $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                                while($r = mysqli_fetch_array($kategori)) {
                            ?>
                            <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                                <?php } ?>
                        </select>

                        <input type="text" name="judul" class="input-control" placeholder="Judul Buku" required>
                        <input type="text" name="pengarang" class="input-control" placeholder="Pengarang Buku" required>
                        <input type="text" name="penerbit" class="input-control" placeholder="Penerbit Buku" required>
                        <input type="file" name="gambar" class="input-control" required>
                        <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea><br>
                        <select class="input-control" name="status">
                            <option value="">--Pilih--</option>
                            <option value="1">Buku Tersedia</option>
                            <option value="0">Buku Tidak Tersedia</option>
                        </select>
                    <input type="submit" name="submit" value="Tambah" class="klik">
                </form>
                <?php
                    if(isset($_POST['submit'])){

                       // print_r($_FILES['gambar']);
                       // menampung inputan dari form
                       $kategori    = $_POST['kategori'];
                       $judul       = $_POST['judul'];
                       $pengarang   = $_POST['pengarang'];
                       $penerbit    = $_POST['penerbit'];
                       $deskripsi   = $_POST['deskripsi'];
                       $status      = $_POST['status'];

                       // menampung data file yang diupload
                       $filename = $_FILES['gambar']['name'];
                       $tmp_name = $_FILES['gambar']['tmp_name'];

                       $type1 = explode('.', $filename);
                       $type2 = $type1[1];

                       $newname = 'buku'.time().'.'.$type2;

                       // menampung data format file yang diizinkan 
                       $tipe_izin = array('jpg', 'jpeg', 'png', 'gif');

                       // validasi format file
                       if(!in_array($type2, $tipe_izin)) {
                            // jika format file tidak ada di dalam tipe diizinkan
                            echo '<scrip>alert("Format Tidak Sesuai")</script>';
                        
                       }else {
                            // jika format file sesuai dengan yang ada di dalam array tipe diizinkan
                            // proses upload file sekaligus insert ke database
                            move_uploaded_file($tmp_name, './book/'.$newname);

                            $insert = mysqli_query($conn, "INSERT INTO tb_book VALUES (
                                        null,
                                        '".$kategori."',
                                        '".$judul."',
                                        '".$pengarang."',
                                        '".$penerbit."',
                                        '".$deskripsi."',
                                        '".$newname."',
                                        '".$status."',
                                        null,
                                        null  
                                            ) ");

                        if($insert) {
                            echo '<script>alert("Data Berhasil Disimpan")</script>';
                            echo '<script>window.location="databuku.php"</script>';
                        }else {
                            echo 'Gagal'.mysqli_error($conn);
                        }
                    }

                    
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2020 - Shefira. All Rights Reserved</small>
        </div>
    </footer>
    
    <script>
        CKEDITOR.replace( 'deskripsi' );
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".bg-loader").hide();
        })
    </script>
</body>
</html>