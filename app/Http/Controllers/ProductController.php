<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
// use Image;

class ProductController extends Controller
{
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // for Ordering Users 
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
	// display all items for order
    public function product_list()
	{
		// $products = DB::select("select * from products where active='Y'"); // using query
		// $products = DB::table('products')->where('active', 'Y')->get(); // using query builder
		$products = Product::where('active', 'Y')->get(); // using the Product Modal
		return view('product_list', ['products' => $products]);
	}

	// add item to cart
	public function product(Request $request, $id)
	{
		$msg = "";
		$alert = "danger";
		$quantity = "";
		// $products = DB::select('select * from products where id = '.$id); // using query
		// $product = DB::table('products')->whereId($id)->first();// using query builder
		$product = DB::table('products')->where('id', $id)->first(); // using query builder
		
		// if request is a POST
		if($request->isMethod('post')) 
		{
		    $quantity = trim($request->input('quantity'));

		    // validations
		    if(empty($quantity)){
		    	$msg = "Please enter the quantity!";
		    } elseif(!is_numeric($quantity)){
		    	$msg = "Please enter a number for quantity!";
		    }

		    // validation passed
		    if($msg == "")
		    {
		    	// save item to session
		    	$cart = $request->session()->get('cart');
		    	
		    	// if item exist add the quantity
		    	if(isset($cart[$id]['quantity']) && $cart[$id]['quantity'] > 0){
		    		$cart[$id]['quantity'] += $quantity;
		    	}
		    	else{
		    		$cart[$id]['quantity'] = $quantity;
		    	}
		    	$quantity = ""; // clear quantity once added	

		    	// store to session
		    	$request->session()->put('cart', $cart);

		    	// show success message
		    	$alert = "success";
		    	$msg = $product->title." has been added. <a href='/cart'><u>Go to your Cart</u></a>";
		    }
		}
		
		return view('product', ['product' => $product , 'alert' => $alert, 'msg' => $msg, 'quantity' => $quantity]);
	}

	// remove cart item
	public function remove_product(Request $request, $id)
	{
		// get the cart array
		$cart = $request->session()->get('cart');

		if(isset($cart) && is_array($cart))
		{
			// go through the array of cart items
			foreach($cart as $index => $value)
	    	{
	    		// if index equal to id of removal, remove from session variable
	    		if($index == $id) 
	    		{
	    			unset($cart[$id]);
	    		}
	    	}
	    	$request->session()->put('cart', $cart);
		}

		return view('cart', ['cart' => $cart]);
	}

	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// for Admin 
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function list_product(Request $request)
    {
    	// query all active products
    	$products = Product::where('active', 'Y')->get();
		return view('list_product', ['products' => $products]);
    }

	public function add_product(Request $request)
    {
        $msg = "";
		$alert = "danger";

		$title = trim($request->input('title'));
		$description = trim($request->input('description'));
		$price = trim($request->input('price'));

		if($request->isMethod('post')) 
		{
		    // validation
		    if(empty($title)){
		    	$msg .= "Please enter the title!<br>";
		    }
		    if(empty($description)){
		    	$msg .= "Please enter the description!<br>";
		    }
		    if(empty($price)){
		    	$msg .= "Please enter the price!<br>";
		    }
		    elseif(!is_numeric($price)){
		    	$msg .= "Please enter the price in number!<br>";
		    }
			if ($request->hasFile('image'))
			{
				$file = $request->file('image');
				$image_ext = strtolower($file->getClientOriginalExtension());

				if(!in_array($image_ext, ['jpg', 'jpeg', 'gif', 'png'])) // must be file of these types
				{
					$msg .= "Image must be one of the following types: JPG, JPEG, GIF, PNG<br>";
				}
			}
			else
			{
				$msg .= "Please upload an image!<br>";
			}

			// passed validation
		    if($msg == "")
		    {
		    	$inserted_id = DB::table('products')->insertGetId([	'dt_created' => date('Y-m-d H:i:s'), 
				    												'title' => $title, 
				    												'description' => $description, 
				    												'price' => $price, 
				    												'image_ext' => $image_ext ]);

		    	$image_name = $inserted_id . '.' . $image_ext;
		    	$file->move(base_path() . '/public/images/', $image_name);
		    	
		    	// success message
		    	$alert = "success";
		    	$msg = "Product added successfully.
		    			<br><br>
		    			<a href='/admin/home'>
		    				<button class='btn btn-sm btn-success'>
		    					<span class='glyphicon glyphicon-home' aria-hidden='true'></span>
		    					Product List
		    				</button>
		    			</a>
		    			&nbsp;
		    			<a href='/admin/add_product'>
		    				<button class='btn btn-sm btn-success'>
		    					<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
		    					Add Another Product
		    				</button>
		    			</a>";
		    }
		}

        return view('add_product', ['alert' => $alert, 'msg' => $msg, 'title' => $title, 'description' => $description, 'price' => $price]);
    }

