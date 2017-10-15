/**
 * Created by Garik on 10/15/2017.
 */
/**
 * Created by Garik on 10/15/2017.
 */

var userNameInput = $('#userName');
var passwordInput = $('#password');
var confirmPasswordInput = $('#confirmPassword');
var editedUserName ;
var editedpassword ;



$('.addUser').on('click', function(e){
    e.preventDefault();
    $('#addUserModal').modal();
})


$(document).on('click','.editUser', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    editedUserName = $(this).parent().parent().find('.userName');

    $('.add-user').attr('data-id', id);
    userNameInput.val(editedUserName.text());
    $('#addUserModal').modal();
})


$('.add-user').on('click', function(e){
    e.preventDefault();
    if(!validateInputs()){
        return false;
    }
    var data = {
        userName:userNameInput.val(),
    };
    var editTableId = $(this).attr('data-id');
    if(editTableId){
        data.userId = $(this).attr('data-id');
    }
    if(!checkPasswords()){
        return false;
    }
    if(passwordInput.val().trim() != ''){
        data.password = passwordInput.val();
    }
    $.ajax({
        url:'/user/save',
        type:'post',
        data:data,
        success:function(response){
            if(response.success){
                if(editTableId){
                    editedUserName.text(response.data.userName)
                }else{
                    render(response);
                }
                resetInputs();
                $('#addUserModal').modal('hide');
            }else{
                $('.error-message').text('Invalid data submitted');
            }

        }

    })
})
$(document).on('change','input',function(){
    $('.error-message').text('')
})


$(document).on('click','.deleteUser', function(e){
    e.preventDefault();
    $('.confirmUserDelete').attr('data-id',$(this).attr('data-id'))
    $('#deleteuserModal').modal();
})
$('.confirmUserDelete').on('click', function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
        url:'/users/delete',
        type:'post',
        data:{
            userId:id
        },
        success:function(response){
            if(response.success){
                $('#'+id).remove();
                $('#deleteUserModal').modal('hide');
            }else{
                $(this).parent().parent().append('<span style="color:red">Invalid data submitted</span>')
            }

        }

    })
})
$(document).on('click', '.viewTables', function (e) {
    e.preventDefault(e);
    var userId = $(this).attr('data-id')
    $.ajax({
        url:'/user/tables',
        type:'GET',
        data:{
            userId:userId
        },
        success:function(response){
            if(response.success){
                var length = response.data.length;
                var data = response.data;
                var html = '';
                if(length > 0){
                    for (var i = 0; i < length; i++) {
                        html += '<div class="row" id="'+data[i].tableId+'">' +
                            '<div class="col-sm-3">'+data[i].tableDescription+'</div>' +
                            '<div class="col-sm-3">'+data[i].seats+'</div>' +
                            '<div class="col-sm-3"><button class="btn btn-danger removeTable">Unset Table</button></div>' +
                            '</div>'
                    }
                }else{
                    html = "<span>No Data Found </span>"
                }

                $('#userTables').html(html)
                $('#assignedTables').modal();
            }
        }

    })
})


function checkPasswords(){
    return !(passwordInput.val() != confirmPasswordInput.val() && (passwordInput.val().trim != '' || confirmPasswordInput.val().trim() != ''));

}
function resetInputs(){
    userNameInput.val('');
    passwordInput.val('');
    confirmPasswordInput.val('');
    $('.error-message').text('')
    $('.add-user').attr('data-id', '');
}
function render(response){
    var html = '<div class="row" id="'+response.data.userId+'">'
        +'<div class="col-sm-4 userName">'+response.data.userName+'</div>'
        +'<div class="col-sm-4 assignedTables">0</div>'
        +'<div class="col-sm-4">'
        +'<a class="btn btn-primary editUser" data-id="'+response.data.userId+'"> Edit</a>'
        +'<a class="btn btn-danger deleteUser" data-id="'+response.data.userId+'"> Delete</a>'
        +'</div>'
        +'</div>'
        +'<hr>';
    $('.users').append(html);
}
function validateInputs() {
    if (userNameInput.val() && userNameInput.val().trim() == '') {
        descriptionInput.css('border', '1px solid red');
        return false;
    }

    return true;
}