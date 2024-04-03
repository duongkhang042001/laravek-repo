<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers'
], function ($api) {

    //Account module

    $api->resource('accounts', 'AccountController');

    //Permission module
    $api->get('permissions/{account}', 'PermissionController@index')->where(['account' => '[0-9]+']);

    //Brandname module

    $api->resource('brandnames', 'BrandnameController');

    //Partner module
    $api->resource('partners', 'PartnerController');

    //Campaign module
    $api->get('campaigns', 'CampaignController@index');

    $api->post('campaigns/{id}/confirm', 'CampaignController@confirm');

    //MT Message module
    $api->get('messages', 'MessageController@index');

    //Plan module

    $api->put('plans/{id}', 'PlanController@update');

    $api->get('plans/{id}', 'PlanController@show');

    $api->get('plans', 'PlanController@index');

    //Quota module

    $api->put('quotas/{id}', 'QuotaController@update');

    $api->get('quotas/{id}', 'QuotaController@show');

    $api->get('quotas', 'QuotaController@index');


    // CRU APIs quotas - no cache, only update field "quotas_limit", not update field "partner_id" done
    // CRU APIs plans - cache key "plan:{partner_id}-{telco}-{sms_type}-{region_code}", not create,update field "partner_id", "sms_usage_count", hasmany volume_pricings done

    // CRUD APIs brandnames - k theo partner, unique name. done
    // API create /partners thêm input [brandname_ids] => v3_partner_brandnames relation belongtomany testing

});
