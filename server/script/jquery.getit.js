$(document).ready(function(){

    $('.download_btn').click(function()
    {

        var os = this.id;

        var dataPOST = "os=" + os;

        $.ajax({
            type: "POST",
            url: "modules/getit_download_json.php",
            async: true,
            data: dataPOST,
                success: function(msg){

                var p = msg.split(":",2);

                $('.download_btn span').text('Download: ' + p[0]);

                window.location = p[1];
            }
        });

    });

});