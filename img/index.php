<?php
include_once 'includes/dbh.inc.php';
include_once 'includes/header.inc.php';
include_once 'includes/paths.inc.php';
?>

<body>
    <header id="header" class="main-banner">
        <?php
        include_once 'includes/nav.inc.php';
        ?>
    </header>
    <main id="main-content">
        <section id="intro" class="intro hero section-container">
            <video class="video_bg" autoplay loop muted plays-inline>
                <source src="<?php echo $path . '/img/boyz8.mp4' ?>" type="video/mp4">
            </video>
            <!-- <div class="section-content"> -->
            <div class="intro-container">
                <div class="articles">
                    <div class="article featured-text">
                        <p>
                        <h1>Are you looking for us?</h1>
                        </p>
                        <p id="short-text">
                            Squalm’s music is inspired by the heavy rhythm of Funk, the psychedelic melodies of Bedroom
                            Rock, the lyrical creaminess of American Folk Rock, and a general disregard for personal appearance.
                            <!-- <a href="#" id="read-more"> Read More</a> -->
                        </p>
                        <p id="full-text" class="hidden">
                            Squalm’s music is inspired by the heavy rhythm of Funk, the psychedelic melodies of Bedroom
                            Rock, the lyrical creaminess of American Folk Rock, and a general disregard for personal appearance. They
                            also have abrasive personalities. Also, we're in the market for a reasonably sized coffee table, like, in case you have one you
                            don't want. Thank you, Mom, for making this website for us.
                            <!-- <a href="#" id="read-less"> Close</a> -->
                        </p>
                    </div>
                    <div class="article featured-video">

                        <h1>Watch featured video</h1>
                        <?php
                        $sql = "SELECT * FROM videos where featured = 'intro';";
                        include "includes/video.inc.php"
                        ?>

                    </div>
                    <div class="article social-media">
                        <div class="social-container">
                            <ul class="social">
                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Facebook" style="background-color: #3b5998;" href="https://www.facebook.com/profile.php?id=61551555816555&mibextid=ZbWKwL" target="_blank" role="button"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Spotify" style="background-color: #1ed760;color:#fff" href="https://open.spotify.com/artist/2cMMWuinHbQs0Bf1RTVNgH?si=edduLr8cTeWX836mLhJjCA" target="_blank" role="button"><i class="fab fa-spotify"></i></a>
                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Instagram" style="background-color: #ac2bac;" href="https://instagram.com/squalm2?igshid=OGQ5ZDc2ODk2ZA==" target="_blank" role="button"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Twitter X" style="background-color: #55acee;" href="https://x.com/Squalm1175841?t=zaONE7OqIAf8n9NFVbKSTQ&s=09" target="_blank" role="button"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Snapchat" style="background-color: #fffc00; color: #000;" href="https://www.snapchat.com/add/squalm_band?share_id=VylJjntB1DM&locale=en-US" target="_blank" role="button"><i class="fab fa-snapchat"></i></a>
                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="itunes" style="background-color: #fff; color: #5A5A5A;" href="https://music.apple.com/us/artist/squalm/1623436486" target="_blank" role="button"><i class="fab fa-snapchatfab fa-apple"></i></a>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <!-- </div> -->
            </div>
        </section>
        <section id="music" class="music section-container">
            <div class="section-content">
                <h1>Stream</h1>
                <div class="music-container">
                    <div class="">
                        <?php
                        $sql = "SELECT * FROM videos where featured = 'stream';";
                        include "includes/music.inc.php";
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <section id="videos" class="video section-container">
            <h1>Videos</h1>
            <div class="video-container">
                <?php
                $sql = "SELECT * FROM videos where featured = 'video';";
                include "includes/video.inc.php";
                ?>
            </div>
        </section>
        <section id="news" class="news section-container">
            <div class="news-container">
                <h1>News</h1>
                <?php
                $sql = "SELECT * FROM news;";
                include "includes/news2.inc.php";
                ?>
            </div>

        </section>
        <section id="tour" class="tour section-container">
            <div class="tour-container">
                <h1>Now Playing</h1>
                <?php
                $sql = "SELECT * FROM tour;";
                $result = mysqli_query($mysqli, $sql);
                $resultCheck = mysqli_num_rows($result);
                if ($resultCheck > 0) {
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
            </div>
        </section>
        <section id="contactus" class="contactus section-container">
            <div class="section-content">
                <div class="contact-container">
                    <h1>Contact</h1>
                    <div class="contact-info">
                        <form method="post" action="email.inc.php" method="POST">
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" id="fname" required />
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" id="lname" required />
                            </div>
                            <div class="form-group"><label for="email">email</label>
                                <input type="email" name="email" id="email" required />
                            </div>
                            <!-- <div class="form-group">
                            <input type="checkbox" id="signup" name="signup" value="signup" />
                            <label for="signup">Signup for our newsletter.</label>
                        </div> -->
                            <div class="form-group"><label for="subject">Subject</label>
                                <input type="text" name="subject" id="subject" required />
                            </div>
                            <div class="form-group"><label for="message">Message</label>
                                <textarea name="message" id="message" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer section-container">
        <p class="copyright">&copy; 2023 SQUALM- Garage-Jazz. All Rights Reserved.</p>
    </footer>
    <script src="./js/script.js"></script>
</body>

</html>