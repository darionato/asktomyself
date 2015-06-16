$(document).ready(function(){

    // function to add a share categories
    $(".et_table .et_add_share").live('click', function(){

        // change the image with progress
        $(this).css('background-image', 'url(images/loader.gif)');

        // get the id of current category
        var the_row = $(this).closest("tr");
        var the_id = the_row.children(".col_id_category").children("span").html();

        // prepare the post
        var dataPOST = "ope=3&id_category=" + the_id;

        $.ajax({
            type: "POST",
            url: "include/category_details.php",
            async: true,
            data: dataPOST,
                success: function(msg){
                    if (msg == '1')
                        animateDeleteRow(the_row);


                }
        });

    });

    // function to see the details
    $(".et_table .et_details_row").live('click', function(){

        // get the id of current category
        var the_row = $(this).closest("tr");
        var the_id = the_row.children(".col_id_category").children("span").html();

        // prepare the post
        var dataPOST = "ope=1&id_category=" + the_id;

        $.ajax({
            type: "POST",
            url: "include/category_details.php",
            async: true,
            data: dataPOST,
                success: function(msg){
                    if (msg != '0')
                        showModal(msg);
                }
        });

    });

    function showModal(values)
    {

        // show buttons
        $('#close_dialog').show();
        $('#save_dialog').show();
        $('.show_hide_loader').hide();

        //Get the A tag
        var id = '#dialog';

        // clean up dialog
        $(id).children().each(function (){
            $(this).children().each(function (){
                switch ($(this).attr('class'))
                {
                    case 'gradient_text':
                        $(this).val('');
                        break;
                    case 'gradient_combo':
                        $(this).val('0');
                        break;
                }
            });
        });

        

        // prepare the values
        var arrMatch = null;
        var rePattern = new RegExp(/\(([\w]+)=\[([\d\wòàéáéíóäëiöúàèìù ?,.;&'\€\/\*\+\-\$\£\%\(\)]+)\]/gi);

        while ((arrMatch = rePattern.exec(values)) != null){

            if (arrMatch[1].toString() == 'id_category')
                $("#id_category").val(arrMatch[2].toString());
            else if (arrMatch[1].toString() == 'desc')
                // set the category name
                $("#name_category").html(arrMatch[2].toString());
            else
            {
                var ctr = $('#' + decodeURIComponent(arrMatch[1].toString()));

                if (ctr != undefined)
                {
                    switch (ctr.attr('class'))
                    {
                        case 'gradient_text':
                            ctr.val(decodeURIComponent(arrMatch[2].toString()));
                            break;
                        case 'gradient_combo':
                            ctr.val(decodeURIComponent(arrMatch[2].toString()));
                            break;
                    }
                }
            }
        }

        

        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        //Set height and width to mask to fill up the whole screen
        $('#mask_modal_dialog').css({'width':maskWidth,'height':maskHeight});

        //transition effect
        $('#mask_modal_dialog').fadeIn(1000);
        $('#mask_modal_dialog').fadeTo("slow",0.6);

        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        $(id).css('top',  winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);

        //transition effect
        $(id).fadeIn(2000);

    }

    //if close button is clicked
    $('#close_dialog').click(function() {
        $('#mask_modal_dialog, .window').hide();
    });

    //if save button is clicked
    $('#save_dialog').click(function() {
        $(this).hide();
        $('#close_dialog').hide();
        $('.show_hide_loader').show();
        SaveDialog();
    });

    // function save dialog
    function SaveDialog()
    {

        var the_id = $("#id_category").val();

        if (the_id == '' || the_id == '0') return 0;

        // prepare the post
        var dataPOST = "ope=2&id_category=" + the_id;

        // clean up dialog
        $('#dialog').children().each(function (){
            $(this).children().each(function (){

                var val = "null";

                switch ($(this).attr('class'))
                {
                    case 'gradient_text':
                        if ($(this).val() != '')
                            val = '"' + encodeURIComponent($(this).val()) + '"';
                        break;
                    case 'gradient_combo':
                        if ($(this).val() != '0' && $(this).val() != '')
                            val = '"' + encodeURIComponent($(this).val()) + '"';
                        break;
                    default:
                        val = '';
                        break;
                }

                if (val != '')
                    dataPOST += '&col_' + $(this).attr('id') + '=' + val;

            });
        });

        $.ajax({
            type: "POST",
            url: "include/category_details.php",
            async: true,
            data: dataPOST,
                success: function(msg){
                    $('#mask_modal_dialog, .window').hide();
                }
        });

        return 1;

    }

    // function to add the row with enter
    $(".et_table .gradient_text").live('keypress', function(event){

       if (event.keyCode == "13")
       {
           var the_base = $(this).closest("tr").find('.et_add_row').first();

            addNewRow(the_base);
       }

    });

    // function to add new row
    $(".et_table .et_add_row").live('click', function(){

        var the_base = $(this);

        addNewRow(the_base);

    });

    function addNewRow(the_base)
    {

        // get the current row
        var therow = the_base.closest("tr");

        // get table name
        var tb = therow.closest("table");
        var tbname = tb[0].id;

        // create the POST
        var dataPOST = "table=" + tbname;

        // customs things
        if (tbname == 'askme_words')
        {
            dataPOST += '&col_id_category=' + $('#myarea_categories').val();
            dataPOST += '&addiduser=0';
        }

        // check each column
        var exit = false;
        therow.children("td").each(function() {

            // get the col value
            var et_t = $(this).children();

            switch (et_t.attr('class'))
            {
                case 'gradient_text':
                    if (et_t.val().length == 0) exit = true;
                    dataPOST += '&' + this.className + '=' +
                    encodeURIComponent(et_t.val());
                    break;
                case 'et_check':
                    dataPOST += '&' + this.className + '=' +
                    encodeURIComponent(et_t.is(':checked')?'1':'0');
                    break;
            }

        });

        // if at least one field is empty i exit
        if (exit) return 0;

        // change the image with progress
        the_base.css('background-image', 'url(images/loader.gif)');

        // add the row in async
        $.ajax({
            type: "POST",
            url: "include/edittable_add.php",
            async: true,
            data: dataPOST,
                success: function(msg){

                // insert the new row
                var newvalue = "";
                
                var arrMatch = null;
                var rePattern = new RegExp(/\[([\d\wòàéáéíóäëiöúàèìù ?,.;&'\€\/\*\+\-\$\£\%\(\)]+)\]/gi);
                var ret = new Array();
                var x = 0;
        
                while ((arrMatch = rePattern.exec(msg)) != null){
                    ret[x++] = arrMatch[1].toString();
                }
                

                if (tbname == 'askme_words')
                {
                    newvalue =
                    "<tr>" +
                        "<td class=\"col_id_word\"><span>" + ret[0] + "</span></td>" +
                        "<td class=\"col_from\"><input type=\"text\" value=\"" + ret[2] + "\" class=\"et_text\"></td>" +
                        "<td class=\"col_to\"><input type=\"text\" value=\"" + ret[3] + "\" class=\"et_text\"></td>" +
                        "<td><a href=\"#\" class=\"et_del_row\"><span>del</span></a></td>" +
                        "<td><a href=\"#\" class=\"et_save_row\"><span>save</span></a></td>" +
                    "</tr>";

                }
                else if (tbname == 'askme_categories')
                {
                    newvalue =
                    "<tr>" +
                        "<td class=\"col_id_category\"><span>" + ret[0] + "</span></td>" +
                        "<td class=\"col_desc\"><input type=\"text\" value=\"" + ret[2] + "\" class=\"et_text\"></td>" +
                        "<td class=\"col_shared\"><input type=\"checkbox\" class=\"et_check\"" + (ret[3]=='1'?' checked ':'') + "></td>" +
                        "<td><a href=\"#\" class=\"et_del_row\"><span>del</span></a></td>" +
                        "<td><a href=\"#\" class=\"et_save_row\"><span>save</span></a></td>" +
                        "<td><a href=\"#\" class=\"et_details_row\"><span>det</span></a></td>" +
                    "</tr>"
                }

                //add the row
                
                var tb = therow.closest("table");
                tb.first().append(newvalue);


                // clear the text box and put the focus
                var put_focus = false;
                therow.children("td").each(function() {

                    // get the col value
                    var et_t = $(this).children();
                    switch (et_t.attr('class'))
                    {
                        case 'gradient_text':
                            et_t.val('');
                            if (put_focus == false)
                            {
                                et_t.focus();
                                put_focus = true;
                            }
                            break;
                        case 'et_check':
                            et_t.attr('checked', false);
                            break;
                    }


                });

                // change the image with disk
                the_base.css('background-image', 'url(images/grid_add.png)');
            }
         });

         return 0;
        
    }


    // function to save exists row
    $(".et_table .et_save_row").live('click', function(){

        var the_base = $(this);

        // change the image with progress
        the_base.css('background-image', 'url(images/loader.gif)');

        // get the current row
        var therow = $(this).closest("tr");

        // get table name
        var tb = therow.closest("table");
        var tbname = tb[0].id;

        // get the id of the row through the first column
        var idint = therow.find("td:first").children("span").html();
        var col = '';
        var iduser = 0;

        // convert the id to int
        try
        {
            // get id
            idint = parseInt(idint);
            // get the coll id name
            col = therow[0].cells[0].className.substr(4);
            // on setting i have to pass the id user too
            if (tbname == "askme_settings")
                iduser =
                    parseInt(
                        therow.children(".col_id_user").children("span").html());
        }
        catch(err)
        {
            idint = 0;
            col = err;
        }

        // if id, the del row
        if (idint > 0)
        {
            
            var dataPOST = "table=" + tbname + "&col=" + col + "&id=" + idint;

            if (iduser != 0)
                dataPOST += "&iduser=" + iduser;

            therow.children("td").each(function() {

                var thecol = $(this);
                var regexp = (this.className.substring(0,11)=='col_regexp_'?thecol.text():'');

                if (regexp.length > 0)
                {
                    // if is a column with a regular expression, add it for check
                    dataPOST += '&' + this.className.substring(4) + '=' + regexp;
                }
                else
                {
                    // get the col value
                    var et_t = thecol.children('input.et_text').val();
                    if (et_t != undefined)
                    {
                        dataPOST += '&' + this.className + '=' + 
                            encodeURIComponent(et_t);
                    }
                    else
                    {
                        var et_c = thecol.children('input.et_check');
                        if (et_c !== null && et_c.attr('type') == 'checkbox')
                        {
                            dataPOST += '&' + this.className + '=' + (et_c.is(':checked')?1:0);
                        }
                    }
                }

            });

            // save row in async
            $.ajax({
                type: "POST",
                url: "include/edittable_save.php",
                async: true,
                data: dataPOST,
                    success: function(msg){

                    // change the image with disk
                    the_base.css('background-image', 'url(images/grid_save.png)');

                    // if no save, send a message
                    if (msg == "0")
                        alert("Invalid data, row not saved. Check the values and save again!");
                    
                }
             });

        }
        
    });

    // function to delete row
    $(".et_table .et_del_row").live('click', function(){

        var conf = confirm('Do you really want to delete the row?');

        // get the current row
        var therow = $(this).closest("tr");

        // get table name
        var tb = therow.closest("table");
        var tbname = tb[0].id;

        // get the id of the row through the first column
        var idint = therow.find("td:first").children("span").html();
        var col = '';

        // convert the id to int
        try
        {
            // get id
            idint = parseInt(idint);
            // get the coll id name
            col = therow[0].cells[0].className.substr(4);
        }
        catch(err)
        {
            idint = 0;
            col = err;
        }

        var dataPOST = "table=" + tbname + "&col=" + col + "&id=" + idint;

        if (tbname == 'askme_shared_categories')
            dataPOST += '&addiduser=1';

        // if id, the del row
        if (idint > 0 && conf != 0)
        {

            // del row in async
            $.ajax({
                type: "POST",
                url: "include/edittable_del.php",
                async: true,
                data: dataPOST,
                    success: function(msg){

                    animateDeleteRow(therow);
                }
             });

        }

    });

    function animateDeleteRow(therow)
    {

        var tempo = 500;

        therow.animate({'opacity': 0}, tempo, function() {
            therow.children("td").each(function() {
                $(this).wrapInner("<div></div>").children("div").slideUp(function() {
                    therow.hide();
                    therow.remove();
                });
            });
        });

    }

});
