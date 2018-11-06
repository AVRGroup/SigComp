<?php

namespace App\Library;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Slim\Http\Cookies;

class FlarumHelper
{
    /**
     *
     */
    static public function doFlarumLogin() {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://200.131.219.56',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        $cookieJar = new CookieJar();
        $client->request('POST', '/flarum', [
            'cookies' => $cookieJar,
            'form_params' => [
                'identification' => 'projeto',
                'password' => 'prj#game'
            ]
        ]);

        $cookies = new Cookies();

        foreach ($cookieJar->toArray() as $cookie) {
            $cookies->set($cookie['Name'], $cookie['Value']);
        }

        return $cookies;
    }
}