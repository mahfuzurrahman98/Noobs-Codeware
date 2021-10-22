$(document).ready(function() {
    $('[data-toggle="offcanvas"], #navToggle').on('click', function () {
        $('.offcanvas-collapse').toggleClass('open')
    }) 
    $(document).click(function () {
     // if($(".navbar-collapse").hasClass("in")){
       $('.navbar-collapse').collapse('hide');
     // }
  });
});