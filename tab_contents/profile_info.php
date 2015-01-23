<dl class="dl-horizontal">
    <dt>Email</dt>
    <dd><?php echo $user['email']; ?></dd>
    <dt>Jenis Kelamin</dt>
    <dd><?php echo ($user['jenis_kelamin']) ? (strtolower($user['jenis_kelamin']) == 'l') ? 'Laki-laki' : 'Perempuan' : '-'; ?></dd>
    <dt>Alamat</dt>
    <dd><?php echo ($user['alamat']) ?: '-'; ?></dd>
    <dt>Tanggal Lahir</dt>
    <dd><?php echo date('j-M-Y', strtotime($user['tgl_lahir'])); ?></dd>
    <dt>User Sejak</dt>
    <dd><?php echo date('j-M-Y', strtotime($user['created'])); ?></dd>
</dl>