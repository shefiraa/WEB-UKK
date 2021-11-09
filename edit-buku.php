<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true) {
        echo '<script>window.location="login.php"</script>';
    }

    $buku = mysqli_query($conn, "SELECT * FROM tb_book WHERE book_id = '".$_GET['id']."' ");
    if(mysqli_num_rows($buku) == 0){
        echo '<script>window.location="databuku.php"</script>';
    }

    $b = mysqli_fetch_object($buku);

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
            <h3>Edit Buku</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" required>
                            <option value="">--Pilih--</option>
                            <?php
                                $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                                while($r = mysqli_fetch_array($kategori)) {
                            ?>
                            <option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $b->category_id)? 'selected':''; ?>><?php echo $r['category_name'] ?></option>
                                <?php } ?>
                        </select>

                        <input type="text" name="judul" class="input-control" placeholder="Judul Buku" value="<?php echo $b->judul_buku ?>"required>
                        <input type="text" name="pengarang" class="input-control" placeholder="Pengarang Buku" value="<?php echo $b->pengarang_buku ?>"required>
                        <input type="text" name="penerbit" class="input-control" placeholder="Penerbit Buku" value="<?php echo $b->penerbit_buku ?>"required>
                        
                        <img src="book/<?php echo $b->gambar_buku ?>" width=100px>
                        <input type="hidden" name="foto" value="<?php echo $b->gambar_buku ?>">
                        <input type="file" name="gambar" class="input-control" >
                        <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"> <?php echo $b->deskripsi_buku ?> </textarea><br>
                        <select class="input-control" name="status">
                            <option value="">--Pilih--</option>
                            <option value="1" <?php echo ($b->status_buku == 1)? 'selected':''; ?>>Buku Tersedia</option>
                            <option value="0" <?php echo ($b->status_buku == 0)? 'selected':''; ?>>Buku Tidak Tersedia</option>
                        </select>
                    <input type="submit" name="submit" value="Edit" class="klik">
                </form>
                <?php
                    if(isset($_POST['submit'])){

                        // data inputan dari form
                        $kategori    = $_POST['kategori'];
                        $judul       = $_POST['judul'];
                        $pengarang   = $_POST['pengarang'];
                        $penerbit    = $_POST['penerbit'];
                        $deskripsi   = $_POST['deskripsi'];
                        $foto        = $_POST['foto'];
                        $status      = $_POST['status'];

                        // data gambar yang baru
                        $filename = $_FILES['gambar']['name'];
                        $tmp_name = $_FILES['gambar']['tmp_name'];

                        // jika ganti gambar
                        if($filename != '') {

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
                                unlink('./book/'.$foto);
                                move_uploaded_file($tmp_name, './buku/'.$newname);
                                $namagambar = $newname;
                            }

                        }else {
                            // jika tidak ganti gambar
                            $namagambar = $foto;

                        }

                        // query update data buku
                        $update = mysqli_query($conn, "UPDATE tb_book SET
                                                category_id = '".$kategori."',
                                                judul_buku = '".$judul."',
                                                pengarang_buku = '".$pengarang."',
                                                penerbit_buku = '".$penerbit."',
                                                deskripsi_buku = '".$deskripsi."',
                                                gambar_buku = '".$namagambar."',
                                                status_buku = '".$status."'
                                                WHERE book_id = '".$b->book_id."' ");
                        
                        if($update) {
                            echo '<script>alert("Data Berhasil Diubah")</script>';
                            echo '<script>window.location="databuku.php"</script>';
                        }else {
                            echo 'Gagal'.mysqli_error($conn);
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