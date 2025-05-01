<?php
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\BonusController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\CustomerReviewController;
use App\Http\Controllers\Admin\WebsiteCheackOutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeliveryPartnerController;
use App\Http\Controllers\Admin\DeliveryChargesController;
use App\Http\Controllers\Admin\StoreInformationController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\PoliciesController;
use App\Http\Controllers\Website\PrivacyPolicyController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Admin\VariantValueController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProductSourceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\Website\ContactController;
use App\Http\Controllers\Website\LandingPageController;
use App\Http\Controllers\Website\ShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('authenticate.login');
});

// Middleware for authenticated users with status check
Route::middleware(['auth', 'tenant', 'user.status'])->group(function () {
    
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

    // Settings
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Website Routes
    Route::get('/home', [LandingPageController::class, 'index'])->name('home');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/shop_detail', [ShopController::class, 'details'])->name('shop-detail');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::get('/cart/order-now/{id}', [CartController::class, 'orderNow'])->name('cart.orderNow');
    Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');


    // report
    Route::get('/sales-report', [ReportController::class, 'sales'])->name('sales');
    Route::get('/sales-details', [ReportController::class, 'salesDetails'])->name('sales-details');
    Route::get('/stock-report', [ReportController::class, 'stock'])->name('stock');
    Route::get('/product-performance', [ReportController::class, 'productperformance'])->name('productperformance');
    Route::get('/customer-report', [ReportController::class, 'customerreport'])->name('customerreport');
    Route::get('/financial-report', [ReportController::class, 'financialreport'])->name('financialreport');

    // terms and condition
    Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');
    Route::get('/terms_conditions', [PrivacyPolicyController::class, 'termsConditions'])->name('terms_conditions');

    // check-out
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::delete('/checkout/{id}', [WebsiteCheackOutController::class, 'destroy'])->name('checkout.destroy');

    // New Buy Now Route for Single Product Checkout (Separate Session)
Route::post('/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');


    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');

    // shop-detail
    Route::get('/product-detail/{id}', [ProductController::class, 'show'])->name('product-detail');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

    // Products
    Route::resource('products', ProductController::class);
    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories']);
    Route::get('/get-variant-values/{variantId}', [ProductController::class, 'getVariantValues']);
    Route::get('/get-variants/{product_id}', [ProductController::class, 'getVariants']);
    Route::get('/admin/products', [ProductController::class, 'getProducts']);

    // product source
    Route::resource('product-source', ProductSourceController::class);

    // Categories & Subcategories
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class)->only(['store', 'update', 'destroy']);

    // Variants & Variant Values
    Route::resource('variants', VariantController::class);
    Route::resource('variant-values', VariantValueController::class)->only(['store', 'update', 'destroy']);

    //Expense
    Route::resource('expense-categories', ExpenseCategoryController::class);
    Route::resource('expenses', ExpenseController::class);

    Route::resource('expenses-details', ExpenseController::class);

    // Customers
    Route::resource('customers', CustomerController::class);
    Route::get('/admin/customers', [CustomerController::class, 'getCustomers']);

    // Orders
    Route::resource('orders', OrderController::class);
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('orders', OrderController::class);
    });
    Route::get('orders/invoice/{id}', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Delivery & Website Settings
    Route::get('delivery-partners', [DeliveryPartnerController::class, 'index']);
    Route::post('delivery-partners/{slug}/save', [DeliveryPartnerController::class, 'save'])->name('delivery-partners.save');
    Route::resource('website-checkout', WebsiteCheackOutController::class);
    Route::resource('customer-review', CustomerReviewController::class);
    Route::resource('delivery_charges', DeliveryChargesController::class);
    Route::resource('store_information', StoreInformationController::class);
    Route::resource('domain', DomainController::class);
    Route::resource('policies', PoliciesController::class);
    Route::resource('reference', ReferenceController::class);
    Route::resource('bonus', BonusController::class);
});

// Admin & Manager Only Routes
Route::middleware(['auth', 'tenant', 'user.status', 'role:Admin,Manager'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

// Authentication Routes check
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.attempt');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
