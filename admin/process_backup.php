<?php
include('koneksi.php');
include_once(dirname(__FILE__) . '/mysqldump-php-1.3/src/Ifsnop/Mysqldump/Mysqldump.php');

use Ifsnop\Mysqldump as IMysqldump;

if (isset($_POST['download']))
{
    @unlink('dump.sql');

    $dumpSettings = array(
        'compress'                   => IMysqldump\Mysqldump::NONE,
        'no-data'                    => false,
        'add-drop-table'             => true,
        'single-transaction'         => true,
        'lock-tables'                => false,
        'add-locks'                  => true,
        'extended-insert'            => true,
        'disable-foreign-keys-check' => true,
        'skip-triggers'              => false,
        'add-drop-trigger'           => true,
        'databases'                  => false,
        'add-drop-database'          => false,
        'hex-blob'                   => true
    );

    try
    {
        $dump = new IMysqldump\Mysqldump($name, $user, $pass, $host, 'mysql', $dumpSettings);
        $dump->start('dump.sql');

        header("Content-disposition: attachment; filename=dump.sql");
        header("Content-type: application/octet-stream");
        readfile("dump.sql");
    }
    catch (\Exception $e)
    {
        echo 'mysqldump-php error: ' . $e->getMessage();
    }
}
else
{
    redirect('index.php');
}