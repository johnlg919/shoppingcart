@extends('layouts.shopping')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<b>Cart Items</b>
	</div>
	<div class="panel-body">
		<?php
		use App\Product;
		?>
		<div class="row hidden-xs" style="padding-top:10px; padding-bottom:10px; border-bottom:1px solid #E6E6E6;">
			<div class="col-sm-2 text-center"></div>
			<div class="col-sm-3"><b>Item</b></div>
			<div class="col-sm-2"><b>Price</b></div>
			<div class="col-sm-2"><b>Quantity</b></div>
			<div class="col-sm-2"><b>Total</b></div>
		</div>
		<?php
		// if cart has item
		if(is_array($cart) && count($cart))
		{
			$order_total = 0;
			// go through the cart items to show on the cart screen
			foreach($cart as $product_id => $order)
			{
				$product = Product::find($product_id);
				$order_total += $product['price']*$order['quantity'];
				?>
				<div class="row" style="padding-top:15px; padding-bottom:15px;">
					<div class="col-sm-2 text-center">
						<a href="/product/<?=$product['id']?>">
							<img src="<?php echo asset('images/'.$product['id'].'.'.$product['image_ext']); ?>" height="80"/>
						</a>
					</div>
					<div class="col-sm-3">
						<span class='hidden-sm hidden-md hidden-lg'><b>Item</b>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>{{ $product['title'] }}
					</div>
					<div class="col-sm-2">
						<span class='hidden-sm hidden-md hidden-lg'><b>Price</b>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>${{ $product['price'] }}
					</div>
					<div class="col-sm-2">
						<span class='hidden-sm hidden-md hidden-lg'><b>Quantity</b>: </span>{{ $order['quantity'] }}
					</div>
					<div class="col-sm-2">
						<span class='hidden-sm hidden-md hidden-lg'><b>Total</b>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>${{ number_format($product['price']*$order['quantity'], 2) }}
					</div>
					<div class="col-sm-1">
						<span class='hidden-sm hidden-md hidden-lg'><b>Remove</b>: &nbsp;</span>
						<a href="{{ url('remove_product/'.$product['id']) }}"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
					</div>
				</div>
				<?php	
			}
			?>
			<div class="row" style="padding-top:15px; border-top:1px solid #E6E6E6;">
				<div class="col-sm-9">&nbsp;</div>
				<div class="col-sm-3 text-danger" style="font-size:18px"><b>Order Total: ${{ number_format($order_total, 2) }}</b></div>
			</div>
			<?php
		}
		else
		{
			?>
			<div class="col-lg-12 text-center text-danger">
				<br>
				Your Shopping Cart is empty.
			</div>
			<?php
		}
		?>
	</div>
</div>	

<div class="col-lg-12">
	<div class="col-lg-4">
		<a href="/">
			<button class="btn btn-primary pull-left">
				<span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> Continue Shopping
			</button>
		</a>
	</div>
	<?php
	if(is_array($cart) && count($cart))
	{
		?>
		<a href="/checkout">
			<button class="btn btn-primary pull-right">
				Checkout <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
			</button>
		</a>
		<?php
	}
	?>
</div>


@stop