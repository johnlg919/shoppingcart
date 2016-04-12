@extends('layouts.shopping')

@section('content')
                
    <style>
        .product_title{
            font-size:22px;
            font-weight:bold;
        }
        .product_desc{
            margin-top:10px;
            font-size:16px;
        }
        .product_price{
            margin-top:10px;
            font-size:24px;
        }
    </style>

    <?php
    $img_url = asset('images/'.$product->id.'.'.$product->image_ext); // path to show on the site
    $img_url2 = base_path() . '/public/images/'.$product->id.'.'.$product->image_ext; // path to get image dimension
    $img_style = "style='height:360px;'";

    if(file_exists($img_url2))
    {
        // codes to calculate the top padding in order to vertical align image to middle
        list($width, $height, $type, $attr) = getimagesize($img_url2);
        
        if($width > $height)
        {
            $space_num = number_format((((400)-(360*$height/$width))/2)-15);
            $img_style = "style='width:360px; padding-top:{$space_num}px;'";
        }
        if($height > $width)
        {
            $img_style = "style='height:360px; padding-top:20px;'";
        }
    }
    
    // show message if exist
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
    <div class="panel panel-default" style="margin-top:5px;">
        <div class="panel-body">
            <div class="panel panel-default col-sm-12 col-md-6 col-lg-5" style="height:400px; margin-bottom:0">
                <div class="panel-body text-center">
                    <img src="<?=$img_url?>" <?=$img_style?>>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-7" style="padding-top:15px; padding-left:25px;">
                <font class="product_title"><?=ucfirst(strtolower($product->title))?></font>
                <br>
                <div class="product_desc"><?=$product->description?></div>
                <div class="product_price text-info">$<?=$product->price?></div>
                
                <br>
                <form action="/product/{{$product->id}}" method="post">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="<?=csrf_token()?>">
                    
                    <div class="form-group">
                        <b>Qty:</b>
                        <input class"form-control" name="quantity" type="text" value="<?=$quantity?>" style="width:80px"/>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-danger" type="submit" value="Add to Cart"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
