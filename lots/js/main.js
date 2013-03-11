$(document).ready(function(){
						   
 $(window).resize(function(){

  $('.inner-content').css({
   position:'absolute',
   left: ($(window).width() 
     - $('.inner-content').outerWidth())/2,
   top: ($(window).height() 
     - $('.inner-content').outerHeight())/2
  });	
});
 
 // To initially run the function:
 $(window).resize();

});