// Function to open the navigation sidebar by setting its width to 350px
function openNav() {
  document.getElementById("mySidenav").style.width = "350px";
}

// Function to close the navigation sidebar by setting its width to 0
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

// Runs when the document is fully loaded
$(document).ready(function() {
  // Check if the device is not a mobile device by testing the user agent
  if (!(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
    
    // When a card element is clicked, add the 'zoomed' class and display the overlay
    $('.card').on('click', function() {
      $(this).addClass('zoomed');
      $('#overlay').show();
    });

    // Prevent canvas clicks inside the card from propagating to the card click event
    $('.card canvas').on('click', function(event) {
      event.stopPropagation();
    });

    // When the overlay is clicked, remove the 'zoomed' class from the card and hide the overlay
    $('#overlay').on('click', function() {
      $('.zoomed').removeClass('zoomed');
      $(this).hide();
    });

    // Listen for the 'Escape' key to close any zoomed card and hide the overlay
    $(document).on('keyup', function(event) {
      if (event.keyCode === 27) { // 27 is the key code for the escape key
        $('.zoomed').removeClass('zoomed');
        $('#overlay').hide();
      }
    });
  }
});
