$(function() {

    function processSignUp() {

        $('#btn_create_account').hide();
        $('#btn_create_account_div').css('height', '24px');
        $('#btn_create_account_div').css('width', '24px');
        $('#btn_create_account_div').css('background',
            'url(images/loader.gif) transparent center no-repeat');

    }

    $("#birthday_date").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1900:2010',
        dateFormat: 'yy-mm-dd',
        defaultDate: -7300
    });

    this.formValidator = function()
    {

        var n = $("input:checked").length;

        if (n == 0)
            alert('You must read and agree the Terms and Conditions!');

        var res = (n > 0);

        if (res)
            processSignUp();

        return res;

    }

});

