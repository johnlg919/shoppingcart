<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show_cart(Request $request)
	{
		// get the cart variable for view
		$cart = $request->session()->get('cart');
		return view('cart', ['cart' => $cart]);
	}
}
