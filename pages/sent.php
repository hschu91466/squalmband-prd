<?php
include_once '../includes/init.inc.php';
?>
<header id="header" class="main-banner">
    <?php
    include_once '../includes/nav.inc.php';
    ?>
</header>

<section class="email-sent section-container">
    <h3>
        <?php
        if (isset($_GET['message'])) {
            echo html_entity_decode($_GET['message']);
        }
        ?></h3>


</section>


<?php include_once '../includes/footer.inc.php';
