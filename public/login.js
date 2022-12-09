$(document).ready(function() {
    $('#btn_login').on('click', function() {
        if(checkLogin()){
            login();
        }
    })
})


/*


ang login same rag flow sa register ang login lng kay mag kuha gihapun sa gi input sa user
e check permi ang input ug empty ba o dili ug di empty mo proceed na siya sa ajax
dayon e pasa sa ajax ang mga values padung sa php


*/

const checkLogin = () => {
    if ($('#username').val() != '' && $('#password').val()) {
        return true
    } else {
        return false
    }
}

const login = () => {
    $.ajax({
        type: 'POST',
        url: 'src/router.php',
        data: {
            choice: 'login', username:$('#username').val(), password:$('#password').val()
        },
        success: function(params) {
            if(params == "200"){
                $(location).attr('href', './dashboard.html')
            }else{
                alert("Wrong parameters")
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError)
        }
    })
}