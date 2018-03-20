$(document).ready(function(){

			$(window).scroll(function(){
				if($(window).scrollTop() > 105){
					$("nav").addClass("topMenu");
				} else {
					$("nav").removeClass("topMenu");
				}
			})
});
