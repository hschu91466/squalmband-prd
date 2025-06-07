<?php
require_once __DIR__ . '/../includes/init.inc.php';
include_once './includes/tours-process.php';
?>

<body>
    <div class="container">
        <div class="admin-container">
            <h1>Manage Tour Dates</h1>
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

            $result = $mysqli->query("SELECT * FROM tour") or die($mysqli->error);
            // pre_r($result);
            ?>

            <!-- $showForm is updated by the Add Form button, $update is updated by the edit button -->
            <div id="addDatesBtn">
                <?php if ($showForm != true) : ?>
                    <a href="tourdates.php?add" id="addDates" class="btn btn-info float-right" name="add">Add Tour Info</a>
                <?php endif; ?>

                <?php if ($showForm == true || $update == true) : ?>
            </div>

            <div id="newVideo" class="tour-container justify-content-center">
                <form class="tour-form" action="includes/tours-process.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group fg2">
                        <label for="tour_time">Tour Date</label>
                        <input type="datetime-local" id="tour_time" class="form-control" name="tour_time" value="<?php echo $tour_time; ?>">
                    </div>
                    <div class="form-group fg2">
                        <label for="venue">Venue</label>
                        <input type="text" id="venue" class="form-control" name="venue" value="<?php echo $venue; ?>">
                    </div>
                    <div class="form-group fg2">
                        <label for="location">Location</label>
                        <input type="text" id="location" class="form-control" name="location" value="<?php echo $location; ?>">
                        <h6 class="instruct"></h6>
                    </div>
                    <div class="form-group">
                        <?php if ($update == true) : ?>
                            <button type="submit" class="btn btn-info" name="update">Update</button>
                        <?php else : ?>
                            <button type="submit" class="btn btn-primary" name="save">Save</button>
                        <?php endif; ?>
                    </div>
                </form>
            <?php endif ?>
            </div>

            <div class="tour-container justify-content-center">
                <table class="tour-table table">
                    <thead>
                        <tr>
                            <th>TourDate</th>
                            <th>Venue</th>
                            <th>Location</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php
                        while ($row = $result->fetch_assoc()) : ?>
                            <tr>

                                <td class="tour-td" data-title="Tour Date"><?php echo date("m-d-y  h:i A", strtotime($row['tour_time'])); ?></td>
                                <td class="tour-td" data-title="Venue"><?php echo $row['venue']; ?></td>
                                <td class="tour-td" data-title="Location"><?php echo $row['location']; ?></td>
                                <td><a href="tourdates.php?edit=<?php echo $row['tid']; ?>" id="editVideo" class="btn btn-info" name="edit">Edit</a>
                                    <a href="tourdates.php?delete=<?php echo $row['tid']; ?>" class="btn btn-danger" name="delete">Delete</a>
                                </td>
                                <td></td>
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
</body>

</html>