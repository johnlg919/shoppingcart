<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product_option extends Model
{
    // function to return a 2-D array of options
    public static function getProductOptions($id)
    {
		$options_list = array();
		
		// query the table for the options for that item
		$options = DB::table('product_options')->where('product_id', $id)->where('active', 'Y')->orderBy('option')->orderBy('value')->get();

		foreach($options as $option)
		{
			$options_list[$option->option][] = $option->value;
		}
    	return $options_list;
    }
}
