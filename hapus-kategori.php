<?php

    include 'db.php';

    if(isset($_GET['idc'])) {
        $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '".$_GET['idc']."' ");
        echo '<script>window.location="kategori.php"</script>';

    }
?>