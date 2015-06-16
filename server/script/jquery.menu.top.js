$(document).ready(function(){

    $('#id_tabs_login a')



	.css( {backgroundPosition: "0 2"} )



	.mouseover(function(){

            if (this.className.substr(this.className.length - 3, 3) != '_in')
            {

            $(this).stop().animate(
                    {backgroundPosition:"(0 -44px)"},
                    {duration:100})
            }
	})
		
	.mouseout(function(){
            if (this.className.substr(this.className.length - 3, 3) != '_in')
            {
            $(this).stop().animate(
                    {backgroundPosition:"(0 -4px)"},
                    {duration:400})
            }
	})

	
});
