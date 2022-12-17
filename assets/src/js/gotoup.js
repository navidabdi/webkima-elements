document.addEventListener('DOMContentLoaded', () => {
  (function () {
    let gotoup = document.getElementById("gotoup");
    window.onscroll = function () {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        gotoup.classList.add("active");
      } else {
        gotoup.classList.remove("active");
      }
    }
    gotoup.addEventListener("click", (() => {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }));
  })();
})
