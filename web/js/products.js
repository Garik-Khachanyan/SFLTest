/**
 * Created by Garik on 10/15/2017.
 */

var descriptionInput = $('#description');
var priceInput = $('#price');
var nameInput = $('#name');
var timeInput = $('#cookingTime');
var editedProductDescription ;
var editedPrice ;
var editedName ;
var editedTime ;



$('.addProduct').on('click', function(e){
    e.preventDefault();
    $('#addProductModal').modal();
})


$(document).on('click','.editProduct', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-id');


    editedProductDescription = $(this).parent().parent().find('.productDescription');
    editedPrice = $(this).parent().parent().find('.price');
    editedName = $(this).parent().parent().find('.productName');
    editedTime = $(this).parent().parent().find('.time');

    $('.add-product').attr('data-id', id);

    descriptionInput.val(editedProductDescription.text());
    nameInput.val(editedName.text());
    priceInput.val(parseInt(editedPrice.text()));
    timeInput.val(parseInt(editedTime.text()));
    $('#addProductModal').modal();
})


$('.add-product').on('click', function(e){
    e.preventDefault();
    if(!validateInputs()){
        return false;
    }
    var data = {
        description:descriptionInput.val(),
        name:nameInput.val(),
        price:priceInput.val(),
        cookingTime:timeInput.val()
    };
    var editProductId = $(this).attr('data-id');
    if(editProductId){
        data.productId = $(this).attr('data-id');
    }
    $.ajax({
        url:'/product/save',
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


$(document).on('click','.deleteProduct', function(e){
    e.preventDefault();
    $('.confirmProductDelete').attr('data-id',$(this).attr('data-id'))
    $('#deleteProductModal').modal();
})
$('.confirmProductDelete').on('click', function(e){
    e.preventDefault();
    var id = $(this).attr('data-id');
    $.ajax({
        url:'/product/delete',
        type:'post',
        data:{
            productId:id
        },
        success:function(response){
            if(response.success){
                $('#'+id).remove();
                $('#deleteProductModal').modal('hide');
            }else{
                $(this).parent().parent().append('<span style="color:red">Invalid data submitted</span>')
            }

        }

    })
})



function resetInputs(){
    descriptionInput.val('');
    priceInput.val('');
    nameInput.val('');
    timeInput.val('');
    $('.error-message').text('')
    $('.add-product').attr('data-id', '');
}
function render(response){
    var html = '<hr><div class="row" id="'+response.data.productId+'">'
        +'<div class="col-sm-3 productName">'+response.data.name+'</div>'
        +'<div class="col-sm-3 productDescription">'+response.data.description+'</div>'
        +'<div class="col-sm-1 price">'+response.data.price+'</div>'
        +'<div class="col-sm-2 time">'+response.data.cookingTime+'</div>'
        +'<div class="col-sm-2">'
        +'<a class="btn btn-primary editProduct" data-id="'+response.data.productId+'"> Edit</a>'
        +'<a class="btn btn-danger deleteProduct" data-id="'+response.data.productId+'"> Delete</a>'
        +'</div>'
        +'</div>'
        +'<hr>';
    $('.products').append(html);
}
function validateInputs() {
    if (descriptionInput.val() && descriptionInput.val().trim() == '') {
        descriptionInput.css('border', '1px solid red');
        return false;
    }
    if (priceInput.val() && priceInput.val().trim() == '') {
        priceInput.css('border', '1px solid red')
        return false;
    }
    if (nameInput.val() && nameInput.val().trim() == '') {
        nameInput.css('border', '1px solid red')
        return false;
    }
    if (timeInput.val() && timeInput.val().trim() == '') {
        nameInput.css('border', '1px solid red')
        return false;
    }
    return true;
}