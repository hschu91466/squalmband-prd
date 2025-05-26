$(document).ready(function () {
  // More Video button
  $(".more-videos").click(function () {
    $("#more-videos").toggleClass("hide");
  });

  // Cache header height for scroll offset
  let headerHeight = $(".main-banner").outerHeight();

  function adjustSectionHeight() {
    headerHeight = $(".main-banner").outerHeight(); // Update cached header height on resize
    document.documentElement.style.setProperty(
      "--main-banner-height",
      `${headerHeight}px`
    );
  }

  // Adjust section height on page load
  adjustSectionHeight();

  // Adjust section height on window resize
  $(window).resize(adjustSectionHeight);

  // Smooth scroll with offset for header height
  $(".nav-links ul a.a-link").on("click", function (e) {
    e.preventDefault();
    const href = $(this).attr("href");
    const offsetTop = $(href).offset().top - headerHeight;
    $("html, body").animate({ scrollTop: offsetTop }, 200); // Reduced scroll duration

    // Remove 'active' class from all links and add to the clicked link
    $(".nav-links ul a.a-link").removeClass("active");
    $(this).addClass("active");
  });

  // Hamburger menu toggle (using pure JS for performance)
  const hamburger = document.querySelector(".hamburger");
  const navMenu = document.querySelector(".nav-menu");

  hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
  });
  // Add 'active' class to the current page link
  const currentPage = window.location.hash.substring(1);
  if (currentPage) {
    const activeLink = document.querySelector(
      `.nav-links ul a[data-page="${currentPage}"]`
    );
    if (activeLink) {
      document
        .querySelectorAll(".nav-links ul a")
        .forEach((link) => link.classList.remove("active"));
      activeLink.classList.add("active");
    }
  }
  function showSendingMessage() {
    document.getElementById("sendingMessage").style.display = "block";
  }
});
