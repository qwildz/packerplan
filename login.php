<?php
include 'koneksi.php';

if(is_login())
{
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>Login - PackerPlan</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="admin/js/html5shiv.js"></script>
    <script src="admin/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">

    <div class="form-box" id="login-box">
        <div class="header">Login</div>
        <form action="process/login.php" method="post">
            <div class="body bg-gray">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                </div>
            </div>
            <div class="footer">
                <button type="submit" class="btn bg-olive btn-block">Login</button>

                <a href="register.php" class="text-center">Daftar Baru</a>
            </div>
        </form>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>