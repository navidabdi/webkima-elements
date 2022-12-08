(function webkimaElementsTriggerMobileMenu() {
  const mobileMenuIcon = document.getElementById("webkimael_mobile_menu_icon"),
    mobileMenuClose = document.getElementById(
      "webkimael_mobile_menu_dark_part",
    ),
    mobileMenuMain = document.getElementById("webkimael_mobile_menu_main");
  const showMobileMenu = () => mobileMenuMain.classList.toggle("active");
  mobileMenuIcon.addEventListener("click", showMobileMenu);
  mobileMenuClose.addEventListener("click", showMobileMenu);
})();
(function ShowSubMenu() {
  const menusWithSubMenu = document.querySelectorAll(
    ".menu-item-has-children a",
  );
  console.log(menusWithSubMenu);
  menusWithSubMenu.forEach((subMenu) => {
    subMenu.addEventListener("click", () => {
      subMenu.parentElement.classList.toggle("active");
    });
  });
})();
