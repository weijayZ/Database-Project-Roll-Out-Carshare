$(document).ready(function(){

			$(window).scroll(function(){
				if($(window).scrollTop() > 105){
					$("header").addClass("topMenu");
				} else {
					$("header").removeClass("topMenu");
				}
			})
});
