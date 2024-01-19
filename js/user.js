function handleResize() {
  var windowWidth = window.innerWidth;

  if (windowWidth > 500) {
    window.onscroll = function () {
      StickyNav();
    };
  } else {
    window.onscroll = null;
  }
}

window.addEventListener('resize', handleResize);
handleResize();

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function StickyNav() {
  if (window.scrollY >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
