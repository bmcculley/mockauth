var contentType ="application/x-www-form-urlencoded; charset=utf-8";

function customAlert(title, message, type) {
    $.notify({
        // options
        icon: 'glyphicon glyphicon-warning-sign',
        title: title,
        message: message
    },{
        // settings
        element: 'body',
        position: null,
        type: type,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: 'top',
            align: 'right'
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }
    });
};

function checkIsNull() {
    if ( $('[name="username"]').val() == '' || $('[name="password"]').val() == '' ){
        // username and password required
        customAlert('Info:', 'Username and Password required.', 'info');
    } else {
        console.log('login now!');
        //$('[name="loginform"]').submit();

        $.ajax({
            type : 'post',
            url : window.location.href + 'api.php',
            dataType : 'json',
            data: {
                username: $('#username').val(),
                password: $('#password').val()
            },
            contentType: contentType,
            success : function(data) {
                console.log(data.error);
                console.log(data.msg);
                if ( data.error ) {
                    // there was an error
                    customAlert('Error:', data.msg, 'danger');
                }
                else {
                    console.log('we are in!');
                    // okay
                    customAlert('Success:', data.msg, 'success');
                    // redirect to a successful page!
                    window.location.replace('./protected.php');
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                // something went terribly wrong
                customAlert('Error:', 'something went terribly wrong', 'danger');
            }
        });
    }
};

$(function(){
    console.log('Document ready');

    $('#username').focus();

    $('.login_input .un').on('click', function(e) {
        $('#username').focus();
    });

    $('.login_input .ps').on('click', function(e) {
        $('#password').focus();
    });

    $('[name="username"]').blur(function(){
        if ($(this).val()==""){
            // username required
            customAlert('Info:', 'Username required.', 'info');
            $(this).focus().select();
        }
    });

    $('[name="password"]').blur(function(){
        if ($(this).val()==""){
            // password is required
            customAlert('Info:', 'Password required.', 'info');
            $(this).focus().select();
        }
    });

    $('[name="submit"]').click(function(e){
        e.preventDefault();
        checkIsNull();
    });
});
