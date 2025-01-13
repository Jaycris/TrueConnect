<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/auth.php';

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('2fa');
    Route::get('/profile/{id}', [UserController::class, 'view'])->name('profile')->middleware('2fa');
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.dashboard')->middleware('2fa');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // User
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users')->middleware('2fa');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create')->middleware('2fa');
    Route::post('/admin/users/post', [UserController::class, 'store'])->name('admin.users.post')->middleware('2fa');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit')->middleware('2fa');
    Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update')->middleware('2fa');
    Route::delete('/admin/users/{id}/delete', [UserController::class, 'destroy'])->name('admin.users.delete')->middleware('2fa');

    Route::get('/admin/2fa-recipient', [SettingsController::class, 'show'])->name('admin.2fa-recipient')->middleware('2fa');
    Route::put('/admin/2fa-recipient-update', [SettingsController::class, 'updateAdmin'])->name('admin.updateAdmin')->middleware('2fa');

    //Department
    Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('admin.department')->middleware('2fa');
    Route::get('/admin/departments/create', [DepartmentController::class, 'create'])->name('admin.department.create')->middleware('2fa');
    Route::post('/admin/departments/post', [DepartmentController::class, 'store'])->name('admin.department.post')->middleware('2fa');
    Route::get('/admin/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('admin.department.edit')->middleware('2fa');
    Route::post('/admin/departments/{id}/update', [DepartmentController::class, 'update'])->name('admin.department.update')->middleware('2fa');
    Route::delete('/admin/departments/{id}/delete', [DepartmentController::class, 'destroy'])->name('admin.department.delete')->middleware('2fa');
    Route::post('/admin/departments/{id}/delete/check', [DepartmentController::class, 'checkDelete'])->name('admin.department.delete.check')->middleware('2fa');

    // Designation
    Route::get('/admin/designations', [DesignationController::class, 'index'])->name('admin.designations')->middleware('2fa');
    Route::get('/admin/designations/create', [DesignationController::class, 'create'])->name('admin.designation.create')->middleware('2fa');
    Route::post('/admin/designations/post', [DesignationController::class, 'store'])->name('admin.designation.post')->middleware('2fa');
    Route::get('/admin/designations/{id}/edit', [DesignationController::class, 'edit'])->name('admin.designation.edit')->middleware('2fa');
    Route::post('/admin/designations/{id}/update', [DesignationController::class, 'update'])->name('admin.designation.update')->middleware('2fa');
    Route::delete('/admin/designations/{id}/delete', [DesignationController::class, 'destroy'])->name('admin.designation.delete')->middleware('2fa');
    Route::post('/admin/designations/{id}/delete/check', [DesignationController::class, 'checkDesignation'])->name('admin.designation.delete.check')->middleware('2fa');

    // Customer
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index')->middleware('2fa');
    Route::get('/customers/distro', [CustomerController::class, 'distroLeads'])->name('customers.distro');
    Route::post('/customers/unassigned', [CustomerController::class, 'unassignLeads'])->name('customers.unassignLeads');
    Route::get('/customers/returned', [CustomerController::class, 'returnedLeads'])->name('customers.returned');   
    Route::get('/mycustomers', [CustomerController::class, 'userCustomer'])->name('employee.mycustomer')->middleware('2fa');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create')->middleware('2fa');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store','checkRole');
    Route::post('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update',);
    Route::put('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/check-new-leads', [CustomerController::class, 'checkNewLeads']);
    Route::get('/check-verified-leads', [CustomerController::class, 'checkVerifiedLeads']);
    Route::get('/check-assigned-leads', [CustomerController::class, 'checkAssignedLeads']);
    Route::get('/my-assigned-leads', [CustomerController::class, 'fetchEmployeeAssignedLeads'])->name('customers.fetchEmployeeAssigned');
    Route::get('/assigned-leads', [CustomerController::class, 'fetchAssignedLeads'])->name('customers.fetchAssigned');    
    Route::get('/verified-leads', [CustomerController::class, 'fetchVerifiedLeads'])->name('customers.VerifiedLeads');
    Route::get('/returned-leads', [CustomerController::class, 'fetchReturnedLeads'])->name('customers.fetchReturned');    
    Route::get('/check-return-leads', [CustomerController::class, 'checkReturnLeads']);
    Route::get('/customers/{id}/status', [CustomerController::class, 'getCustomerData'])->name('customers.data');
    Route::post('/update-status', [CustomerController::class, 'updateStatus'])->name('update.status');
    Route::post('/customers/{id}/view', [CustomerController::class, 'markAsViewed']);
    Route::get('/customers/{customer}/assign', [CustomerController::class, 'showAssignForm'])->name('customers.assign');
    Route::post('/customers/assign', [CustomerController::class, 'assignEmployees'])->name('customers.assignEmployees');
    Route::post('/customers/return', [CustomerController::class, 'returnToLeadMiner'])->name('customers.return');    
    Route::post('/customers/reassign', [CustomerController::class, 'reassignToEmployee'])->name('customers.reassign');

    // Sales
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index')->middleware('2fa');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create')->middleware('2fa');
    Route::get('/sales/view', [SalesController::class, 'view'])->name('sales.view')->middleware('2fa');
    Route::get('/sales/{id}/edit', [SalesController::class, 'edit'])->name('sales.edit')->middleware('2fa');
    Route::post('/get-package-sold', [SalesController::class, 'getPackageSoldByType'])->name('getPackageSoldByType');
    Route::post('/get-events', [SalesController::class, 'getEventsByPackageSold'])->name('getEventsByPackageSold');
    Route::post('/sales/store', [SalesController::class, 'store'])->name('sales.store')->middleware('2fa');
    Route::get('/get-authors-suggestions', [SalesController::class, 'getAuthorSuggestions']);
    Route::get('/get-book-titles', [SalesController::class, 'getBookTitles']);
    
    // Package Type
    Route::get('/package-type', [PackagesController::class, 'packType'])->name('pack-type.index')->middleware('2fa');
    Route::get('/package-type/create', [PackagesController::class, 'createPackType'])->name('pack-type.create')->middleware('2fa');
    Route::get('/package-type/view/{id}', [PackagesController::class, 'viewPackType'])->name('pack-type.view')->middleware('2fa');
    Route::post('/package-type/post', [PackagesController::class, 'storePackType'])->name('pack-type.store')->middleware('2fa');
    Route::get('/package-type/{id}/edit', [PackagesController::class, 'editPackType'])->name('pack-type.edit')->middleware('2fa');
    Route::post('/package-type/{id}/update', [PackagesController::class, 'updatePackType'])->name('pack-type.update')->middleware('2fa');
    Route::delete('/package-type/{id}/delete', [PackagesController::class, 'destroyPackType'])->name('pack-type.delete')->middleware('2fa');
    
    // Package Sold
    Route::get('/package-sold', [PackagesController::class, 'packSold'])->name('pack-sold.index')->middleware('2fa');
    Route::get('/package-sold/create', [PackagesController::class, 'createPackSold'])->name('pack-sold.create')->middleware('2fa');
    Route::get('/package-sold/view/{id}', [PackagesController::class, 'viewPackSold'])->name('pack-sold.view')->middleware('2fa');
    Route::post('/package-sold/post', [PackagesController::class, 'storePackSold'])->name('pack-sold.store')->middleware('2fa');
    Route::get('/package-sold/{id}/edit', [PackagesController::class, 'editPackSold'])->name('pack-sold.edit')->middleware('2fa');
    Route::post('/package-sold/{id}/update', [PackagesController::class, 'updatePackSold'])->name('pack-sold.update')->middleware('2fa');
    Route::delete('/package-sold/{id}/delete', [PackagesController::class, 'destroyPackSold'])->name('pack-sold.delete')->middleware('2fa');
   
    // Services
    Route::get('/events', [PackagesController::class, 'event'])->name('events.index')->middleware('2fa');
    Route::get('/events/create', [PackagesController::class, 'createEvent'])->name('event.create')->middleware('2fa');
    Route::get('/events/view/{id}', [PackagesController::class, 'viewEvent'])->name('event.view')->middleware('2fa');
    Route::post('/events/post', [PackagesController::class, 'storeEvent'])->name('event.store')->middleware('2fa');
    Route::get('/event/{id}/edit', [PackagesController::class, 'editEvent'])->name('event.edit')->middleware('2fa');
    Route::post('/event/{id}/update', [PackagesController::class, 'updateEvent'])->name('event.update')->middleware('2fa');
    Route::delete('/event/{id}/delete', [PackagesController::class, 'destroyEvent'])->name('event.delete')->middleware('2fa');

    //PaymentMethod
    Route::get('/payment-method', [PackagesController::class, 'method'])->name('method.index')->middleware('2fa');
    Route::get('/payment-method/create', [PackagesController::class, 'createMethod'])->name('method.create')->middleware('2fa');
    Route::post('/payment-method/post', [PackagesController::class, 'storeMethod'])->name('method.store')->middleware('2fa');
    Route::get('/payment-method/{id}/edit', [PackagesController::class, 'editMethod'])->name('method.edit')->middleware('2fa');
    Route::post('/payment-method/{id}/update', [PackagesController::class, 'updateMethod'])->name('method.update')->middleware('2fa');
    Route::get('/payment-method/view/{id}', [PackagesController::class, 'viewMethod'])->name('method.view')->middleware('2fa');
    Route::delete('/payment-method/{id}/delete', [PackagesController::class, 'destroyMethod'])->name('method.delete')->middleware('2fa');

    // 2FA routes
    Route::get('/2fa', [AuthenticatedSessionController::class, 'showTwoFactorForm'])->name('auth.2fa');
    Route::post('/verify-2fa', [AuthenticatedSessionController::class, 'verifyTwoFactor'])->name('verify.2fa'); // Ensure this matches

    //Password reset
    Route::get('/password/reset', [AuthenticatedSessionController::class, 'showPasswordResetForm'])->name('password.reset.prompt')->middleware('2fa');;
    Route::post('/password/reset', [AuthenticatedSessionController::class, 'handlePasswordReset'])->name('password.reset.handle')->middleware('2fa');;
});


Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('2fa')->name('users');
    Route::get('/users/create', [UserController::class, 'store'])->middleware('2fa')->name('users.create');
});