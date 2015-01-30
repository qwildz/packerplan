<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top big" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo-navbar.png">
            </a>

        </div>
        <div class="">
            <ul class="nav navbar-nav navbar-left">
                <!--<li class="active"><a href="#">Home</a></li>-->
                <li><a href="list_tempat.php"><i class="fa fa-2x fa-map-marker"></i> Wisata</a></li>
                <li><a href="list_cawers.php"><i class="fa fa-2x fa-male"></i> Cawers</a></li>
                <li><a href="list_rencana.php"><i class="fa fa-2x fa-th-list"></i> Rencana</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(is_login()) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['username']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="profile.php">Profil</a></li>
                        <li><a href="edit_profile.php">Setting</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php } else { ?>
                <li><a href="login.php"><i class="fa fa-2x fa-sign-in"></i> Login</a></li>
                <?php } ?>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
