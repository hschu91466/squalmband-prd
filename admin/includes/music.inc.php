<link rel="stylesheet" href="<?php echo $path . 'css/iframe.css' ?>" />

<?php
$result = mysqli_query($mysqli, $sql);
$resultCheck = mysqli_num_rows($result); ?>
<div class="music-container">
    <?php if ($resultCheck > 0)
        while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="music-item"><iframe style="border-radius:12px" src="https://open.spotify.com/embed/<?php echo $row['src'] ?>?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture" loading="lazy">
            </iframe>
        </div>
    <?php endwhile; ?>
</div>