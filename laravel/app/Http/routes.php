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
/**
 * |--------------------------------------------------------------------------
 * | Storefronts cron
 * |--------------------------------------------------------------------------
 */
Route::any('cron/run', ['as' => 'cron-run', 'uses' => 'Cron\CronController@index']);
Route::any('cron/stores', ['as' => 'cron-run', 'uses' => 'Cron\CronController@storeSyc']);
 
 //ownai link

/**
 * |--------------------------------------------------------------------------
 * | Storefronts API
 * |--------------------------------------------------------------------------
 */
Route::any('api/category', array('as' => 'sync-categories', 'uses' => 'Api\SyncController@index'));
Route::any('api/products', array('as' => 'sync-products', 'uses' => 'Api\SyncController@syncProducts'));

Route::any('api/products/save/{data}', array('as' => 'sync.products.save', 'uses' => 'Api\SyncController@syncItems'));
Route::any('api/products/changeStatus/{data}', array('as' => 'sync.products.changeStatus', 'uses' => 'Api\SyncController@ChnageStatusSync'));
Route::any('api/products/delete/{data}', array('as' => 'sync.products.delete', 'uses' => 'Api\SyncController@SyncItemDelete'));
Route::any('api/stores/{data}', array('as' => 'sync.products.delete', 'uses' => 'Api\SyncController@Stores'));
//logistics
Route::any('api/logistics/getQuote', array('as' => 'api.logistics.getQuote', 'uses' => 'Api\LogisticsController@getQuote'));
Route::any('api/logistics/bookservice', array('as' => 'api.logistics.bookservice', 'uses' => 'Api\LogisticsController@bookService'));
Route::any('api/logistics/bookservice', array('as' => 'api.logistics.bookservice', 'uses' => 'Api\LogisticsController@bookService'));
Route::get('api/logistics/orders', array('as' => 'api.logistics.orders', 'uses' => 'Api\LogisticsController@orders'));
Route::post('api/logistics/orderUpdate', array('as' => 'api.logistics.order.update', 'uses' => 'Api\LogisticsController@orderUpdate'));
Route::any('api/logistics/deliveryStatus', array('as' => 'api.logistics.order.delivery', 'uses' => 'Api\LogisticsController@deliveryStatus'));
//Route::any('api/logistics/bookservice', array('as' => 'api.logistics.bookservice', 'uses' => 'Api\LogisticsController@bookService'));


/**
 * | Owner Portal
 * |--------------------------------------------------------------------------
 */
Route::get('store/setup/details', ['as' => 'store.setup.details', 'uses' => 'OwnerPortal\StoreSetupController@details']);
Route::post('store/setup/details/update', ['as' => 'store.setup.details.update', 'uses' => 'OwnerPortal\StoreSetupController@updateDetails']);
Route::get('store/setup/contact-details', ['as' => 'store.setup.contact-details', 'uses' => 'OwnerPortal\StoreSetupController@contactDetails']);
Route::post('store/setup/contact-details/update', ['as' => 'store.setup.contact-details.update', 'uses' => 'OwnerPortal\StoreSetupController@updateContactDetails']);
Route::get('store/setup/payment-details', ['as' => 'store.setup.payment-details', 'uses' => 'OwnerPortal\StoreSetupController@paymentDetails']);
Route::post('store/setup/payment-details/update', ['as' => 'store.setup.payment-details.update', 'uses' => 'OwnerPortal\StoreSetupController@updatePaymentDetails']);
Route::get('store/setup/confirm', ['as' => 'store.setup.confirm', 'uses' => 'OwnerPortal\StoreSetupController@confirm']);

/**
 * |--------------------------------------------------------------------------
 * | Storefronts Frontend
 * |--------------------------------------------------------------------------
 */


//Ajax
Route::get('/getsuburbs/{cityid?}', ['as' => 'getsuburbs', 'uses' => 'Frontend\AjaxController@getSuburbs']);
Route::get('/getdeliverymethods/{logistics?}/{propertyOrVehicle?}', ['as' => 'getdeliverymethods', 'uses' => 'Frontend\AjaxController@getDeliveryMethods']);

