$(document).ready(function(){
    $('#btn_reg').on('click', function () {
        if(validityChecker()){
            registerRequest();
        }
    });

});

/**
 * 
 * 
 * kaning register usually wala kay niy error diri kay mo kuha raman ni siyag unsa imong gi input dayun e upload sa database
 * same ra ug flow e check ang input ug empty ba o dili 
 * ug di empty mo proceed gihapon sa ajax
 * 
 * 
 * 
 * 
 * 
 */

const registerRequest = () => {

    $.ajax({
        type: 'POST',
        url: 'src/router.php',
        data: {
            choice: 'register', username: $('#username').val(), email: $('#email').val(), number: $('#number').val(), password: $('#password').val()
        },
        success: function(data){
            if (data == "200") {
                alert('Registration Successful\nLOGIN NOW!')
                $('#username').val('')
                $('#email').val('')
                $('#number').val('')
                $('#password').val('')
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            console.log(thrownError)
        }
    })

}




var validityChecker = () => {
    var flag = false
    var count = 4;
    // Password
    if ($('#username').val() == '') {
        count -= 1;
    }
    
    if ($('#email').val() == '') {
        count -= 1
    }

    // Fullname
    if ($('#number').val() == '') {
        count -= 1
    }
    
    // Username
    var numb = parseInt($('#password').val())
    if ($('#password').val() == '' || numb == NaN) {
        count -= 1
    }
    
    if(count == 4){
        flag = true
    }
    
    return flag;
}
