    <?php
    require "paths.inc.php";
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

    <nav>
        <span class="nav-title">
            <h1>squalm</h1>
        </span>
        <div class="nav-links">
            <ul id="navbar" class="nav-menu">
                <li>
                    <a class="active <?php echo $navClass ?>" href="<?php echo $newPath ?>#intro">home</a>
                </li>
                <li>
                    <a class="<?php echo $navClass ?>" href="<?php echo $newPath ?>#videos">video</a>
                </li>
                <li>
                    <a class="<?php echo $navClass ?>" href="<?php echo $newPath ?>#music">music</a>
                </li>
                <li>
                    <a class="<?php echo $navClass ?>" href="<?php echo $newPath ?>#news">news</a>
                </li>
                <li>
                    <a class="<?php echo $navClass ?>" href="<?php echo $newPath ?>#contactus">contact</a>
                </li>
                <li>
                    <a class="<?php echo $navClass ?>" href="<?php echo $newPath ?>#tour">tour</a>
                </li>
                <li>
                    <a href="<?php echo $newPath . 'pages/about.php' ?>#aboutus">about</a>
                </li>
            </ul>
        </div>
        <div class="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </nav>