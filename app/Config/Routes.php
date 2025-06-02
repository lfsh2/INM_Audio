<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 
## ---------------------------------------------------------------------
// Home page Routing
$routes->group('', function($routes) {
    $routes->get('/', 'HomeController::home');
    $routes->get('/home', 'HomeController::home');
    $routes->get('/library', 'HomeController::library');
    $routes->get('library', 'LibraryController::index');
    $routes->get('library/all-gears', 'LibraryController::allGears/$1');
    $routes->get('library/all-gears', 'LibraryGearComparisonController::allGears');
    $routes->get('library/category/(:num)', 'LibraryController::category/$1');
    $routes->post('library/addToComparison', 'LibraryController::addToComparison');
    $routes->get('library/getIemsByCategory/(:any)', 'LibraryController::getIemsByCategory/$1');
    $routes->get('library/comparison', 'LibraryController::comparison');    
    $routes->get('/community', 'HomeController::community');
    $routes->post('/community/post_content', 'Community::post_content');
    $routes->post('/community/post_comment', 'Community::post_comment');
    $routes->get('/customize', 'HomeController::customize');
    $routes->get('/check-login', 'AuthController::checkLogin');
    $routes->post('IEMCustomizationController/saveDesign', 'IEMCustomizationController::saveDesign');
    $routes->get('/login', 'HomeController::login');
    $routes->get('/signup', 'HomeController::signup');
    
    // Customization checkout routes
    $routes->post('customization/checkout', 'CustomizationPaymentController::checkout');
    $routes->get('customization/checkout/success/(:num)', 'CustomizationPaymentController::success/$1');
    $routes->get('customization/checkout/cancel/(:num)', 'CustomizationPaymentController::cancel/$1');
});


## ---------------------------------------------------------------------
// Users Routers
$routes->group('', function($routes){
    // post -------------------------------------------------------------
        $routes->post('/user/updateProfile', 'UserController::updateAccount');
    // get -------------------------------------------------------------
        $routes->get('/user/setting', 'UserController::userSettings');
     //   $routes->get('/user/mypurchase', 'UserController::myPurchase');
        $routes->get('/user/myLikes', 'UserController::myLikes');
        $routes->get('/user/logout', 'UserController::logout');
        $routes->get('/user/bookmark/(:num)', 'UserController::removeToLikes/$1');
        $routes->get('/user/cancelOrder/(:any)', 'UserController::cancelOrder/$1');
        $routes->get('/user/myDesign', 'IEMCustomizationController::myDesign');

        $routes->get('/user/manage_orders', 'UserController::manageOrders');
        $routes->get('/user/get_orders', 'UserController::getOrders');
        $routes->post('/user/cancelOrder', 'UserController::cancelOrder');
        $routes->post('/user/fetchOrders', 'UserController::fetchOrders');

});

## ---------------------------------------------------------------------
// shop routing
$routes->group('', function($routes) {
    // post -------------------------------------------------------------
        $routes->post('/cart/add/(:num)', 'ShopController::addToCart/$1');
        $routes->post('/cart/delete', 'ShopController::removeAllItems');
      //  $routes->post('/orderPlaced', 'ShopController::placeOrder');
        
    // get -------------------------------------------------------------
        $routes->get('/shop', 'ShopController::shop');
        $routes->get('/shop/(:num)', 'ShopController::viewItem/$1');
        $routes->get('/cart', 'ShopController::cart');
        $routes->get('/cart/delete/(:num)', 'ShopController::removeItem/$1');
        $routes->get('/cart/deleteItems', 'ShopController::removeSelectedItem');
        $routes->get('/searchGears', 'ShopController::searchGears');
        $routes->get('/bookmark/(:num)', 'ShopController::addToLikes/$1');

        $routes->get('/donePurchase', 'ShopController::donePurchase');
        $routes->post('/checkout', 'PaymentController::checkout');
        $routes->get('/checkout/success/(:num)', 'PaymentController::success/$1');
        $routes->get('/checkout/cancel/(:num)', 'PaymentController::cancel/$1');

     //   $routes->get('/checkout-customize', 'CheckoutCustomizeController::index');
     //    $routes->post('/checkout-customize/processPayment', 'CheckoutCustomizeController::processPayment');


     $routes->post('customization/checkout', 'CustomizationPaymentController::checkout'); 
    $routes->get('customization/checkout/success/(:num)', 'CustomizationPaymentController::success/$1'); 
    $routes->get('customization/checkout/cancel/(:num)', 'CustomizationPaymentController::cancel/$1');



        $routes->get('/checkout/success/(:num)', 'PaymentController::success/$1');
        $routes->get('/checkout/cancel/(:num)', 'PaymentController::cancel/$1');
        
        $routes->get('/donePurchase', 'ShopController::donePurchase'); 

        $routes->delete('customization/delete/(:num)', 'IEMCustomizationController::delete/$1');


    // $routes->get('/checkOutFailed', 'ShopController::checkOutFailed');
});

