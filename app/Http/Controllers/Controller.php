<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $api_key;
    public function setApiKey($key) {
      $this->api_key = $key;
    }
    public function getResultByUrl($url){
      $client = new \GuzzleHttp\Client();
      $key = config('app.didww_key');
      $res = $client->request('GET', 'https://api.didww.com/v3/'.$url,
          [
              'headers' => [
                  'Api-key' => $key ,
                  'Accept' => 'application/vnd.api+json',
                  "Content-Type" => "application/vnd.api+json"
              ],
          ]
      );
      $result = json_decode($res->getBody()->getContents(), true);
      return $result;
    }

    public function getArrayById($array, $id) {
      foreach ($array as $key => $item) {
        if($item['id'] == $id) return $item;
      }
    }
    public function getTypeById($id) {
      $client = new \GuzzleHttp\Client();
      $key = config('app.didww_key');
      $res = $client->request('GET', 'https://api.didww.com/v3/did_group_types/'.$id,
          [
              'headers' => [
                  'Api-key' => $key ,
                  'Accept' => 'application/vnd.api+json',
                  "Content-Type" => "application/vnd.api+json"
              ],
          ]
      );
      $result = json_decode($res->getBody()->getContents(), true);
      return $result['data'];
    }

}
