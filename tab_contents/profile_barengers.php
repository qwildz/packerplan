<?php
$sql = "SELECT user.*, COUNT(*) combo
        FROM partisipan
	    JOIN USER USING (username)
        JOIN rencana USING (id_rencana)
        WHERE rencana.username = '{$username}'
        GROUP BY username
        ORDER BY combo DESC";

$query = mysqli_query($koneksi, $sql);
$barengers = array();
while ($row = mysqli_fetch_assoc($query))
{
    $barengers[] = $row;
}
?>
<div class="reviews-container">
    <?php if ($barengers)
    {
        foreach ($barengers as $k)
        { ?>
            <div class="media review">
                <a class="pull-left" href="profile.php?id=<?php echo $k['username']; ?>">
                    <img class="media-object review-avatar" src="<?php echo get_gravatar($k['email']); ?>">
                </a>

                <div class="media-body review-body">
                    <h4 class="media-heading review-author"><a
                            href="profile.php?id=<?php echo $k['username']; ?>"><?php echo $k['nama']; ?></a>
                    </h4>

                    <div class="review-metas-container">
                                <span class="review-meta review-date">
                                    <i class="fa fa-group"></i> <?php echo $k['combo']; ?>x
                                </span>
                    </div>
                </div>
            </div>
        <?php }
    }
    else
    { ?>
        <div class="alert alert-warning">Belum ada barengers.</div>
    <?php } ?>
</div>