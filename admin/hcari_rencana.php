<?php
include('koneksi.php');
?>
<!DOCTYPE html>
<html>
<?php include 'includes/head.php'; ?>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php include 'includes/header.php'; ?>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php include 'includes/menu.php'; ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Rencana
                        <small>Tabel rencana</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Data Rencana</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    
                                    <div class="box-tools">
                                        <div class="input-group">
                                            <form name="fcari_user"action="hcari_rencana.php" method="post" class="sidebar-form" >
												<div class="input-group">
													<input type="text" name="cari" style="width: 200px;"class="form-control input-sm pull-right" placeholder="Masukkan username...">
													<span class="input-group-btn">
														<button type="submit" name="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
													</span>
												</div>
											</form>
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>No.</th>
											<th>Username</th>
											<th>Nama</th>
											<th>Waktu</th>
											<th>Opsi</th>
										</tr>
									
										<?php
										$cari = trim($_POST['cari']);
										//query ke database dg SELECT table tempat wisata diurutkan berdasarkan id paling kecil
										$query = mysql_query("SELECT a.id_rencana,b.username,b.nama,a.waktu FROM rencana a,user b WHERE (a.username=b.username) AND (a.username LIKE '%$cari%')") or die(mysql_error());
										
										//cek, apakakah hasil query di atas mendapatkan hasil atau tidak (data kosong atau tidak)
										if(mysql_num_rows($query) == 0){	//ini artinya jika data hasil query di atas kosong
											
											
											echo '<tr><td colspan="6">Tidak ada data!</td></tr>';
											
										}else{	
											
											
											$no = 1;
											while($data = mysql_fetch_assoc($query)){	//perulangan while dg membuat variabel $data yang akan mengambil data di database
												
												//menampilkan row dengan data di database
												echo '<tr>';
													echo '<td>'.$no.'</td>';	//menampilkan nomor urut
													echo '<td>'.$data['username'].'</td>';	//menampilkan data nis dari database
													echo '<td>'.$data['nama'].'</td>';	//menampilkan data nama lengkap dari database
													echo '<td>'.$data['waktu'].'</td>';	//menampilkan data kelas dari database
													echo '<td><a href="detail.php?id='.$data['id_rencana'].'"><button class="btn btn-info">Detail</button></a><a href="hapus_rencana.php?id='.$data['id_rencana'].'" onclick="return confirm(\'Yakin?\')"><button class="btn btn-danger">Hapus</button></a></td>';
												echo '</tr>';
												
												$no++;	//menambah jumlah nomor urut setiap row
											}
										}
									?>
										
										</table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <?php include 'includes/footer.php'; ?>
    </body>
</html>