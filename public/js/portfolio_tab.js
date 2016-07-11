$(function() {

  renderPortfolioSection();

  var routes = [
    "#overview-tab",
    "#all-stocks-tab",
    "#analysis-tab",
    "#comparison-tab",
    "#trades-tab"    
  ];

  $('.portfolio-nav').on('click','a', function(e) {
    if ($(this).closest('li').hasClass('active')) {
      e.preventDefault();
      return false;
    };
  })

  $(window).on('hashchange', function (event) {
    if (routes.includes(location.hash) && !$(location.hash).hasClass('active')) 
      renderPortfolioSection();
    return false;
  });

})

function renderPortfolioSection() {
  if (location.hash !== "") $(location.hash).siblings().removeClass('active');
  var preloader = $("#preloader").html();
  $("div.portfolio-content").append(preloader);
  setTimeout(function() {
    $('.preloader-wrapper').remove();
    if (location.hash == "") $('#overview-tab, li:has(a[href="#overview-tab"])').addClass('active');
    // if (location.hash !== "") $(location.hash).addClass('active') ;
    $(location.hash).addClass('active');
    $('[href="' + location.hash + '"]').closest('li').addClass('active').siblings().removeClass('active');
  }, 500);
};