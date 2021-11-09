<?php

    include 'db.php';

    if(isset($_GET['idp'])) {
        $buku = mysqli_query($conn, "SELECT gambar_buku FROM tb_book WHERE book_id = '".$_GET['idp']."' ");
        $p = mysqli_fetch_object($buku);

        unlink('./book/'.$p->gambar_buku);

        $delete = mysqli_query($conn, "DELETE FROM tb_book WHERE book_id = '".$_GET['idp']."' ");
        echo '<script>window.location="databuku.php"</script>';
    }

?>