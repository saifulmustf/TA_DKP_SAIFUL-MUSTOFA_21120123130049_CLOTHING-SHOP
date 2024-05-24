<?php
    require "koneksi.php";
    $queryKategori = mysqli_query($con, "SELECT * FROM kategori" );

    //  get produk by nama produk/keyword
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }

    //  get produk by kategori
    else if(isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($con,"SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id ='$kategoriId[id]'");
    }

    //  get produk default
    else{
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhani's Mind Shop | Produk</title>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container text-center">
            <h1 class="text-white">Produk</h1>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-2 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while($kategori = mysqli_fetch_array($queryKategori)){?>
                    <a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['nama'];?>">
                        <li class="list-group-item"><?php echo $kategori['nama'];?></li>
                    </a>
                    <?php }?>
                </ul>
            </div>
            <div class="col-lg-10">
                <h3 class="text-center">Produk</h3>
                <div class="row">
                    <?php
                        if($countData<1){
                    ?>
                            <h4 class="text-center">produk yang anda cari tidak tersedia</h4>        
                    <?php
                        }
                    ?>
                    <?php while($produk = mysqli_fetch_array($queryProduk)){?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100";>
                            <div class="image-box">
                                <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card body">
                                <h4 class="card-title"><?php echo $produk['nama']; ?></h4>
                                <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                                <p class="card-text text-harga">Rp <?php echo $produk['harga']; ?></p>
                                <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn warna2">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script> 
</body>
</html>