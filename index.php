<?php
// koneksi db dengan bahasa php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "libary";

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
    $ISBN           = $_GET['ISBN'];
    $sql1           = "select * from buku where ISBN = '$ISBN'";
    $q1             = mysqli_query($koneksi,$sql1);
    $r1             = mysqli_fetch_array($q1);
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
$Judul          = $_POST['judul'];
$Pengarang      = $_POST['pengarang'];
$Penerbit       = $_POST['penerbit'];
$Tahun_terbit   = $_POST['tahun_terbit'];
$Jumlah_hal     = $_POST['jumlah_hal'];
if($Judul && $Pengarang && $Penerbit && $Tahun_terbit && $Jumlah_hal) {
    if($op == 'edit') { // buat update
    $sql1 = "update buku set Judul = '$Judul', Pengarang = '$Pengarang', Penerbit = '$Penerbit', Tahun_terbit = '$Tahun_terbit', jumlah_hal = '$Jumlah_hal' where ISBN = $ISBN";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data berhasil diupdate";
    } else{
        $error = "Data gagal di update";   
    }
    } else{ //untuk insert
        $sql1 = "insert into buku (Judul,Pengarang,Penerbit,Tahun_terbit,Jumlah_hal) values('$Judul', '$Pengarang', '$Penerbit', '$Tahun_terbit', '$Jumlah_hal')";
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <style>
      .mx-auto {
        width: 800px;
      }
      .card {
        margin-top: 20px;
      }
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
                        ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
                    }
                    ?>

          <?php
                    if($sukses){
                        ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
                    }
                    ?>

          <form action="" method="POST">
            <!-- <div class="mb-3 row">
              <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
              <div class="col-sm-10"><input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo "$ISBN" ?>"></div>
            </div> -->

            <div class="mb-3 row">
              <label for="isbn" class="col-sm-2 col-form-label">Judul</label>
              <div class="col-sm-10"><input type="text" class="form-control" id="judul" name="judul" value="<?php echo "$Judul" ?>"></div>
            </div>

            <div class="mb-3 row">
              <label for="isbn" class="col-sm-2 col-form-label">Pengarang</label>
              <div class="col-sm-10"><input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo "$Pengarang" ?>"></div>
            </div>

            <div class="mb-3 row">
              <label for="isbn" class="col-sm-2 col-form-label">Penerbit</label>
              <div class="col-sm-10"><input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo "$Penerbit" ?>"></div>
            </div>

            <div class="mb-3 row">
              <label for="isbn" class="col-sm-2 col-form-label">Tahun terbit</label>
              <div class="col-sm-10"><input type="text" class="form-control" id="tahunterbit" name="tahun_terbit" value="<?php echo "$Tahun_terbit" ?>"></div>
            </div>

            <div class="mb-3 row">
              <label for="isbn" class="col-sm-2 col-form-label">Jumlah hal</label>
              <div class="col-sm-10"><input type="text" class="form-control" id="jumlahhal" name="jumlah_hal" value="<?php echo "$Jumlah_hal" ?>"></div>
            </div>

            <div class="col-12">
              <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" /> <a class="text-center w-100 bg-black" href="index.php?op=tambahdata">
              <button type="button" class="btn btn-primary">Tambah data</button></a> 
            </div>

          </form>
        </div>
      </div>
    </div>
    

    <!-- untuk mengeluarkan data -->
    <div class="mx-auto">
        <div class="card">
            <div class="card-header text-white bg-secondary">Data Perpustakaan</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Pengarang</th>
                            <th scope="col">Penerbit</th>
                            <th scope="col">Tahun terbit</th>
                            <th scope="col">Jumlah hal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <!-- mengurutkan -->
                            <?php
                            $sql2 = "select * from buku order by ISBN desc";
                            $q2 = mysqli_query($koneksi, $sql2);
                            $urut = 1;
                            while ($r2 = mysqli_fetch_array($q2)){
                                $ISBN           = $r2['ISBN'];
                                $Judul          = $r2['Judul'];
                                $Pengarang      = $r2['Pengarang'];
                                $Penerbit       = $r2['Penerbit'];
                                $Tahun_terbit   = $r2['Tahun_terbit'];
                                $Jumlah_hal     = $r2['Jumlah_hal'];
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $ISBN ?></td>
                                    <td scope="row"><?php echo $Judul ?></td>
                                    <td scope="row"><?php echo $Pengarang ?></td>
                                    <td scope="row"><?php echo $Penerbit ?></td>
                                    <td scope="row"><?php echo $Tahun_terbit ?></td>
                                    <td scope="row"><?php echo $Jumlah_hal ?></td>
                                    <td scope="row">

                                        <!-- Button edit -->
                                        <a href="index.php?op=edit&ISBN=<?php echo $ISBN?>">
                                            <button type="button" class="btn btn-warning">Edit</button></a>

                                        <!-- Button delete -->
                                        <a href="index.php?op=delete&ISBN=<?php echo $ISBN?>">
                                            <button type="button" class="btn btn-danger">Delete</button></a> 

                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            
                            </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
