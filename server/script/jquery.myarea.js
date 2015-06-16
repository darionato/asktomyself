$(document).ready(function(){
    
    // manage the menu
    $("ul.myarea_menu li:even").addClass("alt");

    $('img.myarea_head').click(function () {
        $('ul.myarea_menu').slideToggle('medium');
    });

    $('ul.myarea_menu li a').mouseover(function () {
        $(this).animate({paddingLeft: "20px"}, 50 );
    });

    $('ul.myarea_menu li a').mouseout(function () {
        $(this).animate({paddingLeft: "10px"}, 50 );
    });

    // search with enter
    $("#search_string").keypress(function(event){

       if (event.keyCode == "13")
       {
           searchCategory();
       }

    });

    // manage search area
    $('#search_categories').click(function() {

        searchCategory();

    });

    // search function
    function searchCategory()
    {

        $('#myarea_word_progress').show();
        $('#search_categories').hide();

        // add the search value
        var dataPOST = "searchstring=" +
            encodeURIComponent($("#search_string").val());

        // add the category
        dataPOST += "&kindcategoy=" + $("#id_kind_category").val();

        $.ajax({
            type: "POST",
            url: "modules/myarea_search_json.php",
            async: true,
            data: dataPOST,
                success: function(msg){

                if (msg.length == 0 || msg.search(/<tr>/i) == -1)
                    msg = "No categories found";

                $('#search_result').html(msg);
                $('#myarea_word_progress').hide();
                $('#search_categories').show();
            }
        });

    }

    // manage words area
    $('#myarea_categories').change(function() {

        $('#myarea_word_progress').show();

        var dataPOST = "categoryid=" + this.value;

        $.ajax({
            type: "POST",
            url: "modules/myarea_words_json.php",
            async: true,
            data: dataPOST,
                success: function(msg){

                $('#myarea_words').html(msg);
                $('#myarea_word_progress').hide();
            }
        });

    });

    $('#myare_btn_save_user').click(function (){

        // check if the nickname is ok
        if (checkNickname($("input[name=nickname]").val()) == false)
        {
            alert("Nickname must be in lower case and it's accepted only letters, number, dots, underscore without spaces.");
            $("input[name=nickname]").focus();
            return 0;
        }

        $('#myarea_word_progress').show();

        var dataPOST = "";

        // get all values
        $('.gradient_text, .gradient_combo').each(function(){
            
            if (dataPOST.length > 0)
                dataPOST += '&';

           dataPOST += $(this).attr('name') + '=' +
               $(this).val();

        });

        

       $.ajax({
            type: "POST",
            url: "modules/myarea_account_json.php",
            async: true,
            data: dataPOST,
                success: function(msg){

                if (msg != "202")
                    alert(msg);

                $('#myarea_word_progress').hide();
            }
        });

    });

    function checkNickname(nickname)
    {
        if (nickname.length == 0)
            return true;
        
        var patt1 = /^([a-z0-9._]+)$/g;
        return (nickname.match(patt1) != null);
    }

});
