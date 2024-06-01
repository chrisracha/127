function openNav() {
  document.getElementById("mySidenav").style.width = "350px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

$(document).ready(function() {
  if(!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
    $('.card').on('click', function() {
      $(this).addClass('zoomed');
      $('#overlay').show();
    });

    $('.card canvas').on('click', function(event) {
      event.stopPropagation();
    });

    $('#overlay').on('click', function() {
      $('.zoomed').removeClass('zoomed');
      $(this).hide();
    });
  }
});