    public function edit_product(Request $request, $id)
    {
    	$msg = "";
		$alert = "danger";

		if($request->isMethod('get')) 
		{
			// query the product and set the variables for the view
			$product = DB::table('products')->where('id', $id)->first();
			$title = $product->title;
			$description = $product->description;
			$price = $product->price;
			$image_ext = $product->image_ext;
		}

		if($request->isMethod('post')) 
		{
			// from input fields
			$title = trim($request->input('title'));
			$description = trim($request->input('description'));
			$price = trim($request->input('price'));
			$image_ext = $request->input('image_ext');

		    // validation
		    if(empty($title)){
		    	$msg .= "Please enter the title!<br>";
		    }
		    if(empty($description)){
		    	$msg .= "Please enter the description!<br>";
		    }
		    if(empty($price)){
		    	$msg .= "Please enter the price!<br>";
		    }
		    elseif(!is_numeric($price)){
		    	$msg .= "Please enter the price in number!<br>";
		    }
		    if($request->hasFile('image'))
			{
				$file = $request->file('image');
				$image_ext = strtolower($file->getClientOriginalExtension());

				if(!in_array($image_ext, ['jpg', 'jpeg', 'gif', 'png'])) // must be the file of these types
				{
					$msg .= "Image must be one of the following types: JPG, JPEG, GIF, PNG<br>";
				}
			}

			// validation passed
		    if($msg == "")
		    {
		    	$updates = array();
		    	$updates['title'] = $title;
		    	$updates['description'] = $description;
		    	$updates['price'] = $price;
		    	if($request->hasFile('image'))
		    	{
		    		$updates['image_ext'] = $image_ext; // also update the extension of the file

		    		$image_name = "$id.$image_ext";
		    		$file->move(base_path() . '/public/images/', $image_name);
		    	}

		    	// update database record
		    	DB::table('products')
			            ->where('id', $id)
			            ->update($updates);

			    
			    // success message      
		    	$alert = "success";
		    	$msg = "Product updated successfully.
		    			<br><br>
		    			<a href='/admin/home'>
		    				<button class='btn btn-sm btn-success'>
		    					<span class='glyphicon glyphicon-home' aria-hidden='true'></span>
		    					Product List
		    				</button>
		    			</a>";
		    }
		}

        return view('edit_product', ['alert' => $alert, 'msg' => $msg, 'title' => $title, 'description' => $description, 'price' => $price, 'id' => $id, 'image_ext' => $image_ext]);
    }

    public function delete_product(Request $request, $id)
    {
        $msg = "";
		$alert = "danger";

		if($request->isMethod('get')) 
		{
			// query product info from database
			$product = DB::table('products')->where('id', $id)->first();
			$title = $product->title;
			$description = $product->description;
			$price = $product->price;
			$image_ext = $product->image_ext;
		}

		// POST request
		if($request->isMethod('post')) 
		{
			$title = trim($request->input('title'));
			$description = trim($request->input('description'));
			$price = trim($request->input('price'));
			$image_ext = $request->input('image_ext');

		    if($msg == "")
		    {
		    	// not actual delete, but update product as inactive
		    	// can always find the history of products
		    	DB::table('products')
			            ->where('id', $id)
			            ->update(['active' => 'N']);
			            
		    	$alert = "success";
		    	$msg = "Product deleted successfully.
		    			<br><br>
		    			<a href='/admin/home'>
		    				<button class='btn btn-sm btn-success'>
		    					<span class='glyphicon glyphicon-home' aria-hidden='true'></span>
		    					Product List
		    				</button>
		    			</a>";
		    }
		}

        return view('delete_product', ['alert' => $alert, 'msg' => $msg, 'title' => $title, 'description' => $description, 'price' => $price, 'id' => $id, 'image_ext' => $image_ext]);
    }
}
