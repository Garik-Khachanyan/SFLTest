var products = [];
$(document).ready(function(){
    if(window.location.href.indexOf("/waiter") > -1) {

        $.ajax({
            url: '/waiter/products',
            type: 'GET',
            success: function (respone) {
                if (respone.success) {
                    products = respone.data;
                }
            }
        })
    }
})
var selectedProducts = {};
$(document).on('click', '.createOrder', function (e) {
    e.preventDefault(e);
    var tableId = $(this).attr('data-id');

    var html = renderProducts(tableId);
    $('.saveOrder').attr('data-id',tableId);
    $('#userTables').html(html)
    $('#createOrder').modal();

})
$(document).on('click','.addProduct', function(e){
    e.preventDefault();
    var productId = $(this).parent().parent().attr('id');
    selectedProducts[productId] = 'selected';
    $(this).attr('disabled',true);
})
$('.saveOrder').on('click', function(e){
    e.preventDefault();
    var tableId = $(this).attr('data-id');
    $.ajax({
        url:'/waiter/order',
        type:'post',
        data:{
            tableId:tableId,
            products:selectedProducts
        },
        success:function(response){
            if(response.success){
                window.location.reload();
            }
        }
    })

})
function renderProducts (tableId){
    var length = products.length;
    if(length > 0){
        var html = '<div class="row">' +
            '<div class="col-sm-2">Name</div>' +
            '<div class="col-sm-3">Description</div>' +
            '<div class="col-sm-2">Price</div>' +
            '<div class="col-sm-2">Time</div>' +
            '<div class="col-sm-2">Action</div>' +
            '</div><hr>';

        for (var i = 0; i < length; i++) {
            html += '<div class="row" id="'+products[i].productId+'">' +
                '<div class="col-sm-2">'+products[i].name+'</div>' +
                '<div class="col-sm-3">'+products[i].description+'</div>' +
                '<div class="col-sm-2">$ '+products[i].price+'</div>' +
                '<div class="col-sm-2">'+products[i].cookingTime+' Min.</div>' +
                '<div class="col-sm-3"><button class="btn btn-success addProduct" data-id="'+tableId+'">Add</button></div>' +
                '</div>' +
                '<hr>'
        }
    }else{
        html = "<span>No Data Found </span>"
    }
    return html;
}
$('.closeOrder').on('click', function(){
    $('.confirmClose').attr('data-id',$(this).attr('data-id'))
    $('#closeModal').modal();
})
$('.confirmClose').on('click', function(e){
    e.preventDefault()
    var orderId = $(this).attr('data-id');
    $.ajax({
        url:'/waiter/close',
        data:{
            orderId:orderId
        },
        type:'post',
        success:function(response){
            if(response.success){
                window.location.reload();
            }
        }
    })
})