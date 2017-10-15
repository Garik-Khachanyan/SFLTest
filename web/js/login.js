/**
 * Created by Garik on 10/15/2017.
 */
$('#login-btn').on('click', function(e){
    e.preventDefault();
    var username = $(this).parent().find('input[name=userName]');
    var password = $(this).parent().find('input[name=password]');
    if(username.val().trim() == ''){
        username.css('border','1px solid red');
        return false;
    }
    if(password.val().trim() == ''){
        password.css('border','1px solid red');
        return false;
    }
    $.ajax({
        url:'/login/login',
        data:{
            userName:username.val(),
            password:password.val()
        },
        type:'post',
        success:function(response){
            if(response.success){
                var userType = response.userType;
                if(userType == 'manager'){
                    window.location.href = '/manager'
                }else{
                    window.location.href = '/waiter'
                }
            }else{
                username.parent().parent().append('<span style="color:red">Invalid data submitted</span>')
            }

        }
    })
})