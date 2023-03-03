<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: gxk
 * @Date: 2023-03-01 16:58:22
 * @LastEditTime: 2023-03-02 10:04:17
 */

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

Route::get('/headers', function () {
    return view('welcome');
});

Route::get('/', function () {
    dd(1);
});