Route::any('/', ['as' => 'home', 'uses' => 'Frontend\StoreController@index']);

Route::any('store/{storeslug}/page/{pageslug}', ['as' => 'content-page', 'uses' => 'Frontend\ContentController@page']);
//note: store.status middleware must only be used when passing slug in the url
Route::get('/open-a-store', ['as' => 'open-a-store', 'uses' => 'Frontend\ContentController@open_a_store']);

Route::any('/store/{slug}', ['as' => 'store', 'uses' => 'Frontend\StoreController@store', 'middleware' => ['store.status']]);
Route::any('/store/{slug}/contact', ['as' => 'store-contact', 'uses' => 'Frontend\StoreController@contact', 'middleware' => ['store.status']]);
Route::any('/store/{slug}/about', ['as' => 'store-about', 'uses' => 'Frontend\StoreController@about', 'middleware' => ['store.status']]);
Route::any('/store/{slug}/warranty', ['as' => 'store-warranty', 'uses' => 'Frontend\StoreController@warranty', 'middleware' => ['store.status']]);

Route::any('/store/{slug}/contact', ['as' => 'store-contact', 'uses' => 'Frontend\StoreController@contact']);
Route::any('/store/{slug}/about', ['as' => 'store-about', 'uses' => 'Frontend\StoreController@about']);
Route::any('/store/{slug}/warranty', ['as' => 'store-warranty', 'uses' => 'Frontend\StoreController@warranty']);

Route::any('/store/{slug}/product/{productSlug}', ['as' => 'product', 'uses' => 'Frontend\ProductController@product', 'middleware' => ['store.status']]);
// Route::post('/checkout', ['as' => 'check-out', 'uses' => 'Frontend\CheckOutController@productCheckout']);

//Search
Route::any('/store/{slug}/search', ['as' => 'store-search', 'uses' => 'Frontend\StoreController@search', 'middleware' => ['store.status'] ]);
Route::post('shopping/checkout', array('as' => 'check-out', 'uses' => 'Frontend\ShoppingCartController@updatecart'));
Route::any('shopping/{slug}/shoppingcart', ['as' => 'storecart', 'uses' => 'Frontend\ShoppingCartController@index']);
Route::any('shopping/model/remove/{indexid}', ['as' => 'shopping.modal.remove', 'uses' => 'Frontend\ShoppingCartController@modelremove']);
Route::any('shopping/remove', ['as' => 'shopping.product.remove', 'uses' => 'Frontend\ShoppingCartController@remove']);
Route::any('shopping/quantity/update/{id}/{quantity?}', ['as' => 'shopping.quantity.update', 'uses' => 'Frontend\ShoppingCartController@quantityUpdate']);
Route::any('shopping/{slug}/details', ['as' => 'shopping.details', 'uses' => 'Frontend\ShoppingCartController@details']);
Route::any('shopping/details/post', ['as' => 'shopping.details.post', 'uses' => 'Frontend\ShoppingCartController@PostDetails']);
Route::any('shopping/{slug}/order', ['as' => 'shopping.details.placeorder', 'uses' => 'Frontend\ShoppingCartController@PlaceOrder']);
Route::any('shopping/{slug}/modal', ['as' => 'shopping.details.modal', 'uses' => 'Frontend\ShoppingCartController@Paymodel']);
Route::any('shopping/{slug}/EcoCashpay', ['as' => 'shopping.details.ecocashpay', 'uses' => 'Frontend\ShoppingCartController@MakePayment']);
Route::any('shopping/{slug}/placeorder', ['as' => 'shopping.details.storeOrder', 'uses' => 'Frontend\ShoppingCartController@StoreOder']);
Route::any('shopping/{slug}/Ecocashupdate', ['as' => 'shopping.details.ecocashupdate', 'uses' => 'Frontend\ShoppingCartController@CheckPayment']);
Route::any('shopping/EcocashListener/{corrector}', ['as' => 'shopping.ecocash.listener', 'uses' => 'Frontend\ShoppingCartController@PaymentListener']);


