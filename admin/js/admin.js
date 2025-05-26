$(document).ready(function () {
  $("#addVideo").on("click", function () {
    $("#newVideo").removeClass("hide");
  });

  let video =
    'To add a new video to the site, go to <a href="https: //www.youtube.com/@squalm6846/videos">https://www.youtube.com/@squalm6846/videos</a>. Click on the video. From the url, select only the text after the equal sign. Example: https://www.youtube.com/watch?v=<span style="background:yellow">1ttZ2kqsOeI</span> and paste into the Embed Code box below.';

  let stream =
    'To add a new music stream to the site, go to <a href="https://open.spotify.com/">https://open.spotify.com/</a>. Click on the icon from the left sidebar. From the url, select only the text after <b>https://open.spotify.com/</b>. Example: https://open.spotify.com/<span style="background:yellow">artist/2cMMWuinHbQs0Bf1RTVNgH</span> and paste into the Embed Code box below.';

  $(".featured").click(function () {
    if ($(this).val() == "stream") {
      document.getElementById("instructions").innerHTML = stream;
    } else {
      document.getElementById("instructions").innerHTML = video;
    }
  });

  $("#video-instructions").hide();
  $("#image-instructions").show();

  $(".media_type").click(function () {
    if ($(this).val() == "image") {
      $("#video-instructions").hide();
      $("#image-instructions").show();
    } else {
      $("#video-instructions").show();
      $("#image-instructions").hide();
    }
  });

  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".nav-menu");

  hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
  });
});
