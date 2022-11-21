<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Auth::routes();
Route::middleware(['auth'])->group(function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/roles', [App\Http\Controllers\Settings\RoleController::class, 'index'])->name('roles');
    Route::get('/order-status', [App\Http\Controllers\Master\OrderStatusController::class, 'index'])->name('order-status');
    Route::get('/country', [App\Http\Controllers\Master\CountryController::class, 'index'])->name('country');
    Route::get('/state', [App\Http\Controllers\Master\StateController::class, 'index'])->name('state');
    Route::get('/pincode', [App\Http\Controllers\Master\PincodeController::class, 'index'])->name('pincode');
    Route::get('/city', [App\Http\Controllers\Master\CityController::class, 'index'])->name('city');
    Route::get('/brands', [App\Http\Controllers\Master\BrandController::class, 'index'])->name('brand');
    Route::get('/main_category', [App\Http\Controllers\Category\MainCategoryController::class, 'index'])->name('main_category');
    Route::get('/sub_category', [App\Http\Controllers\Category\SubCategoryController::class, 'index'])->name('sub_category');
    Route::get('/testimonials', [App\Http\Controllers\TestimonialsController::class, 'index'])->name('testimonials');
    Route::get('/product', [App\Http\Controllers\Product\ProductController::class, 'index'])->name('product');
    Route::get('/walkthroughs', [App\Http\Controllers\WalkThroughController::class, 'index'])->name('walkthroughs');
    Route::get('/product-category', [App\Http\Controllers\Product\ProductCategoryController::class, 'index'])->name('product-category');
    Route::get('/tax', [App\Http\Controllers\Settings\TaxController::class, 'index'])->name('tax');
    Route::get('/coupon', [App\Http\Controllers\Offers\CouponController::class, 'index'])->name('coupon');
    Route::get('/email-template', [App\Http\Controllers\Master\EmailTemplateController::class, 'index'])->name('email-template');
    Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer');
    Route::get('/video-booking', [App\Http\Controllers\VideoBookingController::class, 'index'])->name('video-booking');
    Route::prefix('roles')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\Settings\RoleController::class, 'modalAddEdit'])->name('roles.add.edit');
        Route::post('/delete', [App\Http\Controllers\Settings\RoleController::class, 'delete'])->name('roles.delete');
        Route::post('/status', [App\Http\Controllers\Settings\RoleController::class, 'changeStatus'])->name('roles.status');
        Route::post('/save', [App\Http\Controllers\Settings\RoleController::class, 'saveForm'])->name('roles.save');
        Route::get('/export/excel', [App\Http\Controllers\Settings\RoleController::class, 'export'])->name('roles.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\Settings\RoleController::class, 'exportPdf'])->name('roles.export.pdf');
    });

    Route::get('/global', [App\Http\Controllers\GlobalSettingController::class, 'index'])->name('global');
    Route::post('/global/save', [App\Http\Controllers\GlobalSettingController::class, 'saveForm'])->name('global.save');

    Route::prefix('my-profile')->group(function(){
        Route::get('/', [App\Http\Controllers\MyProfileController::class, 'index'])->name('my-profile');
        Route::get('/password', [App\Http\Controllers\MyProfileController::class, 'getPasswordTab'])->name('my-profile.password');
        Route::post('/getTab', [App\Http\Controllers\MyProfileController::class, 'getTab'])->name('my-profile.get.tab');
        Route::post('/save', [App\Http\Controllers\MyProfileController::class, 'saveForm'])->name('my-profile.save');
    });

    Route::prefix('users')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\UserController::class, 'modalAddEdit'])->name('users.add.edit');
        Route::post('/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
        Route::post('/status', [App\Http\Controllers\UserController::class, 'changeStatus'])->name('users.status');
        Route::post('/save', [App\Http\Controllers\UserController::class, 'saveForm'])->name('users.save');
        Route::get('/export/excel', [App\Http\Controllers\UserController::class, 'export'])->name('users.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\UserController::class, 'exportPdf'])->name('users.export.pdf');
    });

    Route::prefix('order-status')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\Master\OrderStatusController::class, 'modalAddEdit'])->name('order-status.add.edit');
        Route::post('/status', [App\Http\Controllers\Master\OrderStatusController::class, 'changeStatus'])->name('order-status.status');
        Route::post('/delete', [App\Http\Controllers\Master\OrderStatusController::class, 'delete'])->name('order-status.delete');
        Route::post('/save', [App\Http\Controllers\Master\OrderStatusController::class, 'saveForm'])->name('order-status.save');
        Route::get('/export/excel', [App\Http\Controllers\Master\OrderStatusController::class, 'export'])->name('order-status.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\Master\OrderStatusController::class, 'exportPdf'])->name('order-status.export.pdf');
    });

    Route::post('/country/addOrEdit', [App\Http\Controllers\Master\CountryController::class, 'modalAddEdit'])->name('country.add.edit');
    Route::post('/country/status', [App\Http\Controllers\Master\CountryController::class, 'changeStatus'])->name('country.status');
    Route::post('/country/delete', [App\Http\Controllers\Master\CountryController::class, 'delete'])->name('country.delete');
    Route::post('/country/save', [App\Http\Controllers\Master\CountryController::class, 'saveForm'])->name('country.save');
    Route::get('/country/export/excel', [App\Http\Controllers\Master\CountryController::class, 'export'])->name('country.export.excel');
    Route::get('/country/export/pdf', [App\Http\Controllers\Master\CountryController::class, 'exportPdf'])->name('country.export.pdf');

    Route::post('/state/addOrEdit', [App\Http\Controllers\Master\StateController::class, 'modalAddEdit'])->name('state.add.edit');
    Route::post('/state/status', [App\Http\Controllers\Master\StateController::class, 'changeStatus'])->name('state.status');
    Route::post('/state/delete', [App\Http\Controllers\Master\StateController::class, 'delete'])->name('state.delete');
    Route::post('/state/save', [App\Http\Controllers\Master\StateController::class, 'saveForm'])->name('state.save');
    Route::get('/state/export/excel', [App\Http\Controllers\Master\StateController::class, 'export'])->name('state.export.excel');
    Route::get('/state/export/pdf', [App\Http\Controllers\Master\StateController::class, 'exportPdf'])->name('state.export.pdf');

    Route::post('/city/addOrEdit', [App\Http\Controllers\Master\CityController::class, 'modalAddEdit'])->name('city.add.edit');
    Route::post('/city/status', [App\Http\Controllers\Master\CityController::class, 'changeStatus'])->name('city.status');
    Route::post('/city/delete', [App\Http\Controllers\Master\CityController::class, 'delete'])->name('city.delete');
    Route::post('/city/save', [App\Http\Controllers\Master\CityController::class, 'saveForm'])->name('city.save');
    Route::get('/city/export/excel', [App\Http\Controllers\Master\CityController::class, 'export'])->name('city.export.excel');
    Route::get('/city/export/pdf', [App\Http\Controllers\Master\CityController::class, 'exportPdf'])->name('city.export.pdf');

    Route::post('/pincode/addOrEdit', [App\Http\Controllers\Master\PincodeController::class, 'modalAddEdit'])->name('pincode.add.edit');
    Route::post('/pincode/status', [App\Http\Controllers\Master\PincodeController::class, 'changeStatus'])->name('pincode.status');
    Route::post('/pincode/delete', [App\Http\Controllers\Master\PincodeController::class, 'delete'])->name('pincode.delete');
    Route::post('/pincode/save', [App\Http\Controllers\Master\PincodeController::class, 'saveForm'])->name('pincode.save');
    Route::get('/pincode/export/excel', [App\Http\Controllers\Master\PincodeController::class, 'export'])->name('pincode.export.excel');
    Route::get('/pincode/export/pdf', [App\Http\Controllers\Master\PincodeController::class, 'exportPdf'])->name('pincode.export.pdf');

    Route::post('/brand/addOrEdit', [App\Http\Controllers\Master\BrandController::class, 'modalAddEdit'])->name('brand.add.edit');
    Route::post('/brand/status', [App\Http\Controllers\Master\BrandController::class, 'changeStatus'])->name('brand.status');
    Route::post('/brand/delete', [App\Http\Controllers\Master\BrandController::class, 'delete'])->name('brand.delete');
    Route::post('/brand/save', [App\Http\Controllers\Master\BrandController::class, 'saveForm'])->name('brand.save');
    Route::get('/brand/export/excel', [App\Http\Controllers\Master\BrandController::class, 'export'])->name('brand.export.excel');
    Route::get('/brand/export/pdf', [App\Http\Controllers\Master\BrandController::class, 'exportPdf'])->name('brand.export.pdf');

    Route::post('/main_category/addOrEdit', [App\Http\Controllers\Category\MainCategoryController::class, 'modalAddEdit'])->name('main_category.add.edit');
    Route::post('/main_category/status', [App\Http\Controllers\Category\MainCategoryController::class, 'changeStatus'])->name('main_category.status');
    Route::post('/main_category/delete', [App\Http\Controllers\Category\MainCategoryController::class, 'delete'])->name('main_category.delete');
    Route::post('/main_category/save', [App\Http\Controllers\Category\MainCategoryController::class, 'saveForm'])->name('main_category.save');
    Route::get('/main_category/export/excel', [App\Http\Controllers\Category\MainCategoryController::class, 'export'])->name('main_category.export.excel');
    Route::get('/main_category/export/pdf', [App\Http\Controllers\Category\MainCategoryController::class, 'exportPdf'])->name('main_category.export.pdf');
    
    $categoriesArray = array('sub_category', 'product-tags', 'product-labels');
    foreach ($categoriesArray as $catUrl ) {
        Route::prefix($catUrl)->group(function() use($catUrl) {
            Route::get('/', [App\Http\Controllers\Category\SubCategoryController::class, 'index'])->name($catUrl);
            Route::post('/addOrEdit', [App\Http\Controllers\Category\SubCategoryController::class, 'modalAddEdit'])->name($catUrl.'.add.edit');
            Route::post('/status', [App\Http\Controllers\Category\SubCategoryController::class, 'changeStatus'])->name($catUrl.'.status');
            Route::post('/delete', [App\Http\Controllers\Category\SubCategoryController::class, 'delete'])->name($catUrl.'.delete');
            Route::post('/save', [App\Http\Controllers\Category\SubCategoryController::class, 'saveForm'])->name($catUrl.'.save');
            Route::get('/export/excel', [App\Http\Controllers\Category\SubCategoryController::class, 'export'])->name($catUrl.'.export.excel');
            Route::get('/export/pdf', [App\Http\Controllers\Category\SubCategoryController::class, 'exportPdf'])->name($catUrl.'.export.pdf');
        });
    }

    Route::post('/testimonials/addOrEdit', [App\Http\Controllers\TestimonialsController::class, 'modalAddEdit'])->name('testimonials.add.edit');
    Route::post('/testimonials/status', [App\Http\Controllers\TestimonialsController::class, 'changeStatus'])->name('testimonials.status');
    Route::post('/testimonials/delete', [App\Http\Controllers\TestimonialsController::class, 'delete'])->name('testimonials.delete');
    Route::post('/testimonials/save', [App\Http\Controllers\TestimonialsController::class, 'saveForm'])->name('testimonials.save');
    Route::get('/testimonials/export/excel', [App\Http\Controllers\TestimonialsController::class, 'export'])->name('testimonials.export.excel');
    Route::get('/testimonials/export/pdf', [App\Http\Controllers\TestimonialsController::class, 'exportPdf'])->name('testimonials.export.pdf');

    Route::prefix('products')->group(function(){
        Route::get('/', [App\Http\Controllers\Product\ProductController::class, 'index'])->name('products'); 
        Route::get('/add/{id?}', [App\Http\Controllers\Product\ProductController::class, 'addEditPage'])->name('products.add.edit'); 
        Route::post('/status', [App\Http\Controllers\Product\ProductController::class, 'changeStatus'])->name('products.status');
        Route::post('/delete', [App\Http\Controllers\Product\ProductController::class, 'delete'])->name('products.delete');
        Route::post('/save', [App\Http\Controllers\Product\ProductController::class, 'saveForm'])->name('products.save');
        Route::post('/remove/image', [App\Http\Controllers\Product\ProductController::class, 'removeImage'])->name('products.remove.image');
        Route::post('/remove/brochure', [App\Http\Controllers\Product\ProductController::class, 'removeBrochure'])->name('products.remove.brochure');
        Route::post('/upload/brochure', [App\Http\Controllers\Product\ProductController::class, 'uploadBrochure'])->name('products.upload.brochure');
        Route::post('/upload/gallery', [App\Http\Controllers\Product\ProductController::class, 'uploadGallery'])->name('products.upload.gallery');
        Route::get('/export/excel', [App\Http\Controllers\Product\ProductController::class, 'export'])->name('products.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\Product\ProductController::class, 'exportPdf'])->name('products.export.pdf');

        Route::post('/attribute/row', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'getAttributeRow'])->name('products.attribute.row'); 
        /***** Attribute set values */
        Route::get('/attribute', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'index'])->name('product-attribute'); 
        Route::post('/attribute/addOrEdit', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'modalAddEdit'])->name('product-attribute.add.edit');
        Route::post('/attribute/status', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'changeStatus'])->name('product-attribute.status');
        Route::post('/attribute/delete', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'delete'])->name('product-attribute.delete');
        Route::post('/attribute/save', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'saveForm'])->name('product-attribute.save');
        Route::get('/attribute/export/excel', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'export'])->name('product-attribute.export.excel');
        Route::get('/attribute/export/pdf', [App\Http\Controllers\Product\ProductAttributeSetController::class, 'exportPdf'])->name('product-attribute.export.pdf');
        /****** Product Collection */
        Route::get('/collection', [App\Http\Controllers\Product\ProductCollectionController::class, 'index'])->name('product-collection'); 
        Route::post('/collection/addOrEdit', [App\Http\Controllers\Product\ProductCollectionController::class, 'modalAddEdit'])->name('product-collection.add.edit');
        Route::post('/collection/status', [App\Http\Controllers\Product\ProductCollectionController::class, 'changeStatus'])->name('product-collection.status');
        Route::post('/collection/delete', [App\Http\Controllers\Product\ProductCollectionController::class, 'delete'])->name('product-collection.delete');
        Route::post('/collection/save', [App\Http\Controllers\Product\ProductCollectionController::class, 'saveForm'])->name('product-collection.save');
        Route::get('/collection/export/excel', [App\Http\Controllers\Product\ProductCollectionController::class, 'export'])->name('product-collection.export.excel');
        Route::get('/collection/export/pdf', [App\Http\Controllers\Product\ProductCollectionController::class, 'exportPdf'])->name('product-collection.export.pdf');
    });

    Route::prefix('walkthroughs')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\WalkThroughController::class, 'modalAddEdit'])->name('walkthroughs.add.edit');
        Route::post('/status', [App\Http\Controllers\WalkThroughController::class, 'changeStatus'])->name('walkthroughs.status');
        Route::post('/delete', [App\Http\Controllers\WalkThroughController::class, 'delete'])->name('walkthroughs.delete');
        Route::post('/save', [App\Http\Controllers\WalkThroughController::class, 'saveForm'])->name('walkthroughs.save');
        Route::get('/export/excel', [App\Http\Controllers\WalkThroughController::class, 'export'])->name('walkthroughs.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\WalkThroughController::class, 'exportPdf'])->name('walkthroughs.export.pdf');
    });

    Route::prefix('product-category')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\Product\ProductCategoryController::class, 'modalAddEdit'])->name('product-category.add.edit');
        Route::post('/status', [App\Http\Controllers\Product\ProductCategoryController::class, 'changeStatus'])->name('product-category.status');
        Route::post('/delete', [App\Http\Controllers\Product\ProductCategoryController::class, 'delete'])->name('product-category.delete');
        Route::post('/save', [App\Http\Controllers\Product\ProductCategoryController::class, 'saveForm'])->name('product-category.save');
        Route::get('/export/excel', [App\Http\Controllers\Product\ProductCategoryController::class, 'export'])->name('product-category.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\Product\ProductCategoryController::class, 'exportPdf'])->name('product-category.export.pdf');
    });
    Route::prefix('tax')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\Settings\TaxController::class, 'modalAddEdit'])->name('tax.add.edit');
        Route::post('/status', [App\Http\Controllers\Settings\TaxController::class, 'changeStatus'])->name('tax.status');
        Route::post('/delete', [App\Http\Controllers\Settings\TaxController::class, 'delete'])->name('tax.delete');
        Route::post('/save', [App\Http\Controllers\Settings\TaxController::class, 'saveForm'])->name('tax.save');
        Route::get('/export/excel', [App\Http\Controllers\Settings\TaxController::class, 'export'])->name('tax.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\Settings\TaxController::class, 'exportPdf'])->name('tax.export.pdf');
    });

    Route::prefix('coupon')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\Offers\CouponController::class, 'modalAddEdit'])->name('coupon.add.edit');
        Route::post('/status', [App\Http\Controllers\Offers\CouponController::class, 'changeStatus'])->name('coupon.status');
        Route::post('/delete', [App\Http\Controllers\Offers\CouponController::class, 'delete'])->name('coupon.delete');
        Route::post('/save', [App\Http\Controllers\Offers\CouponController::class, 'saveForm'])->name('coupon.save');
        Route::get('/export/excel', [App\Http\Controllers\Offers\CouponController::class, 'export'])->name('coupon.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\Offers\CouponController::class, 'exportPdf'])->name('coupon.export.pdf');
        Route::get('/coupon-gendrate', [App\Http\Controllers\Offers\CouponController::class, 'couponGendrate'])->name('coupon.coupon-gendrate');
        Route::post('/coupon-apply', [App\Http\Controllers\Offers\CouponController::class, 'couponType'])->name('coupon.coupon-apply'); 
    });
    Route::prefix('email-template')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\Master\EmailTemplateController::class, 'modalAddEdit'])->name('email-template.add.edit');
        Route::post('/status', [App\Http\Controllers\Master\EmailTemplateController::class, 'changeStatus'])->name('email-template.status');
        Route::post('/delete', [App\Http\Controllers\Master\EmailTemplateController::class, 'delete'])->name('email-template.delete');
        Route::post('/save', [App\Http\Controllers\Master\EmailTemplateController::class, 'saveForm'])->name('email-template.save');
    });
    
    Route::post('/getProduct/category/list', [App\Http\Controllers\CommonController::class, 'getProductCategoryList'])->name('common.category.dropdown');
    Route::post('/getProduct/brand/list', [App\Http\Controllers\CommonController::class, 'getProductBrandList'])->name('common.brand.dropdown');
    Route::post('/getProduct/dynamic/list', [App\Http\Controllers\CommonController::class, 'getProductDynamicList'])->name('common.dynamic.dropdown');

    Route::prefix('customer')->group(function(){

        Route::post('/addOrEdit', [App\Http\Controllers\CustomerController::class, 'modalAddEdit'])->name('customer.add.edit');
        Route::post('/status', [App\Http\Controllers\CustomerController::class, 'changeStatus'])->name('customer.status');
        Route::post('/delete', [App\Http\Controllers\CustomerController::class, 'delete'])->name('customer.delete');
        Route::post('/save', [App\Http\Controllers\CustomerController::class, 'saveForm'])->name('customer.save');
        Route::get('/export/excel', [App\Http\Controllers\CustomerController::class, 'export'])->name('customer.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\CustomerController::class, 'exportPdf'])->name('customer.export.pdf');
        Route::get('/coupon-gendrate', [App\Http\Controllers\CustomerController::class, 'couponGendrate'])->name('customer.coupon-gendrate');
        Route::post('/coupon-apply', [App\Http\Controllers\CustomerController::class, 'couponType'])->name('customer.coupon-apply');
        Route::get('/customer/view/{id}', [App\Http\Controllers\CustomerController::class, 'view'])->name('customer.view');
        Route::get('/add-address', [App\Http\Controllers\CustomerController::class, 'addAddress'])->name('customer.add-address');
        Route::post('/address', [App\Http\Controllers\CustomerController::class, 'customerAddress'])->name('customer.address');
        Route::post('/address/list', [App\Http\Controllers\CustomerController::class, 'addressList'])->name('customer.address.list');
        Route::post('/address/delete', [App\Http\Controllers\CustomerController::class, 'addressDelete'])->name('customer.delete');
        
    });

    Route::prefix('video-booking')->group(function(){
        Route::post('/addOrEdit', [App\Http\Controllers\VideoBookingController::class, 'modalAddEdit'])->name('video-booking.add.edit');
        Route::post('/status', [App\Http\Controllers\VideoBookingController::class, 'changeStatus'])->name('video-booking.status');
        Route::post('/delete', [App\Http\Controllers\VideoBookingController::class, 'delete'])->name('video-booking.delete');
        Route::post('/save', [App\Http\Controllers\VideoBookingController::class, 'saveForm'])->name('video-booking.save');
        Route::get('/export/excel', [App\Http\Controllers\VideoBookingController::class, 'export'])->name('video-booking.export.excel');
        Route::get('/export/pdf', [App\Http\Controllers\VideoBookingController::class, 'exportPdf'])->name('video-booking.export.pdf');
    });
    

});


