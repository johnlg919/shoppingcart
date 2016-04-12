<?php
// to count the number of item in cart
$qty_count = 0;
$cart = session('cart');
if(is_array($cart) && count($cart)){
    foreach($cart as $item){
        $qty_count += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Product.ca</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        
        <link href="<?php echo asset('css/bootstrap-table.css'); ?>" rel="stylesheet">
        <script src="<?php echo asset('javascript/bootstrap-table.js'); ?>"></script>
    </head>
    
    <body>
        <div>
            <div class="container">
                <div class="col-xs-5" style="padding-left:0px; padding-right:5px;">
                    <a href="/" style="text-decoration:none; color:#000000;">
                        <font style="font-size:32px; font-wegith:bold; font-style:italic; text-shadow: 2px 2px 3px #ccc; ">Product.ca</font>
                    </a>
                </div>
                <div class="col-xs-7 text-right" style="padding-top:5px; padding-right:0px;">
                    <?php 
                    // to show different icon and user name if logged in
                    if(Auth::check()) // logged in
                    {
                        $path = "/admin/home";
                        $icon = "user";
                        $username = Auth::user()->name;
                    }
                    else
                    {
                        $path = "/login";
                        $icon = "lock";
                        $username = "Login";
                    }
                    ?>
                    <a href="<?=$path?>">
                        <button class="btn btn-sm btn-primary">
                            <span class="glyphicon glyphicon-<?=$icon?>" aria-hidden="true"></span> {{ $username }}
                        </button>
                    </a>

                    <button type="button" class="btn btn-sm btn-warning" onclick="location.href='/cart'">
                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Cart&nbsp;
                        <span class="badge" style="background-color:#d9534f; border:1px solid #d43f3a; color:#ffffff;">{{ $qty_count }}</span>
                    </button>
                </div>
            </div>

        </div>

        <nav class="navbar navbar-inverse" id="site_navbar" style="z-index:99;">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span class='glyphicon glyphicon-home' aria-hidden='true'></span>
                        Home
                    </a>
                </div>
            </div>
        </nav>

        <div class="container">
            

            <div class="row">
                
                @yield('sidebar')

                @yield('content')

            </div>
        </div>
    </body>
</html>