Route::any('shopping/{slug}/order/{corrector}', ['as' => 'shopping.details.order', 'uses' => 'Frontend\ShoppingCartController@Order']);

Route::any('shopping/{slug}/invoice', ['as' => 'shopping.invoice', 'uses' => 'Frontend\ShoppingCartController@invoice']);

Route::post('shopping/update', array('as' => 'check-continue', 'uses' => 'Frontend\ShoppingCartController@update'));

Route::any('/store/{slug}/product/{productSlug}', ['as' => 'product', 'uses' => '\App\Http\Controllers\Frontend\ProductController@product', 'middleware' => ['store.status']]);

//Categories
Route::any('/store/{slug}/category/{categorySlug}/{sortby?}', ['as' => 'store-category', 'uses' => 'Frontend\CategoryController@category', 'middleware' => ['store.status']]);

// Store
Route::any('/store/{slug}/{sortby?}', ['as' => 'store', 'uses' => 'Frontend\StoreController@store']);

/**
 * |--------------------------------------------------------------------------
 * | Owner Portal
 * |--------------------------------------------------------------------------
 */
Route::get('Signup/setup/details', ['as' => 'store.setup.details', 'uses' => 'OwnerPortal\StoreSetupController@details']);
Route::post('Signup/setup/details/update', ['as' => 'store.setup.details.update', 'uses' => 'OwnerPortal\StoreSetupController@updateDetails']);
Route::get('Signup/setup/contact-details', ['as' => 'store.setup.contact-details', 'uses' => 'OwnerPortal\StoreSetupController@contactDetails']);
Route::post('Signup/setup/contact-details/update', ['as' => 'store.setup.contact-details.update', 'uses' => 'OwnerPortal\StoreSetupController@updateContactDetails']);
Route::get('Signup/setup/payment-details', ['as' => 'store.setup.payment-details', 'uses' => 'OwnerPortal\StoreSetupController@paymentDetails']);
Route::post('Signup/setup/payment-details/update', ['as' => 'store.setup.payment-details.update', 'uses' => 'OwnerPortal\StoreSetupController@updatePaymentDetails']);
Route::get('Signup/setup/confirm', ['as' => 'store.setup.confirm', 'uses' => 'OwnerPortal\StoreSetupController@confirm']);

Route::any('Signup/setup/details/validate', ['as' => 'store.setup.details.validate', 'uses' => 'OwnerPortal\StoreSetupController@Uservalidate']);
Route::any('Signup/setup/details/number', ['as' => 'store.setup.details.number', 'uses' => 'OwnerPortal\StoreSetupController@ValidateNumber']);

/**
 * |--------------------------------------------------------------------------
 * | Authentication Routes
 * |--------------------------------------------------------------------------
 * 
 * Hardcoded here instead of `Route::auth()` in order to name routes.
 * 
 */
