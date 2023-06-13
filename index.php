<?php
// koneksi db dengan bahasa php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "Library";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { // cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$ISBN           = "";
$Judul          = "";
$Pengarang      = "";
$Penerbit       = "";
$Tahun_terbit   = "";
$Jumlah_hal     = "";
$sukses         = "";
$error          = "";

// operator
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// fungsi operator delete
if($op == 'delete') {
    $ISBN           = $_GET['ISBN'];
    $sql1           = "delete from buku where ISBN = '$ISBN'";
    $q1             = mysqli_query($koneksi,$sql1);
    if($q1) {
        $sukses = "Berhasil hapus data";
    }else{
        $error = "gagal melakukan delete data";
    }
}

// fungsi operator edit 
if($op == 'edit'){
    $ISBN           = $_GET['$ISBN'];
    $sql1           = "select * from buku where ISBN = '$ISBN'";
    $q1             = mysqli_query($koneksi,$sql1);
    $r2             = mysqli_fetch_array($q1);
    $Judul          = $r1['Judul'];
    $Pengarang      = $r1['Pengarang'];
    $Penerbit       = $r1['Penerbit'];
    $Tahun_terbit   = $r1['Tahun_terbit'];
    $Jumlah_hal     = $r1['Jumlah_hal'];

    if ($ISBN == '') {
        $error = "Data tidak ditemukan";
    }
}


if(isset($_POST['simpan'])){ // create data
$ISBN           = $_POST['isbn'];
$Judul          = $_POST['judul'];
$Pengarang      = $_POST['pengarang'];
$Penerbit       = $_POST['penerbit'];
$Tahun_terbit   = $_POST['tahun_terbit'];
$Jumlah_hal     = $_POST['jumlah-hal'];
if($ISBN && $Judul && $Pengarang && $Penerbit && $Tahun_terbit && $Jumlah_hal) {
    if($op == 'edit') { // buat update
    $sql1 = "update buku set ISBN = '$ISBN, Judul = '$Judul', Pengarang = '$Pengarang', Penerbit = '$Penerbit', Tahunn_terbit = '$Tahun_terbit', jumlah_hal = '$Jumlah_hal'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data berhasil diupdate";
    } else{
        $error = "Data gagal di update";   
    }
    } else{ //untuk insert
        $sql1 = "insert into buku (ISBN,Judul,Pengarang,Penerbit,Tahun_terbit,Jumlah_hal) values('$ISBN', '$Judul')";
        $q1 = mysqli_query($koneksi,$sql1);

        if($q1) {
            $sukses     = "Berhasil memasukkan data baru";
        }else{
            $error      = "Gagal memasukkan data baru";
        }
    }
}else{
    $error      = "Masukkan semua data";
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto { width: 800px; }
        .card {margin-top: 20px;}
    </style>
</head>
<body>
    <div class="mx-auto">
        <!-- Untuk memasukkan data -->
        <div class="card">
            <div class="card-header">Data Perpustakaan</div>
                <div class="card-body">
                    <?php
                    if($error){
                        ?> <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if($sukses){
                        ?> <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>    
                        </div>
                        <?php
                    }
                    ?>

                    <form action="" method="POST">

                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo "$ISBN" ?>">
                        </div>
                    </div>

                    
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo "$Judul" ?>">
                        </div>
                    </div>

                    
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">Pengarang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo "Pengarang" ?>">
                        </div>
                    </div>

                    
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">Penerbit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo "$Penerbit" ?>">
                        </div>
                    </div>

                    
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">Tahun terbit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tahunterbit" name="tahunterbit" value="<?php echo "$Tahun terbit" ?>">
                        </div>
                    </div>

                    
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">Jumlah hal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlahhal" name="jumlahhal" value="<?php echo "$Jumlah hal" ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary"/>
                    </div>

                    </form>
                </div>
        </div>
    </div>
</body>
</html>





