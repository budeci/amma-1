<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Repositories\CategoryRepository;
use App\Repositories\InvolvedRepository;
use App\Repositories\LotRepository;
use App\Repositories\PagesRepository;
use App\Repositories\PostsRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\RecoverPasswordRepository;
use App\Repositories\SocialiteRepository;
use App\Repositories\SubCategoriesRepository;
use App\Repositories\VendorRepository;
use App\Repositories\SubscribeRepository;

/* ----------------------------------------------
 *  Route bindings.
 * ----------------------------------------------
 */

Route::bind('category', function ($slug) {
    return (new CategoryRepository)->findBySlug($slug);
});

Route::bind('sub_category', function ($slug) {
    return (new SubCategoriesRepository())->findBySlug($slug);
});

Route::bind('post', function ($slug) {
    return (new PostsRepository)->findBySlug($slug);
});

Route::bind('product', function ($id) {
    return ((new ProductsRepository)->find($id)) ? (new ProductsRepository)->find($id) : abort(404);
});

Route::bind('lot', function ($id) {
    return (new LotRepository())->find($id);
});

Route::bind('vendor', function ($slug) {
    return (new VendorRepository)->find($slug);
});

Route::bind('static_page', function ($slug) {
    return (new PagesRepository())->find($slug);
});

Route::bind('involved', function ($id) {
    return (new InvolvedRepository())->find($id);
});

Route::bind('token', function ($token){

    return (new RecoverPasswordRepository())->getByToken($token);
});

Route::bind('unscribe', function ($token){
    return (new SubscribeRepository())->getByToken($token);
});

Route::bind('social', function ($provider, $router) {
    return (new SocialiteRepository())->getUserByProvider(
        $router->getParameter('provider'), $provider
    );
});

Route::bind('provider', function($provider){
    if(config("services.$provider"))
        return $provider;

    abort('404');
});

