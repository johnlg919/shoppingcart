@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-6 col-md-offset-3">

            <style>
                .product_img{
                    border:1px solid #ccc;
                    padding:15px;
                }
            </style>

            <?php
            $img_url = asset('images/'.$id.'.'.$image_ext); // path to show on the site
            $img_url2 = base_path() . '/public/images/'.$id.'.'.$image_ext; // path to get image dimension
            $img_style = "style='height:270px;'";
            $spacer_style = "style='display:none;'";

            if(file_exists($img_url2))
            {
                // codes to calculate the top padding in order to vertical align image to middle
                list($width, $height, $type, $attr) = getimagesize($img_url2);
                
                if($width > $height && $width > 270)
                {
                    $img_style = "style='width:270px;'";
                }
                if($height > $width && $height > 270)
                {
                    $img_style = "style='height:270px;'";
                }
            }

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
                <div class="panel-heading">Edit Product</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="/admin/edit_product/{{$id}}" method="post" enctype="multipart/form-data">  
                        <div class="col-lg-12">    
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="<?=csrf_token()?>">
                            <input type="hidden" name="image_ext" value="{{$image_ext}}">
                            <div class="form-group">
                                <label for="title" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Title:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <input type="text" class="form-control" id="title" name="title" value="{{$title}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Description:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <textarea class="form-control" id="description" name="description">{{$description}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Price:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <div class="input-group-addon">$</div>
                                    <input type="text" class="form-control" id="price" name="price" value="{{$price}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">Image:</label>
                                <div class="input-group col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <input type="file" class="form-control" id="image" name="image">
                                    <br><br>
                                    <div class="product_img text-center">
                                        <img src="<?=$img_url?>" <?=$img_style?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit
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
