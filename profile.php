<?php
include 'koneksi.php';

if ( ! is_login())
{
    redirect('login.php');
}

$username = ($_GET['id']) ?: $_SESSION['username'];
$tab = $_GET['tab'];

$sql = "SELECT * FROM user WHERE username = '{$username}'";
$query = mysqli_query($koneksi, $sql);

$user = mysqli_fetch_assoc($query);


?>
<!DOCTYPE html>
<html>
<head lang="id">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $username; ?> - PackerPlan</title>

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
            <div class="col-md-4 profile-detail">
                <img class="media-object review-avatar" src="<?php echo get_gravatar($user['email'], 290); ?>">

                <h3 class="username"><?php echo $user['username']; ?></h3>

                <div class="nama"><?php echo $user['nama']; ?></div>
                <a class="btn  btn-primary">Edit Profile</a>
            </div>
            <div class="col-xs-8 profile-content">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="<?php if ( ! $tab) echo 'active'; ?>"><a
                            href="?id=<?php echo $username; ?>">Info</a></li>
                    <li role="presentation" class="<?php if ($tab == 'rencana') echo 'active'; ?>"><a
                            href="?id=<?php echo $username; ?>&tab=rencana">Rencana</a></li>
                    <li role="presentation" class="<?php if ($tab == 'review') echo 'active'; ?>"><a
                            href="?id=<?php echo $username; ?>&tab=review">Review</a></li>
                    <li role="presentation" class="<?php if ($tab == 'barengers') echo 'active'; ?>"><a
                            href="?id=<?php echo $username; ?>&tab=barengers">Barengers</a></li>
                </ul>

                <?php
                $tab_contents = ($tab) ? 'profile_' . $tab . '.php' : 'profile_info.php';
                include 'tab_contents/' . $tab_contents;
                ?>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            var jumboHeight = $('.jumbotron').outerHeight();

            function parallax() {
                var scrolled = $(window).scrollTop();
                $('.bg-parallax').css('height', (jumboHeight - scrolled) + 'px');
            }

            $(window).scroll(function (e) {
                parallax();
            });
        })
    </script>
</body>
</html>