// Product showcase and customization routes
$routes->group('', function($routes) {
    $routes->get('/shop', 'ShopController::shop');
    $routes->get('/searchGears', 'ShopController::searchGears');
    $routes->get('/bookmark/(:num)', 'ShopController::addToLikes/$1');
    $routes->get('/customize', 'HomeController::customize');
    $routes->get('/customize/(:num)', 'ShopController::customize/$1');
    $routes->get('/customize/design/(:num)', 'IEMCustomizationController::design/$1');
    
    // Customization routes
    $routes->post('/IEMCustomizationController/saveDesign', 'IEMCustomizationController::saveDesign');
    $routes->get('/user/myDesign', 'IEMCustomizationController::myDesign');
    $routes->delete('/customization/delete/(:num)', 'IEMCustomizationController::delete/$1');
});

$routes->get('/admin/pending_posts', 'AdminController::pending_posts');
$routes->get('/admin/approve_post/(:num)', 'AdminController::approve_post/$1');
$routes->get('/admin/reject_post/(:num)', 'AdminController::reject_post/$1');


$routes->get('admin/getNotifications', 'AdminController::getNotifications');
$routes->get('/admin/notifications/low-stock', 'NotificationController::lowStockNotifications');


## ---------------------------------------------------------------------
// admin routers
$routes->group('/admin/', function($routes) {
    // post-------------------------------------------------------------
        ## gear management
        $routes->post('gears/addGear', 'AdminController::addGear'); 
        $routes->post('gears/addCat', 'AdminController::addNewCategory'); 
        ## register new admin or user account
        $routes->post('registerAdmin', 'AdminController::createNewAdmin');
        $routes->post('registerUser', 'AdminController::createNewUser');
        ## admin account setting management
        $routes->post('updateAccount', 'AdminController::updateAdmin');
        ## admin transactions update/remove
        $routes->post('transaction/updateStatus', 'AdminController::updateStatus');
        ## update gear
        $routes->post('updateGear/(:num)', 'AdminController::updateGear/$1');

    // get -------------------------------------------------------------
        ## routes
        $routes->get('account', 'AdminController::account');


        $routes->get('dashboard', 'AdminController::dashboard');


    
        // charts
        $routes->get('chart-data/revenue', 'AdminController::getRevenueData');
        $routes->get('chart-data/products', 'AdminController::getProductTrends');
        $routes->get('orders_transactions', 'AdminController::orders_transactions');
        $routes->get('chart-data/revenue', 'AdminController::getRevenueChartData');
        $routes->get('chart-data/order-status', 'AdminController::getOrderStatusChartData');
        $routes->get('chart-data/recent-orders', 'AdminController::getRecentOrdersData');
        $routes->get('notifications/low-stock', 'AdminController::getLowStockNotifications');
        $routes->post('update_order_status', 'AdminController::update_order_status');
        
      //  $routes->get('dashboard1', 'AdminController::dashboard1');

        $routes->get('chart-data/recent-orders', 'AdminController::getRecentOrders');
        // Admin routes
        $routes->get('admin/dashboard', 'OrderController::dashboard');
        $routes->get('admin/orders_transactions', 'OrderController::orderTransactions');
        $routes->get('admin/complete_order/(:num)', 'OrderController::completeOrder/$1');
        $routes->get('admin/cancel_order/(:num)', 'OrderController::cancelOrder/$1');
        $routes->get('admin/delete_order/(:num)', 'OrderController::deleteOrder/$1');
        $routes->post('admin/update_order_status', 'OrderController::updateOrderStatus');
        $routes->get('admin/order_details/(:num)', 'OrderController::viewOrderDetails/$1');

        ## gear management
        $routes->get('management', 'AdminController::gearManagement');
        $routes->get('gears/addGears', 'AdminController::addGears');
        $routes->get('gears/removeGears/(:num)', 'AdminController::removeGear/$1');
        $routes->get('gears/addCategory', 'AdminController::addCategories'); 
        $routes->get('gears/removeCats/(:num)', 'AdminController::removeCategory/$1'); 
        $routes->get('gears/searchGears', 'AdminController::searchGears');
        ## transaction
        $routes->get('transaction/removeTransaction/(:num)', 'AdminController::removeTransaction/$1');
        $routes->get('transaction/view/(:num)', 'AdminController::viewTransaction/$1');

      // Order Management Routes
    /*   $routes->group('admin/order', function($routes) {
        $routes->get('toConfirm/(:num)', 'OrderController::confirmOrder/$1');
        $routes->get('cancelToConfirm/(:num)', 'OrderController::cancelToConfirmOrder/$1');
        $routes->get('complete/(:num)', 'OrderController::completeOrder/$1');
        $routes->get('cancelConfirmOrder/(:num)', 'OrderController::cancelConfirmedOrder/$1');
        $routes->get('deleteComplete/(:num)', 'OrderController::deleteCompletedOrder/$1');
        $routes->get('cancelled/(:num)', 'OrderController::deleteCancelledOrder/$1');


    }); */
    

       // $routes->get('order/toConfirm/(:num)', 'AdminController::confirmOrder/$1');
       // $routes->get('order/cancelToConfirm/(:num)', 'AdminController::deleteToConfirmOrder/$1');

       // $routes->get('order/complete/(:num)', 'AdminController::completeOrder/$1');
       // $routes->get('order/cancelConfirmOrder/(:num)', 'AdminController::cancelOrder/$1');

      //  $routes->get('order/deleteComplete/(:num)', 'AdminController::deleteComplteOrder/$1');
     //   $routes->get('order/cancelled/(:num)', 'AdminController::deleteCancelledOrder/$1');

      //  $routes->get('orders/search', 'AdminController::searchOrders');
        ## customers
        $routes->get('customers', 'AdminController::customers');
        ## logging out admin account
        $routes->get('loggingOut', 'AdminController::logout');
        ## register new admin or user account
        $routes->get('registerA', 'AdminController::register');
        $routes->get('registerU', 'AdminController::registerUser');
        ## admin account setting management
        $routes->get('deleteAccount/(:num)', 'AdminController::deleteAdmin/$1');
        ##deactivate user account
        $routes->get('deactAccount/(:num)', 'AdminController::accountActivation/$1');
        $routes->get('deleteUserAccount/(:num)', 'AdminController::deleteUserAccount/$1');
        ## view user information
        $routes->get('view/(:num)', 'AdminController::viewUserInformation/$1');
});


## --------------------------------------------------------------------
// account routing [admins/users]
$routes->group('/account/', function($routes){
    // post
    $routes->post('login', 'Login_SignupController::loginAdminAndUser');
    $routes->post('resetPass', 'Login_SignupController::resetPass');
    $routes->post('signup', 'Login_SignupController::signup_user');
    $routes->post('verify-Email', 'Helpers\EmailVerificationController::checkAccount');
    $routes->post('resend-verification', 'Helpers\EmailVerificationController::resendVerificationCode');
    $routes->post('checkEmail', 'Login_SignupController::checkEmail');
    $routes->post('resetPassword', 'Login_SignupController::resetPass');
    // get
    $routes->get('verify-email', 'Helpers\EmailVerificationController::verificationPage');
    $routes->get('forgotPass', 'Login_SignupController::forgotPass');
    $routes->get('createNewPass', 'Login_SignupController::createNewPass');
    $routes->get('successReset', 'Login_SignupController::successReset');
});