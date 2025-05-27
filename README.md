# 🎵 SQUALM Website

Welcome to the official repository for the squalmband-prd website. This site is built using PHP, HTML, CSS, and JavaScript, and includes an admin panel for managing content such as news, newsletters, tour dates, and videos.

---

## 📁 Project Structure

- .htaccess
- email.inc.php
- email_errors.log
- index.php
- admin/
  - .htaccesss
  - .htpasswd
  - index.php
  - news.php
  - newsletter.php
  - tourdates.php
  - css/
    - admin.css
  - includes/
    - dbh.inc.php
    - email_config.php
    - header.inc.php
    - music-process.php
    - music.inc.php
    - navbar.inc.php
    - news-process.php
    - newsletter.inc.php
    - newvideo.inc.php
    - paths.inc.php
    - readme.txt
    - tours-process.php
    - upload.php
    - video.inc.php
  - js/
    - admin.js
- css/
  - iframe.css
  - index.css
  - lite_youtube.css
  - main.css
  - navbar.css
  - temp.css
  - unsubscribe.css
  - videobg.css
- img/
  - .htaccess
  - [Multiple image and video files, e.g., 651db8c3687e53.67591882.png, Boyz4.mp4, jozaylogo2.jpg, etc.]
  - index.php
- includes/
  - .htaccess
  - .htpasswd
  - dbh.inc.php
  - email.inc.php
  - email_config.php
  - footer.inc.php
  - header.inc.php
  - init.inc.php
  - nav.inc.php
  - paths.inc.php
  - queries.inc.php
  - signup.inc.php
- js/
  - script.js
- pages/
  - about.php
  - confirm.php
  - sent.php
  - unsubscribe.php
- vendor/
  - autoload.php
  - composer/
    - autoload_classmap.php
    - autoload_namespaces.php
    - autoload_psr4.php
    - autoload_real.php
    - autoload_static.php
    - ClassLoader.php
    - installed.json
    - installed.php
    - InstalledVersions.php
    - LICENSE
    - platform_check.php
  - phpmailer/phpmailer/src/
    - DSNConfigurator.php
    - Exception.php
    - OAuth.php
    - OAuthTokenProvider.php
    - PHPMailer.php
    - POP3.php
    - SMTP.php

## 🚀 Features

- Public-facing website with multimedia content
- Admin panel for managing:
  - News
  - Newsletters
  - Tour dates
  - Videos
- Email integration via PHPMailer
- Responsive design with custom CSS
- Secure access using `.htaccess` and `.htpasswd`

---

## 🛠️ Technologies Used

- PHP
- HTML5 / CSS3
- JavaScript
- PHPMailer
- Composer (for dependency management)
- Apache (.htaccess for routing and security)

---