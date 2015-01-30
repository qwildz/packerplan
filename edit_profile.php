<?php
include 'koneksi.php';

if ( ! is_login())
{
    redirect('login.php');
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM user WHERE username = '{$username}'";
$query = mysqli_query($koneksi, $sql);

$user = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head lang="id">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Profile - PackerPlan</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-nonresponsive.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="blank-jumbotron"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 profile-detail">
                <form class="form-horizontal" action="process/edit_profile.php" method="post">
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>

                        <div class="col-sm-10">
                            <p class="form-control-static"><?php echo $user['username']; ?></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama" class="col-sm-2 control-label">Nama</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama"
                                   value="<?php echo $user['nama']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir" class="col-sm-2 control-label">Tanggal Lahir</label>

                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tgl_lahir" placeholder="Tanggal Lahir" name="tgl_lahir"
                                   value="<?php echo $user['tgl_lahir']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat" class="col-sm-2 control-label">Alamat</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" placeholder="Alamat" name="alamat"
                                   value="<?php echo $user['alamat']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin" class="col-sm-2 control-label">Jenis Kelamin</label>

                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" name="jenis_kelamin" id="jenis_kelamin_l" value="L" <?php if($user['jenis_kelamin'] == 'L') echo 'checked'; ?>> Laki - Laki
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="jenis_kelamin" id="jenis_kelamin_p" value="P" <?php if($user['jenis_kelamin'] == 'P') echo 'checked'; ?>> Perempuan
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">E-mail</label>

                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="E-mail" name="email"
                                   value="<?php echo $user['email']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
