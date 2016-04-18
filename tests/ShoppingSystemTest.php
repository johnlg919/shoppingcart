<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShoppingSystemTest extends TestCase
{
    // added this to rollback the database updates when test is done
    use DatabaseTransactions;
    
    // test the home page, check if some product titles are showing
    public function testShoppingHomePage()
    {
        $this->visit('/')
             ->see('Product.ca') // logo
             ->see('Pure Whey Vanilla') // product title
             ->see('Alpha amino fruit punch'); // product title
    }

    // test the product detail page, check if product title is showing
    public function testShoppingProductPage()
    {
        $this->visit('/product/5')
            ->see('Alpha amino fruit punch'); // product title
    }

    // test add product to cart, if quantity is not entered should show error message
    public function testShoppingAddProductQuantityEmpty()
    {
        $response = $this->call('POST', '/product/5', ['quantity' => '']); // post quantity empty
        $this->see('Please enter the Quantity!'); // error message
    }

    // entire flow of order
    // -add item to cart
    // -remove item from cart
    // -checkout
    public function testShoppingFlow()
    {
        // cart page, if no item will show cart is empty
        $this->visit('/cart')
             ->see('Your Shopping Cart is empty.'); // message

        // add an item with quantity 5
        $response = $this->call('POST', '/product/5', ['quantity' => 3]);
        $this->assertSessionHas('cart');
        $this->see('has been added');
        $this->see('Go to your Cart');

        // cart page should show the total amount as expected
        $this->visit('/cart')
             ->see('Alpha amino fruit punch')
             ->see('Order Total: $35.85');

        // add another item
        $response = $this->call('POST', '/product/6', ['quantity' => 4]);
        $this->assertSessionHas('cart');
        $this->see('has been added');
        $this->see('Go to your Cart');

        // go to cart page, verify the total amount
        $this->visit('/cart')
             ->see('Alpha amino fruit punch')
             ->see('Energy Bar Chocolate Brownie')
             ->see('Order Total: $71.65');

        // remove one of the items, verify total amount
        $response = $this->call('GET', '/remove_product/5');
        $this->visit('/cart')
             ->see('Energy Bar Chocolate Brownie')
             ->see('Order Total: $35.80');

        // check out page, make sure some labels are showing
        $this->visit('/checkout')
             ->see('First Name')
             ->see('Last Name')
             ->see('Complete Order');

        // make sure validation in checkout page is working, for example nothing is filled
        $response = $this->call('POST', '/checkout');
        $this->see('Please enter the First Name!');
        $this->see('Please enter the Last Name!');
        $this->see('Please enter the Email Address!');

        // submit the order, make sure success message is showing
        $response = $this->call('POST', '/checkout', ['firstname' => 'John', 'lastname' => 'smith', 'email' => 'john@test.com']);
        $this->see('Order has been made');
        $this->see('Make Another Order');
    }

    // test login page with incorrect username and password
    public function testAdminLoginPageFailed()
    {
        $this->visit('/login')
            ->type('hackeremail', 'email')
            ->type('hackerpass', 'password')
            ->press('Login')
            ->see('These credentials do not match our records.');
    }

    // test for admin page including: login/add/edit/delete
    public function testAdminPages()
    {
        // login success
        $this->visit('/login')
            ->type('john@test.com', 'email')
            ->type('password', 'password')
            ->press('Login')
            ->see('Pure Whey Vanilla') // product in the listing page
            ->see('Isoflex Peanut Butter Chocolate') // product in the listing page
            ->see('glyphicon glyphicon-plus'); // Add product icon

        // add product page, should see some text in the page
        $this->visit('/admin/add_product')
            ->see('Please enter the title...');

        // test add product page validation
        $response = $this->call('POST', '/admin/add_product');
        $this->see('Please enter the title!'); // error message
        $this->see('Please enter the description!'); // error message
        $this->see('Please enter the price!'); // error message
        $this->see('Please upload an image!'); // error message

        // edit product page, should see text and icon
        $this->visit('/admin/edit_product/40')
             ->see('Edit Product') // label
             ->see('glyphicon glyphicon-pencil'); // edit icon

        // post: edit product page, make sure success message is showing
        $response = $this->call('POST', '/admin/edit_product/40', ['title' => 'Test', 'description' => 'Desc', 'price' => '88']);
        $this->see('Product updated successfully.'); // success message

        // post: delete product page, make sure success message is showing
        $response = $this->call('POST', '/admin/delete_product/40');
        $this->see('Product deleted successfully.'); // success message

    }


}
