@extends('layouts.shopping')

@section('content')
    <style>
        .product_title{
            font-size: 16px;
            font-weight:bold;
        }
        .product_img{
            height:250px;
        }
        .product_price{
            font-size:18px;
        }
    </style>

    <?php
    foreach ($products as $product) 
    {
        $img_url = asset('images/'.$product->id.'.'.$product->image_ext); // path to show on the site
        $img_url2 = base_path() . '/public/images/'.$product->id.'.'.$product->image_ext; // path to get image dimension
        $img_style = "style='height:220px;'";

        if(file_exists($img_url2))
        {
            // codes to calculate the top padding in order to vertical align image to middle
            list($width, $height, $type, $attr) = getimagesize($img_url2);
            
            if($width > $height)
            {
                $space_num = number_format(((250)-(220*$height/$width))/2);
                $img_style = "style='width:220px; padding-top:{$space_num}px;'";
            }
            if($height > $width)
            {
                $img_style = "style='height:220px; padding-top:15px;'";
            }
        }
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" style="padding:5px;">
            <div class="panel panel-default" style="height:380px; margin-bottom:0">
                <div class="panel-body">
                    <div class="product_img text-center">
                        <a href="{{ '/product/'.$product->id }}">
                            <img src="<?=$img_url?>" <?=$img_style?>>
                        </a>
                    </div>
                    <div class="product_price text-info">${{ number_format($product->price, 2) }}</div>
                    <div class="product_title"><?=ucfirst(strtolower($product->title))?></div>
                    <div><?php echo (strlen($product->description) > 70) ? substr($product->description, 0, 70)."..." : $product->description; ?></div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
@stop
