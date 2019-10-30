<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Ixudra\Curl\Facades\Curl;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function didLogin(Request $request) {
      $api_key = $request->input("api_key");
      $client = new \GuzzleHttp\Client();

      try {
        $res = $client->request('GET', 'https://api.didww.com/v3/countries',
                      [
                          'headers' => [
                              'Api-key' => $api_key ,
                              'Accept' => 'application/vnd.api+json',
                              "Content-Type" => "application/vnd.api+json"
                          ],
                      ]
                  );
        $result = json_decode($res->getBody()->getContents(), true);
        $request->session()->put('is_logged', 'true');
        $request->session()->put('api_key', $api_key);
        config(['app.api_key' => $api_key]);
        return redirect('/available_dids');
      } catch (\GuzzleHttp\Exception\ClientException $e){
        $responseBody = $e->getResponse()->getBody(true);
        $request->session()->flash("error", "Api key is not correct.");
        return redirect("/login");
      }
    }

    public function logout(Request $request){
      $request->session()->forget('is_logged');
      $request->session()->forget('api_key');
      return redirect('/login');
    }
}
