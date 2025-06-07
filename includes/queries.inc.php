<?php require 'paths.inc.php'; ?>
<link rel="stylesheet" href="<?php echo $basePath . 'css/iframe.css' ?>" />

<?php
// queries.php

function getFeaturedVideo($mysqli)
{
    $featured = 'intro';
    $stmt = $mysqli->prepare("SELECT * FROM videos WHERE featured = ?");
    $stmt->bind_param("s", $featured);
    $stmt->execute();
    return $stmt->get_result();
}

function getStreamVideo($mysqli)
{
    $featured = 'stream';
    $stmt = $mysqli->prepare("SELECT * FROM videos WHERE featured = ?");
    $stmt->bind_param("s", $featured);
    $stmt->execute();
    return $stmt->get_result();
}

function getAllVideos($mysqli)
{
    $featured = 'video';
    $stmt = $mysqli->prepare("SELECT * FROM videos WHERE featured = ? ORDER BY vid DESC");
    $stmt->bind_param("s", $featured);
    $stmt->execute();
    return $stmt->get_result();
}

function getNews($mysqli)
{
    $stmt = $mysqli->prepare("SELECT * FROM news");
    $stmt->execute();
    return $stmt->get_result();
}

function getTourdata($mysqli)
{
    $stmt = $mysqli->prepare("SELECT * FROM tour where tour_time >= CURDATE()");
    $stmt->execute();
    return $stmt->get_result();
}

function displayStream($result)
{
    while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="music-item"><iframe style="border-radius:12px" src="https://open.spotify.com/embed/<?php echo $row['src'] ?>?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture" loading="lazy">
            </iframe>
            <div><?php echo $row['title'] ?></div>
        </div>
    <?php endwhile;
}

function displayVideos($result)
{
    while ($row = $result->fetch_assoc()): ?>
        <div class="outer-frame">
            <div class="inner-frame">
                <iframe style="position: absolute; border-radius: 15px; border: 1px solid black; top: 0; left:0; width: 100%; height: 100%;" loading="lazy" srcdoc="
                <style>
                    * { padding: 0; margin: 0; overflow: hidden; }
                    body, html { height: 100%; }
                    img, svg { position: absolute; width: 100%; top: 0; bottom: 0; margin: auto; }
                    svg { filter: drop-shadow(1px 1px 10px hsl(206.5, 70.7%, 8%)); transition: all 250ms ease-in-out; }
                    body:hover svg { filter: drop-shadow(1px 1px 10px hsl(206.5, 0%, 10%)); transform: scale(1.2); }
                </style>
                <a href='https://www.youtube.com/embed/<?php echo $row['src'] ?>?autoplay=1'>
                    <img src='https://img.youtube.com/vi/<?php echo $row['src'] ?>/hqdefault.jpg' alt='<?php echo $row['title'] ?>'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 24 24' fill='none' stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-play-circle'><circle cx='12' cy='12' r='10'></circle><polygon points='10 8 16 12 10 16 10 8'></polygon></svg>
                </a>" src="https://www.youtube.com/embed/<?php echo $row['src'] ?>" title="<?php echo $row['title'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div><?php echo $row['title'] ?></div>
        </div>
    <?php endwhile;
}

function newsVid($row)
{
    if (isset($row['img_path']) && !empty($row['img_path'])) {
    ?>
        <div class="outer-frame">
            <div class="inner-frame">
                <iframe style="position: absolute; border-radius: 15px; border: 1px solid black; top: 0; left:0; width: 100%; height: 100%;" loading="lazy" srcdoc="
                <style>
                    * { padding: 0; margin: 0; overflow: hidden; }
                    body, html { height: 100%; }
                    img, svg { position: absolute; width: 100%; top: 0; bottom: 0; margin: auto; }
                    svg { filter: drop-shadow(1px 1px 10px hsl(206.5, 70.7%, 8%)); transition: all 250ms ease-in-out; }
                    body:hover svg { filter: drop-shadow(1px 1px 10px hsl(206.5, 0%, 10%)); transform: scale(1.2); }
                </style>
                <a href='https://www.youtube.com/embed/<?php echo $row['img_path'] ?>?autoplay=1'>
                    <img src='https://img.youtube.com/vi/<?php echo $row['img_path'] ?>/hqdefault.jpg' alt='<?php echo $row['title'] ?>'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 24 24' fill='none' stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-play-circle'><circle cx='12' cy='12' r='10'></circle><polygon points='10 8 16 12 10 16 10 8'></polygon></svg>
                </a>" src="https://www.youtube.com/embed/<?php echo $row['img_path'] ?>" title="<?php echo $row['title'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div><?php echo $row['title'] ?></div>
        </div>
    <?php
    } else {
        echo "<div class='error'>Video source not available.</div>";
    }
}

function newsImg($row, $basePath)
{
    ?>
    <div class="news-item <?php echo $row['section']; ?>">
        <div class="news_media">
            <?php if (strpos($basePath, 'squalmband.com') !== false) : ?>
                <img src="<?php echo $basePath . 'img/' . $row['img_path']; ?>" alt="" />
                <script>
                    console.log('Image Link');
                </script>
            <?php else : ?>
                <img src="<?php echo $basePath . 'img/651db995bdda68.32093186.jpg'; ?>" alt="">
                <script>
                    console.log("Whatever");
                </script>
            <?php endif; ?>
        </div>
        <div class="news_title">
            <h2><?php echo $row['title']; ?></h2>
            <h4><?php echo $row['created_date']; ?></h4>
        </div>
        <div class="news_article">
            <?php echo $row['article']; ?>
        </div>
    </div>
    <?php
}

function displayNews($result, $basePath)
{
    while ($row = $result->fetch_assoc()): ?>
        <?php $section = $row['section']; ?>

        <div class="news-container">
            <?php if ($row['media_type'] == 'video') : ?>
                <div class="news-item <?php echo $section ?>">
                    <div class="news_media">
                        <?php newsVid($row); ?>
                    </div>
                    <script>
                        console.log('Hi There');
                    </script>
                    <div class="news_title">
                        <h2><?php echo $row['title'] ?></h2>
                        <h4><?php echo $row['created_date'] ?></h4>
                    </div>

                    <div class="news_article">
                        <?php echo $row['article'] ?>
                    </div>
                </div>
            <?php endif ?>

            <?php if ($row['media_type'] == 'image') : ?>
                <?php newsImg($row, $basePath); ?>

                <script>
                    console.log('Hi There');
                </script>

            <?php endif ?>

        </div>

    <?php endwhile;
}

function displayTourData($result)
{
    while ($row = $result->fetch_assoc()) : ?>
        <div class="row justify-content-center">
            <table class="table">
                <tr>
                    <td><?php echo date("m-d-y  h:i A", strtotime($row['tour_time'])); ?></td>
                    <td><?php echo $row['venue']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                </tr>
            </table>
        </div>
<?php endwhile;
}
?>