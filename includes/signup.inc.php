<?php
require 'includes/dbh.inc.php';
require 'includes/paths.inc.php';

$id = 0;
$signup_email = "";
$signup_fname = "";
$signup_lname = "";

if (isset($_POST['submit'])) {
    echo "This worked";
}
?>
<link rel="stylesheet" href="<?php echo $path . 'css/iframe.css' ?>" />

<style>

</style>

<form action="">
    <input class="signup" type="email" placeholder="Sign up for our Email List!" name="signup">
    <button type="submit" class="button signup" name="submit"><i class="fa-solid fa-chevron-right"></i></button>
</form>