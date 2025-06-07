<?php
require_once __DIR__ . '/../includes/init.inc.php';
// include_once './includes/dbh.inc.php';
// include_once './includes/paths.inc.php';
// include_once './includes/header.inc.php';
include_once './includes/navbar.inc.php';
include_once './includes/music-process.php';
?>
<div class="container">
    <div class="admin-container">
        <h1>Manage Youtube and Spotify links</h1>
        <?php
        if (isset($_SESSION['message'])) : ?>
            <div class="alert-<?= $_SESSION['msg_type'] ?>">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <?php

        $result = $mysqli->query("SELECT * FROM videos") or die($mysqli->error);
        // pre_r($result);
        ?>

        <!-- $showForm is updated by the Add Form button, $update is updated by the edit button -->
        <div id="addArtBtn">
            <?php if ($showForm != true) : ?>
                <a href="index.php?add" id="addMusic" class="btn btn-info float-right" name="add">Add Music</a>
            <?php endif; ?>

            <?php if ($showForm == true || $update == true) : ?>
        </div>

        <!-- Create update form -->
        <div id="newVideo" class="music-container justify-content-center">
            <form class="music-form" action="includes/music-process.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group fg2">
                    <label for="title">Video Title</label>
                    <input type="text" id="title" class="form-control" name="title" value="<?php echo $title; ?>">
                </div>
                <div class="form-group fg2">
                    <label for="description">Description<br><small>(optional)</small></label>
                    <input type="text" id="description" class="form-control" name="description" value="<?php echo $description; ?>">
                </div>

                <div id="featured" class="form-group">
                    <label for="featured">Add to:</label>
                    <input type="radio" name="featured" class="featured" id="intro" <?php echo ($featured == 'intro') ? 'checked' : '' ?> value="intro" checked>
                    <label for="intro">intro section</label>
                    <input type="radio" name="featured" class="featured" id="video" <?php echo ($featured == 'video') ? 'checked' : '' ?> value="video">
                    <label for="video">videos section</label>
                    <input type="radio" name="featured" class="featured" id="stream" <?php echo ($featured == 'stream') ? 'checked' : '' ?> value="stream">
                    <label for="stream">steaming section</label>
                </div>
                <div class="instruct">
                    <h6 class="instruct">Instructions</h6>
                    <p id="instructions">To add a new video to the site, go to <a href="https: //www.youtube.com/@squalm6846/videos">https://www.youtube.com/@squalm6846/videos</a>. Click on the video. From the url, select only the text after the equal sign. Example: https://www.youtube.com/watch?v=<span style="background:yellow">1ttZ2kqsOeI</span> and paste into the Embed Code box below.</p>
                </div>

                <div class="form-group fg2">
                    <label for="src">Embed Code</label>
                    <input type="text" id="src" class="form-control" name="src" value="<?php echo $src; ?>">
                </div>
                <div class="form-group">
                    <label for="cover">Cover</label>
                    <input type="radio" name="cover" id="no" <?php echo ($cover == 'no') ? 'checked' : '' ?> value="no" checked>
                    <label for="no">no</label>
                    <input type="radio" name="cover" id="yes" <?php echo ($cover == 'yes') ? 'checked' : '' ?> value="yes">
                    <label for="yes">yes</label>
                </div>

                <?php

                ?>
                <div class=" form-group">
                    <?php if ($update == true) : ?>
                        <button type="submit" class="btn btn-info" name="update">Update</button>
                    <?php else : ?>
                        <button type="submit" class="btn btn-primary" name="save">Save</button>
                    <?php endif; ?>
                </div>
            </form>
        <?php endif; ?>
        </div>
        <div class="music-container justify-content-center">
            <table class="music-table table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Section</th>
                        <th>Cover</th>
                        <th colspan="2">
                            <!-- <a href="<?php echo $path . 'admin/index.php#newVideo' ?>" class="btn btn-primary" id="addVideo" name="add">Add Link</a> -->
                        </th>
                    </tr>
                </thead>
                <tbody>


                    <?php
                    while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="music-td" data-title="Title"><?php echo $row['title']; ?></td>
                            <td class="music-hide" data-title="Description"><?php echo $row['description']; ?></td>
                            <td class="music-td" data-title="Section"><?php echo $row['featured']; ?></td>
                            <td class="music-td" data-title="Cover"><?php echo $row['cover']; ?></td>
                            <td class="music-btn"><a href="index.php?edit=<?php echo $row['vid']; ?>" id="editVideo" class="btn btn-info" name="edit">Edit</a>
                                <a href="index.php?delete=<?php echo $row['vid']; ?>" class="btn btn-danger" name="delete">Delete</a>
                            </td>
                            <!-- <td><a href="index.php?delete=<?php echo $row['vid']; ?>" class="btn btn-danger" name="delete">Delete</a></td> -->
                        </tr>
                    <?php endwhile ?>
                </tbody>
                <tfoot>
                    </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
        // pre_r($result->fetch_assoc());

        function pre_r($array)
        {
            echo '<pre>';
            print_r($array);
            echo '<pre>';
        }
        ?>
    </div>
</div>
</body>

</html>