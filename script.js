function openNav() {
  document.getElementById("mySidenav").style.width = "350px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

$(document).ready(function () {
  if (
    !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    $(".card").on("click", function () {
      $(this).addClass("zoomed");
      $("#overlay").show();
    });

    $(".card canvas").on("click", function (event) {
      event.stopPropagation();
    });

    $("#overlay").on("click", function () {
      $(".zoomed").removeClass("zoomed");
      $(this).hide();
    });

    $(document).on("keyup", function (event) {
      if (event.keyCode === 27) {
        // 27 is the key code for the escape key
        $(".zoomed").removeClass("zoomed");
        $("#overlay").hide();
      }
    });
  }
});
