<?php

/* @var $this yii\web\View */


$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<button class="btn btn-success addProduct"> Create New Product</button>
<hr>
<div class="products">
<?php if(!empty($products)){ ?>
    <div class="row" >
    <div class="col-sm-3"> Name</div>
    <div class="col-sm-3"> Description</div>
    <div class="col-sm-1"> Price ($ USD)</div>
    <div class="col-sm-2"> Cooking Time (Minutes)</div>
    <div class="col-sm-2"> Manage</div>
    </div>
    <hr>
    <?php foreach($products as $product){ ?>
        <div class="row" id="<?=$product['productId']?>">
            <div class="col-sm-3 productName"><?= $product['name'] ?></div>
            <div class="col-sm-3 productDescription"> <?= $product['description'] ?></div>
            <div class="col-sm-1 price"><?= $product['price'] ?></div>
            <div class="col-sm-2 time"> <?= $product['cookingTime'] ?> </div>
            <div class="col-sm-2">
                <a class="btn btn-primary editProduct" data-id="<?=$product['productId']?>"> Edit</a>
                <a class="btn btn-danger deleteProduct" data-id="<?=$product['productId']?>"> Delete</a>
            </div>
        </div>
        <hr>

<?php }} else{ ?>
   <div> No Data Found </div>
<?php } ?>
    </div>
<div id="addProductModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New  Product</h4>
            </div>
            <div class="modal-body">
                <div class="error-message" style="color:red"></div>
                <div class="row">
                    <div class="col-sm-4">
                        Name
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="name" class="form-control" name="name" placeholder="Name...">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        Description
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="description" class="form-control" name="description" placeholder="Description...">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        Price
                    </div>
                    <div class="col-sm-6">
                        <input type="number" id="price" class="form-control" name="price" min="1" placeholder="Price...">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        Cooking time in minutes
                    </div>
                    <div class="col-sm-6">
                        <input type="number" id="cookingTime" class="form-control" name="cookingTime" min="1" placeholder="Time...">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success add-product" >Save</button>
            </div>
        </div>

    </div>
</div>
<div id="deleteProductModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
               <p> Are you sure you want to delete this product? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger confirmProductDelete" >Yes</button>
            </div>
        </div>

    </div>
</div>