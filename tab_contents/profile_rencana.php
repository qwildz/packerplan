<?php
$sql = "SELECT rencana.*, GROUP_CONCAT(id_tempat) ids_tempat, COUNT(id_tempat) AS tempat, pengikut,
            GROUP_CONCAT(latitude) AS latitude, GROUP_CONCAT(longitude) AS longitude
        FROM rute_rencana
        JOIN rencana USING (id_rencana)
        JOIN tempat_wisata USING (id_tempat)
        LEFT JOIN (
            SELECT p.id_rencana, COUNT(p.id_partisipan) AS pengikut
            FROM partisipan p
            GROUP BY p.id_rencana
        ) pen ON (pen.id_rencana = rute_rencana.id_rencana)
        WHERE username = '{$username}'
        GROUP BY rute_rencana.id_rencana
        ORDER BY created DESC";

$query = mysqli_query($koneksi, $sql);

$rencana = $query;

$jumlah_rencana = mysqli_num_rows($rencana);

$rencanas = array();
while ($row = mysqli_fetch_assoc($rencana))
{
    $rencanas[] = $row;
}
?>
<div class="reviews-container">
    <?php if ($rencanas)
    {
        ?>
        <div class="plans-small-container">
            <?php foreach ($rencanas as $row)
            { ?>
                <div class="plan-small">
                    <?php
                    $lat = explode(',', $row['latitude']);
                    $lng = explode(',', $row['longitude']);
                    $loc = array();
                    foreach ($lat as $k => $v)
                    {
                        $loc[] = array("lat" => $v, "lng" => $lng[ $k ]);
                    }
                    ?>
                    <div id="plan-map-<?php echo $row['id_rencana']; ?>" class="maps-static locations"
                         data-locations='<?php echo json_encode($loc); ?>'></div>
                    <div class="plan-details-container">
                        <div class="plan-detail pull-left">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="media-heading"><?php echo $row['nama_rencana']; ?></h5>
                                            <span><?php echo $row['tempat']; ?> tempat | <?php echo (int) $row['pengikut']; ?>
                                                barengers</span>
                                </div>
                            </div>
                        </div>
                        <div class="plan-date pull-right">
                            <span><?php echo date('j M Y', strtotime($row['waktu'])); ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    <?php
    }
    else
    { ?>
        <div class="alert alert-warning">Belum membuat review.</div>
    <?php } ?>
</div>