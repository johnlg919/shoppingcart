Dear <?=$name?>,
<br><br>
New order has been placed.
<br><br>

<style>
table.html_table
{
	border: 1px solid #ccc;
	border-collapse: collapse;
	font-size: 13px;
	font-family: Arial;
}
.html_table td
{
	border: 1px solid #ccc;
	padding: 2px;
}
</style>

<table class="html_table">
	<tr>
		<td colspan="2"><b>Customer Information</b></td>
	</tr>
	<tr>
		<td><b>First Name</b></td>
		<td><?=$firstname?></td>
	</tr>
	<tr>
		<td><b>Last Name</b></td>
		<td><?=$lastname?></td>
	</tr>
	<tr>
		<td><b>Email</b></td>
		<td><?=$email?></td>
	</tr>
</table>
<br>

<table class="html_table">
	<tr>
		<td><b>ID</b></td>
		<td><b>Title</b></td>
		<td><b>Price</b></td>
		<td><b>Quantity</b></td>
		<td><b>Total</b></td>
	</tr>
	<?php
	if(is_array($cart) && count($cart))
	{
		$order_total = 0;
		foreach($cart as $product_id => $order)
		{
			$product = DB::table('products')->where('id', $product_id)->first();
			$order_total += $product->price*$order['quantity'];
			?>
			<tr>
				<td><?=$product_id?></td>
				<td><?=$product->title?></td>
				<td><?=number_format($product->price, 2)?></td>
				<td><?=$order['quantity']?></td>
				<td>$<?=number_format($product->price*$order['quantity'], 2)?></td>
			</tr>
			<?php
		}
		
	}
	?>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Order Total:</b></td>
		<td><b>$<?=$order_total?></b></td>
	</tr>
</table>
<br>

Regards,<br>
Ordering System