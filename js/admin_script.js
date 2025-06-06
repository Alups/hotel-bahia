(() => {
   'use strict'

   // Fetch all the forms we want to apply custom Bootstrap validation styles to
   const forms = document.querySelectorAll('.needs-validation')

   // Loop over them and prevent submission
   Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
         if (!form.checkValidity()) {
         event.preventDefault()
         event.stopPropagation()
         }

         form.classList.add('was-validated')
      }, false)
   })
   })()

let navbar = document.querySelector('.header .navbar');
let profile = document.querySelector('.header .profile');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

let mainImage = document.querySelector('.update-prod .image-container .main-image img');
let subImages = document.querySelectorAll('.update-prod .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});

var btn = document.querySelectorAll("button.btns");

// All page modals
var modals = document.querySelectorAll('.modal');

// Get the <span> element that closes the modal
var spans = document.getElementsByClassName("close");

// When the user clicks the button, open the modal
for (var i = 0; i < btn.length; i++) {
 btn[i].onclick = function(e) {
    e.preventDefault();
    modal = document.querySelector(e.target.getAttribute("href"));
    modal.style.display = "block";
 }
}

// When the user clicks on <span> (x), close the modal
for (var i = 0; i < spans.length; i++) {
 spans[i].onclick = function() {
    for (var index in modals) {
      if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
    }
 }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
     for (var index in modals) {
      if (typeof modals[index].style !== 'undefined') modals[index].style.display = "none";    
     }
    }
}


$(document).ready(function () {
  // Initialize the date range picker
  $('#date-range').daterangepicker({
    opens: 'left', // You can change the position of the date picker popup if needed.
    autoUpdateInput: false, // Prevent the input field from being updated automatically
    locale: {
      cancelLabel: 'Clear', // Change the cancel button label to "Clear"
    },
  });

  // When a date range is selected, update the input field with the chosen date range
  $('#date-range').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
  });

  // When the "Clear" button is clicked, clear the input field
  $('#date-range').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
  });
});
