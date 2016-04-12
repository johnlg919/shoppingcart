@extends('layouts.shopping')

@section('content')

<?php
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

// do not show if form has been submitted
if($alert != "success")
{
	?>
	<form action="/checkout" method="post">   
		
		<input type="hidden" name="_method" value="POST">
	    <input type="hidden" name="_token" value="<?=csrf_token()?>"> 
		
		<div class="panel panel-default">
			<div class="panel-heading">Checkout</div>
			<div class="panel-body">
				<div class="form-group col-lg-3">
				    <label for="firstname">First Name</label>
				    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
				</div>
				<div class="form-group col-lg-3">
				    <label for="lastname">Last Name</label>
				    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
				</div>
				<div class="form-group col-lg-3">
				    <label for="email">Email</label>
				    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
				</div>
				<div class="form-group col-lg-12 text-center">
				    <button class="btn btn-danger" type="submit">
				    	<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;
				    	Complete Order
				    </button>
				</div>
			</div>
		</div>

	</form>
	<?php
}
?>


@stop