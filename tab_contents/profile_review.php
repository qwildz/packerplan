<?php
$sql = "SELECT review.*, tempat_wisata.id_tempat, tempat_wisata.nama_tempat, foto_wisata.foto
        FROM review
        JOIN tempat_wisata USING (id_tempat)
        JOIN foto_wisata USING (id_tempat)
        WHERE username = '{$username}'
        GROUP BY id_review
        ORDER BY created DESC";

$query = mysqli_query($koneksi, $sql);

$review = $query;

$jumlah_review = mysqli_num_rows($review);

$rating = 0;
$komentar = array();
while ($row = mysqli_fetch_assoc($review))
{
    $rating += $row['bintang'];
    $komentar[] = $row;
}
?>
<div class="reviews-container">
    <?php if ($komentar)
    {
        foreach ($komentar as $k)
        { ?>
            <div class="media review">
                <a class="pull-left" href="#">
                    <img class="media-object review-avatar" src="media/<?php echo $k['foto']; ?>">
                </a>

                <div class="media-body review-body">
                    <h4 class="media-heading review-author"><a
                            href="tempat.php?id_tempat=<?php echo $k['id_tempat']; ?>"><?php echo $k['nama_tempat']; ?></a>
                    </h4>

                    <div class="review-metas-container">
                                <span class="review-meta review-date">
                                    <i class="fa fa-calendar-o"></i> <?php echo date('d F y', strtotime($k['created'])); ?>
                                </span>
                                <span class="review-meta review-time">
                                    <i class="fa fa-clock-o"></i> <?php echo date('H:i', strtotime($k['created'])); ?>
                                </span>
                                <span class="review-meta review-rating">
                                    <i class="fa fa-star-o"></i> <?php echo $k['bintang']; ?>
                                </span>
                    </div>
                    <div class="review-paragraph">
                        <p><?php echo nl2br($k['teks']); ?></p>
                    </div>
                </div>
            </div>
        <?php }
    }
    else
    { ?>
        <div class="alert alert-warning">Belum membuat review.</div>
    <?php } ?>
</div>