Route::group(['prefix' => 'admin'], function () {
    
    Route::get('login', array('as' => 'admin.login', 'uses' => 'Auth\AuthController@showLoginForm'));
    Route::post('login', array('as' => 'admin.login.post', 'uses' => 'Auth\AuthController@login'));
    Route::get('logout', array('as' => 'admin.logout', 'uses' => 'Auth\AuthController@logout'));
    Route::get('password/reset/{token?}', array('as' => 'admin.password.reset', 'uses' => 'Auth\PasswordController@showResetForm'));
    Route::get('password/email', array('as' => 'admin.password.email', 'uses' => 'Auth\PasswordController@getEmail'));
    Route::post('password/email/send', array('as' => 'admin.password.email.send', 'uses' => 'Auth\PasswordController@sendResetLinkEmail'));
    Route::post('password/forgot', array('as' => 'admin.password.forgot', 'uses' => 'Auth\PasswordController@reset'));
});
/**
 * |--------------------------------------------------------------------------
 * | Backoffice
 * |--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    //Ajax
    Route::post('ajax-last-activity', ['as' => 'ajax-last-activity', 'uses' => 'BackOffice\AdminAjaxController@lastActivity']);
    Route::post('ajax-filters-queue/{tag}', ['as' => 'ajax-filters-queue', 'uses' => 'BackOffice\AdminAjaxController@filtersQueue']);
    Route::get('category_pull', ['as' => 'category_pull', 'uses' => 'BackOffice\AdminAjaxController@MainCatData']);
    Route::post('image_upload', ['as' => 'admin.image-upload', 'uses' => 'BackOffice\UploadController@upload']);
    Route::get('get_session', ['as' => 'get_session', 'uses' => 'BackOffice\AdminAjaxController@Sessionget']);
    Route::get('get_order_session',  ['as' => 'get_order_session', 'uses' => 'BackOffice\AdminAjaxController@SessiongetOrder']);

    //Super Admin
        //Manage Stores - admin.stores
        Route::get('stores', array('as' => 'admin.stores', 'uses' => 'BackOffice\AdminStoresController@index', 'middleware' => ['acl:admin.stores']));
        Route::get('stores/{id}', array('as' => 'admin.stores.details', 'uses' => 'BackOffice\AdminStoresController@details', 'middleware' => ['acl:admin.stores']));
        Route::get('stores/status/modal/change/{id}', array('as' => 'admin.stores.modal-change-status', 'uses' => 'BackOffice\AdminStoresController@modalChangeStatus', 'middleware' => ['acl:admin.stores']));
        Route::post('stores/status/change', array('as' => 'admin.stores.change-status', 'uses' => 'BackOffice\AdminStoresController@changeStatus', 'middleware' => ['acl:admin.stores']));
        Route::get('stores/status/modal/approve/{id}', array('as' => 'admin.stores.modal-approve-status', 'uses' => 'BackOffice\AdminStoresController@modalApproveStatus', 'middleware' => ['acl:admin.stores']));
    Route::get('stores/messages/approved/{slug}', array('as' => 'admin.store.approve-msg', 'uses' => 'BackOffice\StoreController@ApproveMessage', 'middleware' => ['acl:admin.stores']));
        Route::get('moderator/modal/changeStatus/{id}', array('as' => 'admin.moderation.modal-status', 'uses' => 'BackOffice\ModeratorProductsController@modalChangeStatus', 'middleware' => ['acl:admin.stores']));
        //moderator
        Route::get('moderator', array('as' => 'admin.moderator', 'uses' => 'BackOffice\ModeratorProductsController@index', 'middleware' => ['acl:admin.stores']));
        Route::get('moderator/modal/bulk/{statusid}/{selectedid}', array('as' => 'admin.moderator.modal-bulk', 'uses' => 'BackOffice\ModeratorProductsController@modalBulk', 'middleware' => ['acl:admin.stores']));
        Route::get('moderator/modal/changeStatus/{id}', array('as' => 'admin.moderation.modal-status', 'uses' => 'BackOffice\ModeratorProductsController@modalChangeStatus', 'middleware' => ['acl:admin.stores']));
        Route::post('moderator/changeStatus', array('as' => 'admin.moderator.status', 'uses' => 'BackOffice\ModeratorProductsController@ChangeStatus', 'middleware' => ['acl:admin.stores']));
        Route::post('moderator/bulk/changeStatus', array('as' => 'admin.moderator.bulk.status', 'uses' => 'BackOffice\ModeratorProductsController@bulkChangeStatus', 'middleware' => ['acl:admin.stores']));
        Route::get('moderator/product/{id?}', array('as' => 'admin.moderator.product', 'uses' => 'BackOffice\ModeratorProductsController@product', 'middleware' => ['acl:admin.stores']));

        Route::post('moderator/product/update', array('as' => 'admin.moderator.product.update', 'uses' => 'BackOffice\ModeratorProductsController@update', 'middleware' => ['acl:admin.stores']));

        //config admin
        Route::any('config/ecocash', array('as' => 'admin.config.ecocash', 'uses' => 'BackOffice\ConfigController@Ecocash', 'middleware' => ['acl:admin.stores']));

        Route::post('config/ecocash/update', array('as' => 'admin.config.ecocash.update', 'uses' => 'BackOffice\ConfigController@EcocashUpdate', 'middleware' => ['acl:admin.stores']));
        Route::any('config/ownai', array('as' => 'admin.config.ownai', 'uses' => 'BackOffice\ConfigController@Ownai', 'middleware' => ['acl:admin.stores']));
        Route::any('config/ownai/update', array('as' => 'admin.config.ownai.update', 'uses' => 'BackOffice\ConfigController@OwnaiUpdate', 'middleware' => ['acl:admin.stores']));

         Route::any('config/logistics', array('as' => 'admin.config.logistics', 'uses' => 'BackOffice\ConfigController@logistics', 'middleware' => ['acl:admin.stores']));
        Route::any('config/logistics/bookservice/update', array('as' => 'admin.config.logistics.bookservice.update', 'uses' => 'BackOffice\ConfigController@logisticsBookserviceUpdate', 'middleware' => ['acl:admin.stores']));
        Route::any('config/logistics/getQuote/update', array('as' => 'admin.config.logistics.getQuote.update', 'uses' => 'BackOffice\ConfigController@logisticsgetQuoteUpdate', 'middleware' => ['acl:admin.stores']));


        //manage variants
        Route::get('variants', array('as' => 'admin.variants', 'uses' => 'BackOffice\VariantController@index', 'middleware' => ['acl:admin.stores']));
        Route::get('variant/add', array('as' => 'admin.variant.modal-add', 'uses' => 'BackOffice\VariantController@modelAdminadd', 'middleware' => ['acl:admin.stores']));
        Route::get('variant/delete/{id}', array('as' => 'admin.variant.modal-delete', 'uses' => 'BackOffice\VariantController@modelDELETE', 'middleware' => ['acl:admin.stores']));
         Route::get('variant/add/{id}', array('as' => 'admin.variant.modal-edit', 'uses' => 'BackOffice\VariantController@modelAdminEDIT', 'middleware' => ['acl:admin.stores']));
         Route::post('variant/delete', array('as' => 'admin.variant.delete', 'uses' => 'BackOffice\VariantController@delete', 'middleware' => ['acl:admin.stores']));
         Route::post('variant/save', array('as' => 'admin.variant.add', 'uses' => 'BackOffice\VariantController@save', 'middleware' => ['acl:admin.stores']));

        //moderator
        Route::get('moderator', array('as' => 'admin.moderator', 'uses' => 'BackOffice\ModeratorProductsController@index', 'middleware' => ['acl:admin.moderator.products']));
        Route::get('moderator/modal/bulk/{statusid}/{selectedid}', array('as' => 'admin.moderator.modal-bulk', 'uses' => 'BackOffice\ModeratorProductsController@modalBulk', 'middleware' => ['acl:admin.moderator.products']));
        // Route::get('moderator/modal/moderate/{id}', array('as' => 'admin.moderation.modal-moderate', 'uses' => 'BackOffice\ModeratorProductsController@modalModerate', 'middleware' => ['acl:admin.moderator.products']));
         Route::get('moderator/modal/changeStatus/{id}', array('as' => 'admin.moderation.modal-status', 'uses' => 'BackOffice\ModeratorProductsController@modalChangeStatus', 'middleware' => ['acl:admin.moderator.products']));
        Route::post('moderator/changeStatus', array('as' => 'admin.moderator.status', 'uses' => 'BackOffice\ModeratorProductsController@ChangeStatus', 'middleware' => ['acl:admin.moderator.products']));
        Route::post('moderator/bulk/changeStatus', array('as' => 'admin.moderator.bulk.status', 'uses' => 'BackOffice\ModeratorProductsController@bulkChangeStatus', 'middleware' => ['acl:admin.moderator.products']));
        Route::get('moderator/product/{id?}', array('as' => 'admin.moderator.product', 'uses' => 'BackOffice\ModeratorProductsController@product', 'middleware' => ['acl:admin.moderator.products']));
        Route::post('moderator/product/update', array('as' => 'admin.moderator.product.update', 'uses' => 'BackOffice\ModeratorProductsController@update', 'middleware' => ['acl:admin.moderator.products']));

        Route::get('moderator/modal/delete/{id}', array('as' => 'admin.moderator.products.modal-delete', 'uses' => 'BackOffice\ModeratorProductsController@modalDelete', 'middleware' => ['acl:admin.moderator.products']));
        Route::post('moderator/products/delete', array('as' => 'admin.moderator.products.delete', 'uses' => 'BackOffice\ModeratorProductsController@delete', 'middleware' => ['acl:admin.moderator.products']));

        //manage variants
        Route::get('variants', array('as' => 'admin.variants', 'uses' => 'BackOffice\VariantController@index', 'middleware' => ['acl:admin.moderator.products']));
        Route::get('variant/add', array('as' => 'admin.variant.modal-add', 'uses' => 'BackOffice\VariantController@modelAdminadd', 'middleware' => ['acl:admin.moderator.products']));
        Route::get('variant/delete/{id}', array('as' => 'admin.variant.modal-delete', 'uses' => 'BackOffice\VariantController@modelDELETE', 'middleware' => ['acl:admin.moderator.products']));
         Route::get('variant/add/{id}', array('as' => 'admin.variant.modal-edit', 'uses' => 'BackOffice\VariantController@modelAdminEDIT', 'middleware' => ['acl:admin.moderator.products']));
         Route::post('variant/delete', array('as' => 'admin.variant.delete', 'uses' => 'BackOffice\VariantController@delete', 'middleware' => ['acl:admin.moderator.products']));
         Route::post('variant/save', array('as' => 'admin.variant.add', 'uses' => 'BackOffice\VariantController@save', 'middleware' => ['acl:admin.moderator.products']));

         //orders admin
        Route::get('manage/orders', array('as' => 'admin.manage.orders', 'uses' => 'BackOffice\AdminOrderController@index', 'middleware' => ['acl:admin.stores']));
        Route::get('manage/order/status/modal/change/{id}', array('as' => 'admin.manage.order.modal-change-status', 'uses' => 'BackOffice\AdminOrderController@modalChangeStatus', 'middleware' => ['acl:admin.stores']));
        Route::post('manage/order/status/change', array('as' => 'admin.manage.order.change-status', 'uses' => 'BackOffice\AdminOrderController@changeStatus', 'middleware' => ['acl:admin.stores']));
         Route::get('manage/order/note/add/{id}', array('as' => 'admin.manage.order.modal-add-note', 'uses' => 'BackOffice\AdminOrderController@modalAddNote', 'middleware' => ['acl:admin.stores']));
          Route::post('manage/order/note/change', array('as' => 'admin.manage.order.change-note', 'uses' => 'BackOffice\AdminOrderController@changeNote', 'middleware' => ['acl:admin.stores']));
        
          
    //Dashboard
    Route::get('dashboard', array('as' => 'admin.dashboard', 'uses' => 'BackOffice\DashboardController@index', 'middleware' => ['acl:admin.account']));
    //Account
    Route::get('account', array('as' => 'admin.account', 'uses' => 'BackOffice\AccountController@index', 'middleware' => ['acl:admin.account']));
    Route::post('account/update', array('as' => 'admin.account.update', 'uses' => 'BackOffice\AccountController@update', 'middleware' => ['acl:admin.account']));
    Route::post('account/user/update', array('as' => 'admin.user.update', 'uses' => 'BackOffice\AccountController@updateUser', 'middleware' => ['acl:admin.account']));

    //billing
    Route::get('billing', array('as' => 'admin.billing', 'uses' => 'BackOffice\BillingController@index', 'middleware' => ['acl:admin.account']));
    Route::post('billing/account/add', array('as' => 'admin.billing.account.add', 'uses' => 'BackOffice\BillingController@Accountadd', 'middleware' => ['acl:admin.account']));
    Route::post('billing/store', array('as' => 'admin.billing.store', 'uses' => 'BackOffice\BillingController@Storeupdate', 'middleware' => ['acl:admin.account']));
    Route::get('billing/invoice', array('as' => 'admin.billing.invoice', 'uses' => 'BackOffice\BillingController@Invoice', 'middleware' => ['acl:admin.account']));
    Route::any('billing/invoice/pdf/{id}', array('as' => 'admin.billing.pdf', 'uses' => 'BackOffice\BillingController@PdfInvoice', 'middleware' => ['acl:admin.account']));
     Route::any('billing/model', array('as' => 'admin.billing.modal', 'uses' => 'BackOffice\BillingController@PayModal', 'middleware' => ['acl:admin.account']));
    Route::any('billing/payment/ajax/{storeid}', array('as' => 'admin.billing.account.pay.ajax', 'uses' => 'BackOffice\BillingController@AccountPay', 'middleware' => ['acl:admin.account']));
     Route::any('billing/payment/update', array('as' => 'admin.billing.account.checkupdate.ajax', 'uses' => 'BackOffice\BillingController@TransactionUpdate', 'middleware' => ['acl:admin.account']));
     Route::any('billing/payment/transac', array('as' => 'admin.billing.account.delete.ajax', 'uses' => 'BackOffice\BillingController@TransactionDelete', 'middleware' => ['acl:admin.account']));

    Route::any('billing/payment/{id}', array('as' => 'admin.billing.payment', 'uses' => 'BackOffice\BillingController@BillUpdate'));
    //Store
    Route::get('store/details', array('as' => 'admin.store.details', 'uses' => 'BackOffice\StoreController@details', 'middleware' => ['acl:admin.store']));
    Route::post('store/details/update', array('as' => 'admin.store.details.update', 'uses' => 'BackOffice\StoreController@updateDetails', 'middleware' => ['acl:admin.store']));
    Route::get('store/appearance', array('as' => 'admin.store.appearance', 'uses' => 'BackOffice\StoreController@appearance', 'middleware' => ['acl:admin.store']));
    Route::post('store/appearance/update', array('as' => 'admin.store.appearance.update', 'uses' => 'BackOffice\StoreController@updateAppearance', 'middleware' => ['acl:admin.store']));
    Route::get('store/migration', array('as' => 'admin.store.migration', 'uses' => 'BackOffice\StoreController@migration', 'middleware' => ['acl:admin.store']));
     Route::get('store/items/migration', array('as' => 'admin.items.migration', 'uses' => 'BackOffice\StoreController@itemsMigration', 'middleware' => ['acl:admin.store']));
    Route::post('store/user/migration', array('as' => 'store.user.migration', 'uses' => 'BackOffice\StoreController@userMigrate', 'middleware' => ['acl:admin.store']));
    Route::post('store/delete/migration', array('as' => 'store.delete.migration', 'uses' => 'BackOffice\StoreController@deleteMigrate', 'middleware' => ['acl:admin.store']));
    Route::post('store/sync/migration', array('as' => 'store.sync.migration', 'uses' => 'BackOffice\StoreController@syncMigrate', 'middleware' => ['acl:admin.store']));
    Route::post('store/bulk/delete', array('as' => 'store.bulk.delete', 'uses' => 'BackOffice\StoreController@bulkDelete', 'middleware' => ['acl:admin.store']));
    Route::post('store/bulk/sync', array('as' => 'store.bulk.sync', 'uses' => 'BackOffice\StoreController@bulkSync', 'middleware' => ['acl:admin.store']));

    Route::get('store/about', array('as' => 'admin.store.about', 'uses' => 'BackOffice\StoreController@about', 'middleware' => ['acl:admin.store']));
    Route::post('store/about/update', array('as' => 'admin.store.about.update', 'uses' => 'BackOffice\StoreController@updateAbout', 'middleware' => ['acl:admin.store']));
    Route::get('store/warranty', array('as' => 'admin.store.warranty', 'uses' => 'BackOffice\StoreController@warranty', 'middleware' => ['acl:admin.store']));
    Route::post('store/warranty/update', array('as' => 'admin.store.warranty.update', 'uses' => 'BackOffice\StoreController@updateWarranty', 'middleware' => ['acl:admin.store']));
    Route::get('store/delivery', ['as' => 'admin.store.delivery', 'uses' => 'BackOffice\StoreController@delivery', 'middleware' => ['acl:admin.store']]);
    Route::post('store/delivery/update', ['as' => 'admin.store.delivery.update', 'uses' => 'BackOffice\StoreController@updateDelivery', 'middleware' => ['acl:admin.store']]);
    
    //Products
    Route::get('products', array('as' => 'admin.products', 'uses' => 'BackOffice\ProductsController@index', 'middleware' => ['acl:admin.products']));
    Route::get('products/modal/delete/{id}', array('as' => 'admin.products.modal-delete', 'uses' => 'BackOffice\ProductsController@modalDelete', 'middleware' => ['acl:admin.products']));
    Route::post('products/delete', array('as' => 'admin.products.delete', 'uses' => 'BackOffice\ProductsController@delete', 'middleware' => ['acl:admin.products']));
    Route::get('product/{id?}', array('as' => 'admin.product', 'uses' => 'BackOffice\ProductController@index', 'middleware' => ['acl:admin.products']));
    Route::post('product/update', array('as' => 'admin.product.update', 'uses' => 'BackOffice\ProductController@update', 'middleware' => ['acl:admin.products']));
    // check auth
    Route::get('product/modal/variant/add/{storeid}', array('as'=> 'admin.product.modal-variant.add', 'uses' => 'BackOffice\VariantController@modelAdd', 'middleware' => ['acl:admin.products']));
     Route::post('product/modal/variant/add', array('as'=> 'admin.product.variant.add', 'uses' => 'BackOffice\VariantController@Add', 'middleware' => ['acl:admin.products']));

    // Orders - remember hash
    // needs admin.orders permissions
    Route::group([], function() {
        Route::post('order/updateorder', array('as' => 'admin.order.updateorder', 'uses' => '\App\Http\Controllers\BackOffice\SingleOrderController@updateorder', 'middleware' => ['acl:admin.orders']));
        Route::post('order/addorder', array('as' => 'admin.order.addorder', 'uses' => '\App\Http\Controllers\BackOffice\SingleOrderController@addorder', 'middleware' => ['acl:admin.orders']));
        Route::post('order/getproducts', array('as' => 'admin.order.getproducts', 'uses' => '\App\Http\Controllers\BackOffice\SingleOrderController@getproducts', 'middleware' => ['acl:admin.orders']));
        Route::post('order/update', array('as' => 'admin.order.update', 'uses' => '\App\Http\Controllers\BackOffice\SingleOrderController@update', 'middleware' => ['acl:admin.orders']));
        Route::get('/order/{id?}', array('as' => 'admin.order', 'uses' => '\App\Http\Controllers\BackOffice\SingleOrderController@index'));
        Route::get('/orders', 'BackOffice\OrderController@index')->name('orders.index');
        Route::get('get_orders', 'BackOffice\OrderController@getOrdersData')->name('orders.get_orders');

        // Export to CSV
        Route::post('/orders/csv', 'BackOffice\OrderController@exportOrderList')->name('orders.csv');

        Route::group(['middleware' => 'store.user'], function() {
            Route::get('/orders/details/{orderid}', 'BackOffice\OrderController@details')->name('orders.details');
            Route::put('/orders/update/{orderid}', 'BackOffice\OrderController@update')->name('orders.update');
            Route::put('/orders/update-billing/{orderid}', 'BackOffice\OrderController@modalUpdateBilling')->name('orders.update-billing');
            Route::get('/orders/invoice/{orderid}', 'BackOffice\OrderController@printInvoice')->name('orders.print_invoice');
            // modalUpdateStatus
            Route::put('/orders/updatestatus/{orderid}', 'BackOffice\OrderController@updateOrderStatus')->name('orders.updatestatus');
        });

    });
});