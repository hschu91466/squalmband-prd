<?php
require_once __DIR__ . '/../includes/init.inc.php';
// include_once './includes/dbh.inc.php';
// include_once './includes/paths.inc.php';
// include_once './includes/header.inc.php';
include_once './includes/navbar.inc.php';
include_once './includes/news-process.php';
?>

<body>
    <div class="container">
        <div class="admin-container">
            <h1>Manage News Page</h1>
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

            $result = $mysqli->query("SELECT * FROM news") or die($mysqli->error);
            // pre_r($result);
            ?>

            <!-- $showForm is updated by the Add Form button, $update is updated by the edit button -->
            <div id="addNewsBtn">
                <?php if ($showForm != true) : ?>
                    <a href="news.php?add" id="addNews" class="btn btn-info float-right" name="add">Add News Article</a>
                <?php endif; ?>

                <?php if ($showForm == true || $update == true) : ?>
            </div>

            <div id="newNews" class="news-container justify-content-center">
                <form class="news-form" action="includes/news-process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group fg2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $title ?>">
                    </div>
                    <div class="form-group fg2">
                        <label for="created_date">Date</label>
                        <?php
                        if ($update == true) {
                            $date = $created_date;
                        } else {
                            $date = date("h:i:sa");
                        }

                        $newDate = date("Y-m-d", strtotime($date));
                        ?>
                        <!-- <input type="date" class="form-control" id="created_date" name="created_date" value="<?php echo date("Y/m/d") ?>"> -->
                        <input type="date" class="form-control" id="created_date" name="created_date" value="<?php echo $newDate ?>">
                    </div>
                    <div class="form-group fg2">
                        <label for="article">Article</label>
                        <!-- <input type="text" class="form-control" id="article" name="article" value="<?php echo $article ?>"> -->
                        <textarea class="form-control" id="article" name="article"><?php echo $article ?></textarea>
                    </div>
                    <div class="form-group fg1">
                        <label for="media_type">Media Type</label>
                        <input type="radio" name="media_type" class="media_type" id="image" <?php echo ($media_type == 'image') ? 'checked' : '' ?> value="image" checked>
                        <label for="image">Image</label>
                        <input type="radio" name="media_type" class="media_type" id="video" <?php echo ($media_type == 'video') ? 'checked' : '' ?> value="video">
                        <label for="video">Video</label>
                    </div>

                    <div class="form-group" id="video-instructions">
                        <label for="img_path">Instructions for adding videos</label>
                        <div class="instruct">
                            <p id="instructions">To add a new video to the site, go to <a href="https: //www.youtube.com/@squalm6846/videos">https://www.youtube.com/@squalm6846/videos</a>. Click on the video. From the url, select only the text after the equal sign. Example: https://www.youtube.com/watch?v=<span style="background:yellow">1ttZ2kqsOeI</span> and paste into the Embed Code box below.</p>
                        </div>
                        <input type="text" class="form-control" id="img_path" name="img_path" value="<?php echo $img_path ?>">
                    </div>

                    <div class="form-group fg2" id="image-instructions">
                        <label for="file">Upload Image</label>
                        <input type="file" name="file">
                    </div>


                    <div class="form-group fg1">
                        <label for="section">Section</label>
                        <input type="radio" name="section" id="left" <?php echo ($section == 'left') ? 'checked' : '' ?> value="left" checked>
                        <label for="left">Media on Left</label>
                        <input type="radio" name="section" id="right" <?php echo ($section == 'right') ? 'checked' : '' ?> value="right">
                        <label for="right">Media on Right</label>
                    </div>
                    <div class="form-group fg1">
                        <?php if ($update == true) : ?>
                            <button type="submit" class="btn btn-info" name="update">Update</button>
                        <?php else : ?>
                            <button type="submit" class="btn btn-primary" name="save">Save</button>
                        <?php endif; ?>
                    </div>
                </form>
            <?php endif; ?>
            </div>

            <div class="news-container justify-content-center">
                <table class="news-table table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Image Path</th>
                            <th>Section</th>
                            <th>Type</th>
                            <th>Article</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class="news-td" data-title="Title"><?php echo $row['title']; ?></td>
                                <td class="news-td" data-title="Date"><?php echo $row['created_date']; ?></td>
                                <td class="news-td" data-title="Image"><?php echo $row['img_path']; ?></td>
                                <td class="news-td" data-title="Section"><?php echo $row['section']; ?></td>
                                <td class="news-td" data-title="Type"><?php echo $row['media_type']; ?></td>
                                <td class="news-td" data-title="Article"><?php echo $row['article']; ?></td>
                                <td><a href="news.php?edit=<?php echo $row['nid']; ?>" id="editVideo" class="btn btn-info" name="edit">Edit</a></td>
                                <td><a href="news.php?delete=<?php echo $row['nid']; ?>" class="btn btn-danger" name="delete">Delete</a></td>
                            </tr>
                            <!-- <tr>
                                <th>Article</th>
                            </tr>
                            <tr>
                                <td colspan="7"><?php echo $row['article']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    ***
                                </td>
                            </tr> -->
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>


            <!-- <form action="includes/upload.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file">
                <button type="submit" name="submit">Upload Image</button>
            </form> -->
        </div>
    </div>

</body>

</html>