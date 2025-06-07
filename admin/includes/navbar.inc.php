    <?php
    require_once __DIR__ . '/../../includes/init.inc.php';
    ?>

    <?php
    if (stripos($_SERVER['REQUEST_URI'], 'pages')) {
        $newPath = $path;
        $navClass = "";
    } else {
        $newPath = "";
        $navClass = "a-link";
    }

    ?>

    <header section-container>
        <nav>
            <span class="nav-title">
                <h1>SQUALM</h1>
            </span>
            <div class="nav-links">
                <ul id="navbar" class="nav-menu">
                    <li>
                        <a class="active" href="../index.php">home</a>
                    </li>
                    <li>
                        <a class="<?php echo $navClass ?>" href="<?php echo $newPath . 'index.php' ?>">manage music</a>
                    </li>
                    <li>
                        <a class="<?php echo $navClass ?>" href="<?php echo $newPath . 'tourdates.php' ?>">manage tour dates</a>
                    </li>
                    <li>
                        <a class="<?php echo $navClass ?>" href="<?php echo $newPath . 'news.php' ?>">manage news</a>
                    </li>
                    <li>
                        <a class="<?php echo $navClass ?>" href="<?php echo $newPath . 'newsletter.php' ?>">create newsletter</a>
                    </li>
                </ul>
            </div>
            <div class="hamburger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </nav>
    </header>