<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FRoM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhani's Mind Shop | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php";?>


<!-- highlight kategori  -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1> Dhani's Mind Shop</h1>
            <h3>Mau Cari Apa?</h3>
           <div class="col-8 offset-2">
                <form method="get" action="produk.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Nama barang"
                        aria-label="recipient's username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class=" btn warna2 text-white">Cari</button>
                    </div>
                </form>
           </div>
        </div>
    </div>

    <!-- highlight kategori  -->

    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3> kategori terlaris</h3>

            <div class="row mt-5">
                
                <div class="col-4">
                    <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=T-shirt">T-shirt</a></h4>
                    </div>   
                </div>
                <div class="col-4">
                    <div class="highlighted-kategori kategori-Sneakers d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Sneakers">Sneakers</a></h4>
                    </div>
                </div>
                <div class="col-4">
                    <div class="highlighted-kategori kategori-Album d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Album">Album</a></h4>
                    </div>
                </div>
               
            </div>
        </div>

    </div>


    <!-- tentang kami  -->
    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs=5 mt-3">
                Capek banget
        </div>
    </div>

 <!-- produk -->
        <div class="container-fluid py-5">
            <div class="container text-center">
                <h3>Produk</h3>

                <div class="row mt-5">
                    <?php while( $data = mysqli_fetch_array($queryProduk)){?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100";>
                            <div class="image-box">
                            <img src="image/<?php echo $data['foto'];?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card body">
                                <h4 class="card-title"><?php echo $data['nama'];?></h4>
                                <p class="card-text text-truncate"><?php echo $data['detail'];?></p>
                                <p class="card-text text-harga">Rp <?php echo $data['harga'];?></p>
                                <a href="produk-detail.php?nama= <?php echo $data['nama'];?>" class="btn warna2">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <a class="btn btn-outline-warning mt-3" href="produk.php">See More</a>
            </div>   
        </div>

    <!-- footer -->
<?php require "footer.php";?>


    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>    
</body>
</html>