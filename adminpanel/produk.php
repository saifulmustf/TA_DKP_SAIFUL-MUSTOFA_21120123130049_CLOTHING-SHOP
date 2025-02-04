<?php
    require "session.php";
    require "../koneksi.php";

    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($query);

    $queryKategori = mysqli_query($con, " SELECT * FROM kategori");

    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ( $i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;

    }
    
 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
       .no-decoration{
        text-decoration: none;
       }

       form div{
        margin-bottom: 10px;
       }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                <li>
            </ol>
        </nav>
        
        

        
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih satu</option>
                       <?php
                            while($data=mysqli_fetch_array($queryKategori)){
                            ?>
                            <option value="<?php echo $data['id']?>"><?php echo $data['nama']; ?></option>
                            <?php
                            }
                       ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="ketersediaan_stock">Ketersediaan Stock</label>
                    <select name="ketersediaan_stock" id="ketersediaan_stock" class="form-control">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
                if(isset($_POST['simpan'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $ketersediaan_stock = htmlspecialchars($_POST['ketersediaan_stock']);

                   

                    $target_dir ="../image/";
                    $nama_file = basename($_FILES["foto"]['name']);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $random_name = generateRandomString(20);
                    $new_name = $random_name . "." . $imageFileType;
                    


                    
                    

                    if($nama==''|| $kategori==''|| $harga==''){
                ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Nama, kategori, dan harga wajib diisi
                    </div>
                <?php
                    }
                    else{
                        if($nama_file!=''){
                            if($image_size > 1000000){
                ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    File lebih dari 1.0 Mb
                                </div>
                <?php
                            }
                            else{
                                if($imageFileType != 'jpg' && $imageFileType !='png' ){
                ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        File wajib jpg atau png
                                    </div>
                <?php                    
                                }
                                else{
                                    move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_name);
                                }
                            }

                     
                        }

                        $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stock) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stock')");


                        if($queryTambah){

                ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Kategori berhasil disimpan
                            </div>
                            <meta http-equiv="refresh" content="1; url=produk.php" />
                <?php
                        }
                        else{
                            echo mysqli_error($con);
                        }
                    }
                }
            ?>
        <div>
           

        <div class="mt-3 mb-5">
            <h2>List Produk</h2>
            <div class="table-responsive">
                <table class="table mt-2">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersedian Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($jumlahProduk==0){
                        ?>
                            <tr>
                                <td colspan=6 class="text-center">Data produk tidak tersedia</td>
                            </tr>
                        <?php
                            }
                            else{
                                $jumlah = 1;
                                while($data=mysqli_fetch_array($query)){
                        ?>
                                <tr>
                                    <td><?Php echo $jumlah; ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['nama_kategori'] ?></td>
                                    <td><?php echo $data['harga'] ?></td>
                                    <td><?php echo $data['ketersediaan_stock'] ?></td>
                                    <td>
                                        <a href="produk-detail.php?q=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                                    </td>
                                </tr>    
                        <?php
                                $jumlah++;
                                }
                            }
                        ?>
                    </tbody>
                <table>
            </div>
        <div>
    <div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>  
    <script src="../fontawesome/js/all.min.js"></script> 
</body>
<html>