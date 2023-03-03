<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: gxk
 * @Date: 2023-03-01 16:58:22
 * @LastEditTime: 2023-03-02 15:17:05
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/headers', function (Request $request) {
    $headers = $request->headers->all();

    return response()->json([
        'title' => 'serverless',
        'headers' => $headers,
    ]);
});

Route::get('/posts', function (Request $request) {
    $input = $request->all();

    return response()->json([
        'title' => 'serverless',
        'get' => $input
    ]);
});

Route::post('/posts', function (Request $request) {
    $input = $request->all();

    return response()->json([
        'title' => 'serverless',
        'data' => $input
    ]);
});

// 上传文件接口示例
Route::post('/upload', function (Request $request) {
    // 表单中字段为 file
    if ($request->file) {
        // TODO: 这里只是将文件临时存储到 /tmp 下，用户需要根据个人需要存储到持久化服务，比如腾讯云的对象存储、文件存储等。
        $upload = $request->file->store('upload');
        $uploadFile = storage_path() . "/app/" . $upload;
    }

    return response()->json([
        'title' => 'serverless',
        'upload' => $uploadFile ?? null,
    ]);
});

Route::get('/text_login', 'Api\IndexController@textLogin');
Route::get('/text_token', 'Api\TextController@text_token');

Route::post('/pushDisposaApplicationForm', '\App\Http\Controllers\Api\IndexController@pushDisposaApplicationForm');
Route::post('/uploadTargetSettlement', '\App\Http\Controllers\Api\IndexController@uploadTargetSettlement');
Route::post('/approvalPushHighestPrice', '\App\Http\Controllers\Api\IndexController@approvalPushHighestPrice');
Route::post('/getAuctionTargetNum', '\App\Http\Controllers\Api\IndexController@getAuctionTargetNum');
Route::post('/getAuctionInfo', '\App\Http\Controllers\Api\IndexController@getAuctionInfo');
Route::post('/getTargetInfo', '\App\Http\Controllers\Api\IndexController@getTargetInfo');
Route::post('/getTargetStatementList', '\App\Http\Controllers\Api\IndexController@getTargetStatementList');
Route::post('/getTargetParticipationList', '\App\Http\Controllers\Api\IndexController@getTargetParticipationList');
Route::post('/getTargetWatcherInfo', '\App\Http\Controllers\Api\IndexController@getTargetWatcherInfo');
Route::post('/send', '\App\Http\Controllers\Api\TextController@send_succ');
Route::post('/syncCorpore', '\App\Http\Controllers\Api\TextController@syncCorpore');
Route::post('/syncAuction', '\App\Http\Controllers\Api\TextController@syncAuction');
