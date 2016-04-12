<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
	{
		$msg = "";
		$alert = "danger";

		if($request->isMethod('post')) 
		{
			// inputs
			$firstname = trim($request->input('firstname'));
			$lastname = trim($request->input('lastname'));
			$email = trim($request->input('email'));
			
			// validation
			if(empty($firstname)){
		    	$msg .= "Please enter the First Name!<br>";
		    } 
		    if(empty($lastname)){
		    	$msg .= "Please enter the Last Name!<br>";
		    }
		    if(empty($email)){
		    	$msg .= "Please enter the Email Address!<br>";
		    }

		    // validation passed
		    if($msg == "")
		    {
		    	// success message
		    	$alert = "success";
		    	$msg = "Order has been made.
		    			<br><br>
		    			<a href='/'>
		    				<button class='btn btn-sm btn-success'>
		    					<span class='glyphicon glyphicon-home' aria-hidden='true'></span>
		    					Make Another Order
		    				</button>
		    			</a>";
		    	
		    	// get the cart info for the email
		    	$cart = $request->session()->get('cart');
		    	
		    	// Mail::send('emails.order_placed', ['name' => 'Manager'], function($message) // regular email
				Mail::later(15, 'emails.order_placed', ['name' => 'Manager', 'cart' => $cart, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email], function($message) // queued email
				{
				    $message->to('johnlg919@msn.com', 'John Smith')->subject('New Order Placed!');
				});

				// remove all cart items
		    	$request->session()->forget('cart');
		    }
		}

		return view('checkout', ['msg' => $msg, 'alert' => $alert]);
	}
}
