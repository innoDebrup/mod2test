$(document).ready(function() {
  let count = 2;
  const $nav = $(".nav"),
    $searchIcon = $("#searchIcon"),
    $navOpenBtn = $(".navOpenBtn"),
    $navCloseBtn = $(".navCloseBtn");

    $searchIcon.click(function() {
      $nav.toggleClass("openSearch");
      $nav.removeClass("openNav");
      if ($nav.hasClass("openSearch")) {
        $searchIcon.removeClass("uil-search");
        $searchIcon.addClass("uil-times cross");
      } else {
        $searchIcon.removeClass("uil-times cross");
        $searchIcon.addClass("uil-search");
      }
    });
    
    $navOpenBtn.click(function() {
      $nav.addClass("openNav");
      $nav.removeClass("openSearch");
      $searchIcon.removeClass("uil-times");
      $searchIcon.addClass("uil-search");
    });
    
    $navCloseBtn.click(function() {
      $nav.removeClass("openNav");
    });
  
});
