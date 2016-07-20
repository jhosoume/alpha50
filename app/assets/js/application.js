$(function() {
  $('.modal-trigger').leanModal();
  $('.trigger-side-nav').sideNav();
  $('.parallax').parallax();
  setDimensions();


  $(window).on('resize', function() {
    setDimensions();
  })

  function setDimensions() {
    var wh = $(window).height(),
        aboutUsHeight = wh - $("nav.top-nav").height();
        blurbHeight = aboutUsHeight * 0.5;
        aboutUsPadTop = (aboutUsHeight - blurbHeight)/2;
        blurbPad = blurbHeight * 0.2;
    $("#about-us-section").css("height", aboutUsHeight + "px").css('padding-top', aboutUsPadTop +'px');
    $(".about-us-blurb").css("height", blurbHeight + "px").css('padding-top', blurbPad + 'px');
  }
})