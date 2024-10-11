<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\CustomerController;
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

    //User
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users')->middleware('2fa');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create')->middleware('2fa');
    Route::post('/admin/users/post', [UserController::class, 'store'])->name('admin.users.post')->middleware('2fa');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit')->middleware('2fa');
    Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update')->middleware('2fa');
    Route::delete('/admin/users/{id}/delete', [UserController::class, 'destroy'])->name('admin.users.delete')->middleware('2fa');

    //Department
    Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('admin.department')->middleware('2fa');
    Route::get('/admin/departments/create', [DepartmentController::class, 'create'])->name('admin.department.create')->middleware('2fa');
    Route::post('/admin/departments/post', [DepartmentController::class, 'store'])->name('admin.department.post')->middleware('2fa');
    Route::get('/admin/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('admin.department.edit')->middleware('2fa');
    Route::post('/admin/departments/{id}/update', [DepartmentController::class, 'update'])->name('admin.department.update')->middleware('2fa');
    Route::delete('/admin/departments/{id}/delete', [DepartmentController::class, 'destroy'])->name('admin.department.delete')->middleware('2fa');
    Route::post('/admin/departments/{id}/delete/check', [DepartmentController::class, 'checkDelete'])->name('admin.department.delete.check')->middleware('2fa');

    //Designation
    Route::get('/admin/designations', [DesignationController::class, 'index'])->name('admin.designations')->middleware('2fa');
    Route::get('/admin/designations/create', [DesignationController::class, 'create'])->name('admin.designation.create')->middleware('2fa');
    Route::post('/admin/designations/post', [DesignationController::class, 'store'])->name('admin.designation.post')->middleware('2fa');
    Route::get('/admin/designations/{id}/edit', [DesignationController::class, 'edit'])->name('admin.designation.edit')->middleware('2fa');
    Route::post('/admin/designations/{id}/update', [DesignationController::class, 'update'])->name('admin.designation.update')->middleware('2fa');
    Route::delete('/admin/designations/{id}/delete', [DesignationController::class, 'destroy'])->name('admin.designation.delete')->middleware('2fa');
    Route::post('/admin/designations/{id}/delete/check', [DesignationController::class, 'checkDesignation'])->name('admin.designation.delete.check')->middleware('2fa');

    //Customer
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index')->middleware('2fa');
    Route::get('/mycustomers', [CustomerController::class, 'userCustomer'])->name('employee.mycustomer')->middleware('2fa');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create')->middleware('2fa');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('2fa');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store','checkRole');
    Route::post('/customers/{id}/update', [CustomerController::class, 'update'])->name('customers.update',);
    Route::get('/customers/{id}', [CustomerController::class, 'show']);
    Route::get('/check-new-leads', [CustomerController::class, 'checkNewLeads']);
    Route::get('/check-verified-leads', [CustomerController::class, 'checkVerifiedLeads']);
    Route::get('/check-assigned-leads', [CustomerController::class, 'checkAssignedLeads']);
    Route::get('/my-assigned-leads', [CustomerController::class, 'fetchEmployeeAssignedLeads'])->name('customers.fetchEmployeeAssigned');
    Route::get('/assigned-leads', [CustomerController::class, 'fetchAssignedLeads'])->name('customers.fetchAssigned');    
    Route::get('/verified-leads', [CustomerController::class, 'fetchVerifiedLeads'])->name('customers.index');
    Route::get('/returned-leads', [CustomerController::class, 'fetchReturnedLeads'])->name('customers.fetchReturned');    
    Route::get('/check-return-leads', [CustomerController::class, 'checkReturnLeads']);
    Route::get('/customers/{id}/status', [CustomerController::class, 'getCustomerData'])->name('customers.data');
    Route::post('/update-status', [CustomerController::class, 'updateStatus'])->name('update.status');
    Route::post('/customers/{id}/view', [CustomerController::class, 'markAsViewed']);
    Route::get('/customers/{customer}/assign', [CustomerController::class, 'showAssignForm'])->name('customers.assign');
    Route::get('/customers/{customer}/assign', [CustomerController::class, 'showAssignForm'])->name('customers.assign');
    Route::post('/customers/assign', [CustomerController::class, 'assignEmployees'])->name('customers.assignEmployees');
    Route::post('/customers/return', [CustomerController::class, 'returnToLeadMiner'])->name('customers.return');    
    Route::post('/customers/reassign', [CustomerController::class, 'reassignToEmployee'])->name('customers.reassign');
    

    // 2FA routes
    Route::get('/2fa', [AuthenticatedSessionController::class, 'showTwoFactorForm'])->name('auth.2fa');
    Route::post('/verify-2fa', [AuthenticatedSessionController::class, 'verifyTwoFactor'])->name('verify.2fa'); // Ensure this matches
});


Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->middleware('2fa')->name('users');
    Route::get('/users/create', [UserController::class, 'store'])->middleware('2fa')->name('users.create');
});