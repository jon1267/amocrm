<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmoDataController extends Controller
{
    public function create(Request $request)
    {

        $this->validator($request->all())->validate();

        $subdomain = env('AMO_USER_DOMAIN');
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v2/contacts';
        $contacts = [];
        $contacts['add'] = [
            [
                'name' => $request->name,
                'responsible_user_id' => '3619813',
                'created_by' => '3619813',
                'leads' => [
                    'name' => $request->lead,
                ],
                'custom_fields' => [
                    [
                        'id'=> '485823',
                        'values' => ['value'=> $request->phone],
                    ],
                    [
                        'id'=> '485825',
                        'values' => ['value'=> $request->email],

                    ],
                ]
            ]
        ];

        dd($contacts);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($contacts));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        dd(json_decode($out), $code);


    }

    public function upload()
    {
        $subdomain = env('AMO_USER_DOMAIN');
        $link = 'https://' . $subdomain . '.amocrm.ru/api/v2/contacts';
        //$link = 'https://' . $subdomain . '.amocrm.ru/api/v2/companies';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt'); //PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt'); //PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $Response = json_decode($out, true);
        $Response = $Response['_embedded']['items'];

        dd($Response, $code);

    }

    public function apiAuth()
    {
        $subdomain = env('AMO_USER_DOMAIN');
        $link = 'https://' . $subdomain . '.amocrm.ru/private/api/auth.php?type=json';
        $user = [
            'USER_LOGIN' => env('AMO_USER_LOGIN'),
            'USER_HASH' => env('AMO_USER_HASH'),
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        dd(json_decode($out), $code);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'responsible_user_id' => 'required',
            'created_by' => 'required',
            'lead' => 'required',
            'phone' => 'required',
            'email' => 'required|email',

        ]);
    }


}