Route::multilingual(function () {
    Route::get('lot', function(){
        return view('html.lot');
    });
    Route::get('lot_show', function(){
        return view('html.lot_show');
    });
    Route::get('lot_listing', function(){
        return view('html.lot_listing');
    });
    Route::get('/', [
        'as' => 'home',
        'uses' => 'HomeController@index'
    ]);

    Route::get('expire-lots', [
        'as' => 'expire_soon_products',
        'uses' => 'PagesController@expireSoonLots'
    ]);

    Route::get('last-lots', [
        'as' => 'last_added_products',
        'uses' => 'PagesController@lastAddedLots'
    ]);

    Route::get('support.html', [
        'as' => 'support',
        'uses' => 'PagesController@support'
    ]);

    /** Don't use `page` instead `static_page`, is reserved by Keyhunter\Administrator package. */
    Route::get('page/{static_page}.html', [
        'as' => 'show_page',
        'uses' => 'PagesController@show'
    ]);
    Route::get('help', [
        'as' => 'show_help',
        'uses' => 'PagesController@help'
    ]);

    Route::any('category/{category}', [
        'as' => 'view_category',
        'uses' => 'CategoriesController@show'
    ]);

    Route::any('category/{category}/{sub_category}', [
        'as' => 'view_sub_category',
        'uses' => 'CategoriesController@show'
    ]);

    Route::get('product/{product}', [
        'as' => 'view_product',
        'uses' => 'ProductsController@show'
    ]);
    Route::post('product/specification', [
        'as' => 'product_specification',
        'middleware' => 'accept-ajax',
        'uses' => 'ProductsController@getSpecifications'
    ]);

    Route::post('product/specification/color', [
        'as' => 'product_specification_color',
        'middleware' => 'accept-ajax',
        'uses' => 'ProductsController@getSpecificationsColor'
    ]);

    Route::get('blog', [
        'as' => 'view_blog',
        'uses' => 'PostController@index'
    ]);

    Route::get('blog/{post}', [
        'as' => 'view_post',
        'uses' => 'PostController@show'
    ]);

    Route::get('vendors', [
        'as' => 'vendors',
        'uses' => 'VendorController@index'
    ]);


    Route::get('contacts', [
        'as' => 'contacts',
        'uses' => 'PagesController@contacts'
    ]);

    Route::post('send_contact', [
        'as' => 'send_contact',
        'uses' => 'PagesController@send_contact'
    ]);

    Route::post('subscribe', [
        'as' => 'subscribe',
        'uses' => 'SubscribeController@index'
    ]);

    Route::get('unscribe/{unscribe}', [
        'as' => 'get_unscribe',
        'middleware' => 'unscribe',
        'uses' => 'SubscribeController@unscribe'
    ]);

    Route::get('lots/{lot}', [
        'as' => 'view_lot',
        'uses' => 'LotsController@show'
    ]);

    /* ----------------------------------------------
     *  Auth routes.
     * ----------------------------------------------
     */
    Route::group(['middleware' => 'auth'], function () {
        /* ----------------------------------------------
         *  Vendor routes.
         * ----------------------------------------------
         */
        Route::get('vendor/create', [
            'as' => 'create_vendor',
            'uses' => 'VendorController@getCreate'
        ]);

        Route::post('vendor/create', [
            'as' => 'post_create_vendor',
            'uses' => 'VendorController@postCreate'
        ]);

        Route::get('my-vendors', [
            'as' => 'my_vendors',
            'uses' => 'DashboardController@myVendors'
        ]);

        /* ----------------------------------------------
         *  Lots routes.
         * ----------------------------------------------
         */
        Route::get('lots', [
            'as' => 'lots',
            'uses' => 'LotsController@index'
        ]);

        Route::get('my-lots', [
            'as' => 'my_lots',
            'uses' => 'LotsController@myLots'
        ]);

        Route::get('lots/create/{vendor}', [
            'as' => 'add_lot',
            'uses' => 'LotsController@create'
        ]);

        Route::post('remove_product_improved_spec_price', [
            'as'         => 'remove_product_improved_spec_price',
            'middleware' => 'accept-ajax',
            'uses'       => 'SpecPriceController@removeImproveSpecPrice'
        ]);
        Route::post('remove-improved-spec', [
            'as'         => 'remove-improved-spec',
            'middleware' => 'accept-ajax',
            'uses'       => 'SpecPriceController@removeImproveSpec'
        ]);


        Route::group(['middleware' => 'can_handle_action:lot'], function () // For product only
        {

            Route::post('lots/{lot}/product/load-spec-price', [
                'as' => 'load_spec_price',
                'uses' => 'ProductsController@loadSpecPrice'
            ]);

            Route::post('lots/{lot}/product/load_spec_price_description', [
                'as'         => 'load_spec_price_description',
                'uses'       => 'ProductsController@loadSpecPriceDescription'
            ]);

            Route::post('lots/{lot}/product/load_improved_spec_price', [
                'as'         => 'load_improved_spec_price',
                'uses'       => 'ProductsController@loadImprovedSpecPrice'
            ]);
            Route::post('lots/{lot}/product/load_spec_price_color', [
                'as'         => 'load_spec_price_color',
                'uses'       => 'ProductsController@loadSpecPriceColor'
            ]);
            Route::post('lots/{lot}/product/delete_group_price', [
                'as'         => 'delete_group_price',
                'uses'       => 'ProductsController@removeGroupPrice'
            ]);
            Route::post('lots/{lot}/product/remove-spec-price-desc', [
                'as'         => 'remove-spec-price-desc',
                'uses'       => 'ProductsController@removeSpecPriceDescription'
            ]);

            Route::post('lots/{lot}/product/remove-group-size-color', [
                'as'         => 'remove-group-size-color',
                'uses'       => 'ProductsController@removeGroupSizeColor'
            ]);

            Route::post('lots/{lot}/product/remove_spec_price_color', [
                'as'         => 'remove_spec_price_color',
                'uses'       => 'ProductsController@removeSpecPriceColor'
            ]);

            Route::post('lots/{lot}/product/load-spec', [
                'as' => 'load_spec',
                'uses' => 'ProductsController@loadSpec'
            ]);
            
            Route::post('lots/{lot}/product/remove-spec', [
                'as'         => 'remove-spec',
                'uses'       => 'ProductsController@removeSpec'
            ]);


            Route::get('lots/{lot}/edit', [
                'as' => 'edit_lot',
                'uses' => 'LotsController@edit'
            ]);

            // todo: check for user .. if he can perform actions..

            Route::post('lots/{lot}/create/{product}/save', [
                'as' => 'save_product',
                'uses' => 'ProductsController@save'
            ]);

            Route::post('lots/{lot}/product/remove-image', [
                'as' => 'remove_product_image',
                'uses' => 'ProductsController@removeImage'
            ]);

            Route::post('lots/{lot}/delete-product', [
                'as' => 'delete_product',
                'uses' => 'ProductsController@remove'
            ]);

            Route::post('lots/create/{lot}/select-category', [
                'as' => 'lot_select_category',
                'middleware' => 'accept-ajax',
                'uses' => 'LotsController@selectCategory'
            ]);

            Route::post('lots/create/{lot}', [
                'as' => 'create_lot',
                'middleware' => 'add_lot_filter',
                'uses' => 'LotsController@saveLot'
            ]);

            Route::post('lots/update/{lot}', [
                'as' => 'update_lot',
                'uses' => 'LotsController@updateLot'
            ]);
            Route::post('lots/published/{lot}', [
                'as' => 'published_lot',
                'middleware' => 'add_lot_filter',
                'uses' => 'LotsController@publishedLot'
            ]);
            Route::group(['middleware' => 'accept-ajax'], function () {
                Route::post('product/{product}/add-image', [
                    'as' => 'add_product_image',
                    'uses' => 'ProductsController@addImage'
                ]);

//                Route::post('product/{product}/remove-image', [
//                    'as' => 'remove_product_image',
//                    'uses' => 'ProductsController@removeImage'
//                ]);

                Route::post('product/{product}/image-sort', [
                    'as' => 'sort_product_image',
                    'uses' => 'ProductsController@saveImagesOrder'
                ]);
            });
/*            Route::post('lots/update/{lot}', [
                'as' => 'update_lot',
                'middleware' => 'update_lot_filter',
                'uses' => 'LotsController@updateLot'
            ]);*/

            Route::post('lots/{lot}/product/load-improved-spec', [
                'as' => 'load_improved_spec',
                'uses' => 'LotsController@loadImprovedSpec'
            ]);

            /*Route::post('lots/{lot}/product/remove-spec', [
                'as' => 'remove_product_spec',
                'uses' => 'ProductsController@removeSpec'
            ]);*/
            Route::post('lots/{lot}/product/remove-spec-price', [
                'as' => 'remove_product_spec_price',
                'uses' => 'ProductsController@removeSpecPrice'
            ]);
            Route::post('lots/{lot}/product/remove-improved-spec', [
                'as' => 'remove_product_improved_spec',
                'uses' => 'ProductsController@removeImproveSpec'
            ]);
        });



        Route::post('lots/create/{lot}/load-product-form-block', [
            'as' => 'load_product_block_form',
            'uses' => 'LotsController@loadProductBlock'
        ]);

        // Add middleware if current user can perform this action.
        Route::get('lots/{lot}/delete', [
            'as' => 'delete_lot',
            'uses' => 'LotsController@delete'
        ]);

        /* ----------------------------------------------
         *  Product routes.
         * ----------------------------------------------
         */
        Route::get('my-products', [
            'as' => 'my_products',
            'uses' => 'DashboardController@myProducts'
        ]);

        Route::get('my-involved', [
            'as' => 'my_involved',
            'uses' => 'DashboardController@myInvolved'
        ]);

        Route::get('settings', [
            'as' => 'settings',
            'uses' => 'DashboardController@accountSettings'
        ]);

        Route::get('how-amma-work',[
            'as'=>'how_work',
            'uses'=> 'DashboardController@howWork'
        ]);

        Route::get('user-password', [
            'as' => 'user_password',
            'uses' => 'DashboardController@userPassword'
        ]);

        Route::post('settings/update_settings', [
            'as' => 'update_settings',
            'uses' => 'DashboardController@update'
        ]);

        Route::post('settings/update_password', [
            'as' => 'update_password',
            'uses' => 'DashboardController@updatePassword'
        ]);
       
        Route::post('vote_vendor/{vendor}',[
            'as' => 'vote_vendor',
            'middleware' => 'accept-ajax',
            'uses' => 'VendorController@vote_vendor'
        ]);
    
        Route::group(['middleware' => 'can_handle_action:vendor'], function () {
            Route::get('vendor/{vendor}/edit', [
                'as' => 'edit_vendor',
                'uses' => 'VendorController@edit'
            ]);

            Route::post('vendor/{vendor}/edit', [
                'as' => 'update_vendor',
                'uses' => 'VendorController@update'
            ]);
        });

        Route::group(['middleware' => 'can_handle_action:product'], function () // For product only
        {
            Route::group(['middleware' => 'accept-ajax'], function () {
                Route::post('product/{product}/add-image', [
                    'as' => 'add_product_image',
                    'uses' => 'ProductsController@addImage'
                ]);

//                Route::post('product/{product}/remove-image', [
//                    'as' => 'remove_product_image',
//                    'uses' => 'ProductsController@removeImage'
//                ]);

                Route::post('product/{product}/image-sort', [
                    'as' => 'sort_product_image',
                    'uses' => 'ProductsController@saveImagesOrder'
                ]);
            });
        });

        Route::post('involve/product/{product}', [
            'as' => 'involve_product',
            'middleware' => 'can_involve_product',
            'uses' => 'UsersController@involveProductOffer'
        ]);

        Route::post('involve/exit/{involved}/{product}', [
            'as' => 'involve_product_cancel',
            'uses' => 'UsersController@exitProductOffer'
        ]);
    });

    Route::get('vendors/view/{vendor}', [
        'as' => 'view_vendor',
        'uses' => 'VendorController@show'
    ]);

    /* ----------------------------------------------
     *  Auth routes.
     * ----------------------------------------------
     */
    Route::get('login', [
        'as' => 'get_login',
        'uses' => 'Auth\AuthController@getLogin'
    ]);

    Route::post('modal_login', [
        'as' => 'auth_modal_login',
        'uses' => 'Auth\AuthController@modalLogin'
    ]);

    Route::post('modal_register', [
        'as' => 'auth_modal_register',
        'uses' => 'Auth\AuthController@modalRegister'
    ]);

    Route::get('password/email', [
        'as'   => 'password_recover_send_email',
        'uses' => 'Auth\PasswordController@getEmail'
    ]);

    Route::post('password/email', [
        'as'   => 'recover_password_email',
        'uses' => 'Auth\PasswordController@postEmail'
    ]);

    Route::get('password/reset/{token}',[
        'as' => 'reset_password_token',
        'uses' => 'Auth\PasswordController@getReset'
    ]);

    Route::post('password/reset',[
        'as' => 'reset_password',
        'uses' => 'Auth\PasswordController@postReset'
    ]);

    //Social Login

    Route::get('/social/login/{provider?}',[
        'as'   => 'social_auth',
        'uses' => 'Auth\SocialiteController@getSocialAuth'
    ]);

    Route::get('/social/login/callback/{provider?}',[
        'as'   => 'social_callback',
        'uses' => 'Auth\SocialiteController@getSocialAuthCallback'
    ]);

    Route::get('/social/login/{provider}/{social}/edit-email',[
        'as'   => 'social_auth_email',
        'uses' => 'Auth\SocialiteController@getEmailForm'
    ]);

    Route::post('/social/login/{provider}/{social}/require-email',[
        'as' => 'post_social_auth_email',
        'uses' => 'Auth\SocialiteController@postEmailForm'
    ]);

    Route::get('register', [
        'as' => 'get_register',
        'uses' => 'Auth\AuthController@getRegister'
    ]);

    Route::get('recover', [
        'as' => 'get_recover',
        'uses' => 'Auth\AuthController@getRecover'
    ]);

    Route::post('register', [
        'as' => 'post_register',
        'uses' => 'Auth\AuthController@postRegister'
    ]);

    Route::post('login', [
        'as' => 'post_login',
        'uses' => 'Auth\AuthController@postLogin'
    ]);

    Route::get('logout', [
        'as' => 'logout',
        'uses' => 'Auth\AuthController@logout'
    ]);

    Route::get('verified/{confirmationCode}', [
        'as' => 'verify_email',
        'uses' => 'Auth\VerifyUserController@confirm'
    ]);

    Route::group(['middleware' => 'auth'], function () {
        Route::get('confirmation-code/resend', [
            'as' => 'resend_verify_email_form',
            'uses' => 'Auth\VerifyUserController@resendVerify'
        ]);

        Route::post('confirmation-code/resend', [
            'as' => 'resend_verify_email',
            'uses' => 'Auth\VerifyUserController@resendConfirmationCode'
        ]);
    });
});