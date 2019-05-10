<?php

use App\PagSeguro\PagSeguro;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/checkout/{id}', function($id){
    $data = [];
    $data['email'] = 'caioalmeidanaweb@gmail.com';
    $data['token'] = '1FE2DC74D7534367AA4BD8853A442DC1';
    $response = (new PagSeguro)->request(PagSeguro::SESSION_SANDBOX,$data);  
    $session = new \SimpleXMLElement($response->getContents());
    $session = $session->id;

    $amount = number_format(521.50,2,'.','');

    return view('store.checkout',compact('id','session','amount'));
});
Route::post('/checkout/{id}', function($id){
 $data = request()->all();
 unset($data['_token']);
 $data['email'] = 'caioalmeidanaweb@gmail.com';
 $data['token'] = '1FE2DC74D7534367AA4BD8853A442DC1';
 $data['paymentMode'] = 'default';
 $data['paymentMethod'] = 'creditCard';
 $data['recceiverEmail'] = 'caioalmeidanaweb@gmail.com';
 $data['currency'] = 'BRL';
 
 $data['senderAreaCode']    = substr($data['senderPhone'],0,2);
 $data['senderPhone']       = substr($data['senderPhone'],2,strlen($data['senderPhone']));
 return json_encode($data);
});
