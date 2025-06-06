function csc(entry) {

   var data = new URLSearchParams(),
      xhr = new XMLHttpRequest();
   xhr.open("POST","option.php");

   if(entry == 1){
      data.append("segment","city");
      xhr.onload = function(){
         document.getElementById('sel-city').innerHTML = this.response;
         csc(2); //Load when change
      };
   }
   
   if(entry == 2){
      data.append("segment","street");
      data.append("cid", document.getElementById('sel-city').value);
      xhr.onload = function(){
         document.getElementById('sel-street').innerHTML = this.response;
         csc(3);
      };
   }

   if(entry == 3){
      data.append("segment","fee");
      data.append("cid", document.getElementById('sel-city').value);
      data.append("id", document.getElementById('sel-street').value);
      xhr.onload = function(){
         document.getElementById('show-fee').innerHTML = this.response;
      };
   }
   
   xhr.send(data);
}

window.addEventListener('load', function() {
   csc(1);

   document.getElementById('sel-city').addEventListener("change", function(){
      csc(2);
   });

   document.getElementById('sel-street').addEventListener("change", function(){
      csc(3);
   });
});

let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

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

let mainImage = document.querySelector('.quick-view .box .row .image-container .main-image img');
let subImages = document.querySelectorAll('.quick-view .box .row .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});

// document.querySelectorAll('input[type="number"]').forEach(inputNumber => {
//    inputNumber.oninput = () =>{
//       if(inputNumber.value.length > inputNumber.maxLength) inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
//    };
// });

function querySt(ji) {
   hu = window.location.search.substring(1);
   gy = hu.split("&");
   for (i=0;i<gy.length;i++) {
       ft = gy[i].split("=");
       if (ft[0] == ji) {
           return ft[1];
       }
   }
};

function selectedCheckbox(check){
	var checkboxes = document.getElementsByName('check[]');
	for(var i in checkboxes){
		checkboxes[i].checked = check.checked;
	}

	var count = document.querySelectorAll('input[name="check[]"]:checked').length;
	document.getElementById('count').innerHTML = count;
}

function countCheckbox(){
	var count = document.querySelectorAll('input[name="check[]"]:checked').length;
	document.getElementById('count').innerHTML = count;
}

$(document).ready(function(){

   $("#pass").keyup(function(){
   
   check_pass();
   check_matched();
   
   });

   $("#cpass").keyup(function(){
   
   check_matched();

   });
   
});

   function check_matched() {
      var pass = document.getElementById("pass").value;
      var cpass = document.getElementById("cpass").value;
      var text = document.getElementById("pass_confirm");
      
      if(cpass == 0){
         document.getElementById("pass_confirm").hidden;
      }else{
         if(pass != cpass){
            text.style.color="red";
            document.getElementById("pass_confirm").innerHTML="Password didn't match!";
         }else{
            text.style.color="green";
            document.getElementById("pass_confirm").innerHTML="Password matched";
         }
      }

   }

   
   function check_pass() {
    var val=document.getElementById("pass").value;
    var meter=document.getElementById("meter");
    var no=0;
    if(val!="")
    {
   // If the password length is less than or equal to 6
   if(val.length<=6)no=1;
   
    // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
     if(val.length>6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))no=2;
   
     // If the password length is greater than 6 and contain alphabet,number,special character respectively
     if(val.length>6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))no=3;
   
     // If the password length is greater than 6 and must contain alphabets,numbers and special characters
     if(val.length>6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))no=4;
   
     if(no==1)
     {
      $("#meter").animate({width:'25%'},300);
      meter.style.backgroundColor="gray";
      document.getElementById("pass_type").value="Too Short";
     }
   
     if(no==2)
     {
      $("#meter").animate({width:'50%'},300);
      meter.style.backgroundColor="red";
      document.getElementById("pass_type").value="Weak";
     }
   
     if(no==3)
     {
      $("#meter").animate({width:'75%'},300);
      meter.style.backgroundColor="orange";
      document.getElementById("pass_type").value="Good";
     }
   
     if(no==4)
     {
      $("#meter").animate({width:'100%'},300);
      meter.style.backgroundColor="green";
      document.getElementById("pass_type").value="Strong";
     }
    }
   
    else
    {
     meter.style.backgroundColor="";
     document.getElementById("pass_type").value="";
     document.getElementById("pass_type").setAttribute('type', 'hidden');
    }
   }

   if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
      }

// price range
(function ($) {
  
   $('#price-range-submit').hide();
 
    $("#min_price,#max_price").on('change', function () {
 
      $('#price-range-submit').show();
 
      var min_price_range = parseInt($("#min_price").val());
 
      var max_price_range = parseInt($("#max_price").val());
 
      if (min_price_range > max_price_range) {
       $('#max_price').val(min_price_range);
      }
 
      $("#slider-range").slider({
       values: [min_price_range, max_price_range]
      });
      
    });
 
 
    $("#min_price,#max_price").on("paste keyup", function () {                                        
 
      $('#price-range-submit').show();
 
      var min_price_range = parseInt($("#min_price").val());
 
      var max_price_range = parseInt($("#max_price").val());
      
      if(min_price_range == max_price_range){
 
          max_price_range = min_price_range + 100;
          
          $("#min_price").val(min_price_range);		
          $("#max_price").val(max_price_range);
      }
 
      $("#slider-range").slider({
       values: [min_price_range, max_price_range]
      });
 
    });
 
 })(jQuery);

