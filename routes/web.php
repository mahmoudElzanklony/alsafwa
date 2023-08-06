<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrivillagesController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EngineersController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\ServicesRequestsController;
use App\Http\Controllers\NeighborhoodsController;
use App\Http\Controllers\ClientsCostsController;
use App\Http\Controllers\OfficePreviewController;
use App\Http\Controllers\EngineeringDrawingController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\PrivillageInfoController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\CompaniesBranchesController;
use App\Http\Controllers\InfoDataController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\DeletesController;
use App\Http\Controllers\ExporterController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\DestinationsController;
/*
|--------------------------------------------------------------------------
| Web Routes
C:\Users\mahmoud\Documents\zoom\2022-06-18 22.53.08 محمود الزنكلونى's zoom meeting
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// make middleware to detect id at url and sure its url true of service_request




Route::group(['middleware'=>['auth'] ],function(){
    Route::get('/', [WelcomeController::class,'index']);
    Route::post('/upload', [WelcomeController::class,'upload']);
    Route::get('/privillages', [PrivillagesController::class,'index']);
    Route::get('/users', [UsersController::class,'index']);
    Route::get('/companies-branches', [CompaniesBranchesController::class,'index']);
    Route::get('/info-data', [InfoDataController::class,'index']);
    Route::get('/charts', [ChartsController::class,'index']);
    Route::get('/reports', [ReportsController::class,'index']);
    Route::get('/deletes', [DeletesController::class,'index']);
    Route::get('/exporters', [ExporterController::class,'index']);
    Route::get('/countries', [CountriesController::class,'index']);
    Route::get('/destinations', [DestinationsController::class,'index']);

});




Route::group(['middleware'=>['auth'] ],function(){
    Route::get('/all-statics',[WelcomeController::class,'statics']);
    Route::get('/user-data',[UsersController::class,'index']);

    Route::post('/all-statics/filter',[WelcomeController::class,'statics_data']);
    //------------------------------- posts requests-----------------------------

    // save user data
    Route::post('/users/saveuser', [UsersController::class,'save']);
    // save branch data
    Route::post('/breanches/save', [CompaniesBranchesController::class,'save']);
    // save info data
    Route::post('/infodata/save', [InfoDataController::class,'save']);
    // save info data
    Route::post('/exporters/save', [ExporterController::class,'save']);
    // save info data
    Route::post('/countries/save', [CountriesController::class,'save']);
    // save info data
    Route::post('/destinations/save', [DestinationsController::class,'save']);




    // add new role
    Route::post('/saverole', [PrivillagesController::class,'saverole']);
    // save client
    Route::post('/clients/save', [ClientsController::class,'save']);
    // save employee
    Route::post('/employees/save', [EmployeesController::class,'save']);
    // save engineer
    Route::post('/engineers/save', [EngineersController::class,'save']);
    // save service
    Route::post('/services/save', [ServicesController::class,'save']);
    // save service request
    Route::post('/servicerequest/save', [ServicesRequestsController::class,'save']);
    // save neighborhoods
    Route::post('/neighborhoods/save', [NeighborhoodsController::class,'save']);
    // save clientscosts
    Route::post('/clientscosts/save', [ClientsCostsController::class,'save']);
    // save clientscosts
    Route::post('/officepreview/save', [OfficePreviewController::class,'save']);
    // save engineering-draw
    Route::post('/engineering-draw/save', [EngineeringDrawingController::class,'save']);
    // save engineering-draw
    Route::post('/internal-engineering-draw/save', [EngineeringDrawingController::class,'saveInternal']);
    // save document
    Route::post('/documents/save', [DocumentsController::class,'save']);
    // save privillagedata
    Route::post('/privillagedata/save', [PrivillageInfoController::class,'save']);
    // save licence
    Route::post('/licencedata/save', [LicenceController::class,'save']);
    Route::post('/servicesrequests/updatedate', [ServicesRequestsController::class,'updatedate']);
    // delivery date of service request
    Route::post('/servicesrequest/deliverydate', [ServicesRequestsController::class,'deliverydate']);
    // save user data [ personal data ]
    Route::post('/userdata/save', [UsersController::class,'save']);
    // save user data [ company info data ]
    Route::post('/companyinfo/save', [CompanyInfoController::class,'save']);
    // filter data peer year
    Route::post('/chart/filter', [ChartsController::class,'filter']);




    // filter data depend on type
    Route::post('/servicesrequests/filterdata',[ServicesRequestsController::class,'filter_data']);

    //------------------------------- public requests-----------------------------
    Route::post('/delete', [GeneralController::class,'delete']);
    Route::post('/restore-data', [GeneralController::class,'restore']);

});






Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'login_auth']);
Route::get('/logout', [AuthController::class,'logout'])->middleware('auth');
