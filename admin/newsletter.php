<?php
require_once __DIR__ . '/../includes/init.inc.php';
// include_once './includes/dbh.inc.php';
// include_once './includes/paths.inc.php';
// include_once './includes/header.inc.php';
include_once './includes/navbar.inc.php';
include_once './includes/newsletter.inc.php';
?>

<body>
    <div class="container">
        <div class="admin-container">
            <h1>Create Newsletter</h1>
            <?php
            if (isset($_SESSION['message'])) : ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>

            <div id="newNews" class="news-container justify-content-center">
                <div class="form-group fg1">
                    <form class="news-form" action="includes/newsletter.inc.php" method="POST" onsubmit="showSendingMessage()" enctype="multipart/form-data">
                        <div class="form-group fg1">
                            <label for="subject">Subject:</label><br>
                            <input type="text" id="subject" name="subject" required><br><br>
                        </div>
                        <label>
                            <input type="checkbox" name="include_tour_dates" value="1" title="This will only include future tour-dates." checked> Include tour dates in the newsletter
                        </label>
                        <div class="form-group fg1">
                            <label for="content">Content:</label><br>
                            <textarea id="content" name="content" rows="10" cols="30" required></textarea><br><br>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Send Newsletter">
                        <!-- Sending message -->
                        <div class="sending-message" id="sendingMessage">Sending...</div>
                    </form>
                </div>
            </div>
            <h3>Subscribers</h3>
            <div class="news-container justify-content-center">
                <?php
                // Fetch data from the signup table
                $sql = "SELECT signup_email, signup_fname, signup_lname, signup_time FROM signup Where confirmed = 1";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table class='news-table table' border='1'>
        <thead>
            <tr>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Signed Up</th>
                <th></th>
            </tr>
        </thead>
        <tbody>";

                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        // Format the signup time to 12-hour format
                        $signup_time = $row['signup_time'];
                        $formatted_time = date("F j, Y, g:i A", strtotime($signup_time));
                        echo "<tr>
                <td class='news-td'>" . htmlspecialchars($row['signup_email']) . "</td>
                <td class='news-td'>" . htmlspecialchars($row['signup_fname']) . "</td>
                <td class='news-td'>" . htmlspecialchars($row['signup_lname']) . "</td>
                <td class='news-td'>" . htmlspecialchars($formatted_time) . "</td>
                <td><form action='includes/newsletter.inc.php' method='POST'onsubmit='return confirmDelete()'>
                        <input type='hidden' name='email' value='" . htmlspecialchars($row['signup_email']) . "'>
                        <input type='submit' class='btn btn-danger' name='delete' value='X' title='Delete this subscriber'>
                    
                        </form></td>
            </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "0 results";
                }

                $mysqli->close();
                ?>
            </div>

            <script>
                function showSendingMessage() {
                    document.getElementById('sendingMessage').style.display = 'block';
                }

                function confirmDelete() {
                    return confirm('Are you sure you want to delete this subscriber?');
                }
            </script>
</body>

</html>