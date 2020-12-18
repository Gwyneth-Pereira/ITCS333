//SCROLL TOP ON PAGE REFRESH
$(window).on('beforeunload', function() {
    $(window).scrollTop(0);
});

// $(function () {

// 	// AOS ANIMATION
// 	AOS.init({
// 	  disable: 'mobile',
// 	  duration: 800,
// 	  anchorPlacement: 'center-bottom'
// 	});


// 	// SMOOTHSCROLL NAVBAR
// 	$(function() {
// 	  $('.navbar a, .hero-text a').on('click', function(event) {
// 	    var $anchor = $(this);
// 	    $('html, body').stop().animate({
// 	        scrollTop: $($anchor.attr('href')).offset().top - 49
// 	    }, 1000);
// 	    event.preventDefault();
// 	  });
// 	});    
// });

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

    document.getElementById("searchResult").innerHTML="hi";
	
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