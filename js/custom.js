//SCROLL TOP ON PAGE REFRESH
$(window).on('beforeunload', function() {
  $(window).scrollTop(0);
});

$(function () {

  // AOS ANIMATION
  AOS.init({
    disable: 'mobile',
    duration: 800,
    anchorPlacement: 'center-bottom'
  });


  // SMOOTHSCROLL NAVBAR
  $(function() {
    $('.navbar a, .hero-text a').on('click', function(event) {
      var $anchor = $(this);
      $('html, body').stop().animate({
          scrollTop: $($anchor.attr('href')).offset().top - 49
      }, 1000);
      event.preventDefault();
    });
  });    
});

// Search Bar AJAX
var xmlHttp;
function GetXmlHttpObject() {
xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer 
  try
    { xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); }
  catch (e)
    { xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  }
return xmlHttp;
}

function searchText(productsSearch){
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)  {
  alert ("Your browser does not support AJAX! Please try another one!");
  return;
}

if (productsSearch.length==0){ //empty search
  document.getElementById("searchResult").innerHTML="";
  return;}

var url="search.php";
  url=url+"?searchfield="+productsSearch;
  url=url+"&searchID="+Math.random(); //for caching
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged() {
if (xmlHttp.readyState==4){
  document.getElementById("searchResult").innerHTML=xmlHttp.responseText;
  }
}


// smooth scrolling
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});