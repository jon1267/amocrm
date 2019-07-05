<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Contact;
use Carbon\Carbon;

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
        $code = (int) $code;

        //dd(json_decode($out), $code);

        if ( ($code === 200) || ($code === 204)) {
            return redirect()->route('admin.home')
                ->with(['status'=>'Contact was added']);
        } else {
            return redirect()->route('admin.home')
                ->with(['error'=>'Error adding contact.']);
        }

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
        $code = (int) $code;

        curl_close($curl);

        if (($code !== 200) && ($code !== 204)) {
            return redirect()->route('admin.home')
                ->with(['error' => 'Error reading contacts']);
        }

        $Response = json_decode($out, true);
        $Response = $Response['_embedded']['items'];

        $this->saveContacts($Response);

        return redirect()->route('admin.home');

    }

    public function saveContacts(array $contacts)
    {
        try {

            foreach ($contacts as $contact) {
                Contact::create([
                    'contact_id' => $contact['id'],
                    'name' => $contact['name'],
                    'responsible_user_id' => $contact['responsible_user_id'],
                    'created_by' => $contact['created_by'],
                    'amo_created_time' => Carbon::createFromTimestamp($contact['created_at'])
                ]);
            }

        } catch (Exception $e) {
            echo 'Error message: ', $e->getMessage(), "\n";
        }

        return;
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
        $code = (int) $code;

        curl_close($curl);

        //dd(json_decode($out), $code);

        if ($code === 200) {
            return redirect()->route('admin.home')
                ->with(['status' => 'Вы успешно авторизованы']);
        }

        return redirect()->route('admin.home')
            ->with(['error' => 'Ошибка авторизации amoCRM']);

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
