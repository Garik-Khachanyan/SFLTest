/**
 * Created by Garik on 10/15/2017.
 */

var descriptionInput = $('#description');
var seatInput = $('#number');
var editedDescription ;
var editedSeats ;



$('.addTable').on('click', function(e){
    e.preventDefault();
    $('#addModal').modal();
})


$(document).on('click','.editTable', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    editedDescription = $(this).parent().parent().find('.description');
    editedSeats = $(this).parent().parent().find('.seats');
    $('.add-table').attr('data-id', id);
    descriptionInput.val(editedDescription.text());
    seatInput.val(parseInt(editedSeats.text()));
    $('#addModal').modal();
})


$('.add-table').on('click', function(e){
    e.preventDefault();
    if(!validateInputs()){
        return false;
    }
    var data = {
        description:descriptionInput.val(),
        seats:seatInput.val()
    };
    var editTableId = $(this).attr('data-id');
    if(editTableId){
        data.tableId = $(this).attr('data-id');
    }
    $.ajax({
        url:'/table/save',
        type:'post',
        data:data,
        success:function(response){
            if(response.success){
             window.location.reload();
            }else{
                $('.error-message').text('Invalid data submitted');
            }

        }

    })
})
$(document).on('change','input',function(){
    $('.error-message').text('')
})


$(document).on('click','.deleteTable', function(e){
    e.preventDefault();
    $('.confirmDelete').attr('data-id',$(this).attr('data-id'))
    $('#deleteModal').modal();
})
$('.confirmDelete').on('click', function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
        url:'/table/delete',
        type:'post',
        data:{
            tableId:id
        },
        success:function(response){
            if(response.success){
                $('#'+id).remove();
                $('#deleteModal').modal('hide');
            }else{
                $(this).parent().parent().append('<span style="color:red">Invalid data submitted</span>')
            }

        }

    })
})

$(document).on('click', '.assignTable', function (e) {
    e.preventDefault(e);
    var tableId = $(this).attr('data-id');
    var userId = $(this).attr('data-userId')
    $.ajax({
        url:'/table/users',
        type:'GET',
        data:{
            tableId:tableId
        },
        success:function(response){
            if(response.success){
                var length = response.data.length;
                var data = response.data;
                var html = '';
                if(length > 0){
                    for (var i = 0; i < length; i++) {
                        var disabled = '';
                        if(data[i].userId == userId){
                            disabled = 'disabled';
                        }
                        html += '<div class="row" id="'+data[i].userId+'">' +
                            '<div class="col-sm-3">'+data[i].userName+'</div>' +
                            '<div class="col-sm-3"><button class="btn btn-success assign" data-id="'+tableId+'"'+disabled+'>Assign Table</button></div>' +
                            '</div><hr>'
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
$(document).on('click','.assign', function(e){
    e.preventDefault();
    var tableId =  $(this).attr('data-id');
    var userId = $(this).parent().parent().attr('id');
    $.ajax({
        url:'/table/assign',
        data:{
            tableId:tableId,
            userId:userId
        },
        type:'post',
        success:function(response){
            if(response.success){
                window.location.reload();
            }
        }
    })

})


function resetInputs(){
    descriptionInput.val('');
    seatInput.val('');
    $('.error-message').text('')
    $('.add-table').attr('data-id', '');
}
function render(response){
    var html = '<div class="row" id="'+response.data.tableId+'">'
        +'<div class="col-sm-4 description">'+response.data.description+'</div>'
        +'<div class="col-sm-4 seats">'+response.data.seats+'</div>'
        +'<div class="col-sm-4">'
        +'<a class="btn btn-primary editTable" data-id="'+response.data.tableId+'"> Edit</a>'
        +'<a class="btn btn-danger deleteTable" data-id="'+response.data.tableId+'"> Delete</a>'
        +'</div>'
        +'</div>'
        +'<hr>';
    $('.tables').append(html);
}
function validateInputs() {
    if (descriptionInput.val() && descriptionInput.val().trim() == '') {
        descriptionInput.css('border', '1px solid red');
        return false;
    }
    if (seatInput.val() && seatInput.val().trim() == '') {
        seatInput.css('border', '1px solid red')
        return false;
    }
    return true;
}