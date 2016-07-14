$(function() {

  var newPortfolio = $('.new-portfolio-data'),
      height = newPortfolio.height(),
      scrollHeight = newPortfolio.get(0).scrollHeight;

  newPortfolio.bind('mousewheel', function(e) {
    if(this.scrollTop > (scrollHeight - height) && ( e.originalEvent.detail > 0 || e.originalEvent.wheelDelta < 0 )) {
      e.preventDefault();
    }
  });

});