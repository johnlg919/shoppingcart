@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <?php
            // show message if exsit
            if($msg)
            {
                ?>
                <div class="alert alert-<?=$alert?>" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <?=$msg?>
                </div>
                <?php
            }
            ?>

            <div class="panel panel-primary">
                <div class="panel-heading">Add Product</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="/admin/add_product" method="post" enctype="multipart/form-data">  
                        <div class="col-lg-12">  
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="<?=csrf_token()?>">  
                            <div class="form-group">
                                <label for="title" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Title:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Please enter the title..." value="{{$title}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Description:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <textarea class="form-control" id="description" name="description" placeholder="Please enter the description...">{{$description}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Price:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <div class="input-group-addon">$</div>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Please enter the price..." value="{{$price}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Image:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <div class="input-group-addon">$</div>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-success <?php if($alert=='success') echo 'disabled'; ?>">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
