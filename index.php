<?php
	$server ="localhost";
	$user ="root";
	$pass = "";
	$database ="arkademy";

	$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['ssubmit'])){

		//Data akan diedit atau disimpan baru
		if ($_GET['hal']="edit") {

			//edit data yang dipilih

			$edit = mysqli_query($koneksi, "UPDATE produk SET nama_produk = '$_POST[nama_produk]', 
															  keterangan = '$_POST[keterangan_produk]',
															  harga = '$_POST[harga_produk]',
															  jumlah = '$_POST[jumlah_produk]'

															  WHERE id_produk = '$_GET[id]'
										 ");
			if($edit){
				echo "<script>
				        alert('Data berhasil diubah !');
				        document.location='index.php';
				      </script>";
			}

			else {
				echo "<script>
				        alert('Data gagal tidak tersimpan !!');
				        document.location='index.php';
				      </script>";
			}
		}


		else{
			//data simpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, keterangan, harga, jumlah) VALUES  ('$_POST[nama_produk]', 
																											  '$_POST[keterangan_produk]',
																											  '$_POST[harga_produk]',
																											  '$_POST[jumlah_produk]')
										 ");
			if($simpan){
				echo "<script>
				        alert('Data tersimpan !');
				        document.location='index.php';
				      </script>";
			}

			else {
				echo "<script>
				        alert('Data gagal tersimpan !!');
				        document.location='index.php';
				      </script>";
			}
		}

		
	}

	//Pengujian jika tombol Edit/Hapus diklik
	if(isset($_GET['hal'])){

		//Pengujian jika edit data
		if($_GET['hal'] == "edit"){

			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if ($data){
				//Jika data ada, maka :

				$var_nama_produk = $data['nama_produk'];
				$var_keterangan = $data['keterangan'];
				$var_harga = $data['harga'];
				$var_jumlah = $data['jumlah'];
			}
		}

		else if ($_GET['hal']="hapus"){
			$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$_GET[id]'");
			if($hapus){
				echo "<script>
				        alert('Data berhasil dihapus !');
				        document.location='index.php';
				      </script>";
			}

			else {
				echo "<script>
				        alert('Data gagal terhapus !!');
				        document.location='index.php';
				      </script>";
			}
		}
	}

?>





<!DOCTYPE html>
<html>
<head>
	<title>SOAL TUGAS 10</title>
	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>
<body>

<div class="container">
	<h1 class="text-center">CRUD</h1>

	<!-- awal card -->
	<div class="card mt-5">
	  <div class="card-header bg-warning">
	    INPUT DATA PRODUK
	  </div>
	  <div class="card-body">
	    <form action="" method="post">
	    	<div class="form-group">
	    		<label>Nama Produk</label>
	    		<input type="text" name="nama_produk" value="<?=@$var_nama_produk?>" class="form-control" placeholder="nama produk" required>
	    			    	</div>

	    	<div class="form-group">
	    		<label>Keterangan</label>
	    		<input type="text" name="keterangan_produk" value="<?=@$var_keterangan?>" class="form-control" placeholder="keterangan" required>
	    	</div>

	    	<div class="form-group">
	    		<label>Harga</label>
	    		<input type="number" name="harga_produk" value="<?=@$var_harga?>" class="form-control" placeholder="contoh : 50000" required>
	    	</div>

	    	<div class="form-group">
	    		<label>Jumlah</label>
	    		<input type="number" name="jumlah_produk" value="<?=@$var_jumlah?>" class="form-control" placeholder="jumlah" required>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="ssubmit">Simpan</button>
	    	<button type="reset" class="btn btn-success" name="sreset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- akhir card -->

	<!-- awal card tabel -->
	<div class="card mt-5">
	  <div class="card-header bg-primary">
	    DATA PRODUK
	  </div>
	  <div class="card-body">
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Nama Produk</th>
	    		<th>Keterangan</th>
	    		<th>Harga</th>
	    		<th>Jumlah</th>
	    		<th>Aksi</th>
	    	</tr>

	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from produk ");
	    		while($data = mysqli_fetch_array($tampil)) :
	    	?>

	    	<tr>
	    		<td><?php echo $no++; ?></td>
	    		<td><?php echo $data['nama_produk'] ?></td>
	    		<td><?php echo $data['keterangan'] ?></td>
	    		<td><?php echo $data['harga'] ?></td>
	    		<td><?php echo $data['jumlah'] ?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_produk']?>" class="btn btn-warning"> Edit </a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id_produk']?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? ')" class="btn btn-danger"> Hapus </a>

	    		</td>
	    	</tr>

	    	<?php endwhile;?>

	    </table>
	  </div>
	</div>
	<!-- akhir card tabel-->

</div>


<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
