<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class DidsController extends Controller
{
    //
    public $countries;
    public $types;
    public $cities;
    public function __construct()
    {
        $this->countries = $this->getResultByUrl('countries')['data'];
        $this->types = $this->getResultByUrl("did_group_types")['data'];
        $this->cities = $this->getResultByUrl("cities?include=country")['data'];
       // $this->middleware('isLogged');
    }

    public function available(Request $request){
      $key = $request->session()->get('api_key');
      $client = new \GuzzleHttp\Client();

      $countries = $this->countries;
      $types = $this->types;
      $cities = $this->cities;
      $regions = $this->getResultByUrl("regions")['data'];

      $available_dids = $this->getResultByUrl("available_dids?include=did_group,did_group.stock_keeping_units,did_group.country,did_group.did_group_type&page[number]=1&page[size]=10");
      $dids_data = $available_dids['data'];
      $dids_included = $available_dids['included'];

      $did_groups = array();
      $did_stocks = array();
      foreach ($dids_included as $key => $value) {
        if($value['type'] == "did_groups") array_push($did_groups, $value);
        if($value['type'] == "stock_keeping_units") array_push($did_stocks, $value);
      }

      $dids = array();
      foreach ($dids_data as $key => $did) {
        $did_id = $did["id"];
        $did_number = $did["attributes"]['number'];
        $did_group_id = $did["relationships"]['did_group']['data']['id'];

        $did_group = $this->getArrayById($did_groups, $did_group_id);


        $country_id = $did_group['relationships']['country']['data']['id'];
        $type_id = $did_group['relationships']['did_group_type']['data']['id'];

        $country = $this->getArrayById($countries, $country_id);
        $type = $this->getArrayById($types, $type_id);
        $features = $did_group['attributes']['features'];
        $metered = $did_group['attributes']['is_metered'];
        $add_channel = $did_group['attributes']['allow_additional_channels'];
        if($add_channel == true) $add_channel = "Yes";
        else $add_channel = "No";

        $stock_keeping_units = $did_group['relationships']['stock_keeping_units']['data'];

        $stocks = array();
        foreach ($stock_keeping_units as $key => $unit) {
          $unit_id = $unit['id'];
          $stock = $this->getArrayById($did_stocks, $unit_id);
          array_push($stocks, $stock);
        }
        $item = array("id" => $did_id,
                      "number" => $did_number,
                      "group_id" => $did_group_id,
                      "country" => $country['attributes']['name'],
                      "type" => $type['attributes']['name'],
                      "area" => $did_group['attributes']['area_name'],
                      "features" => $features,
                      "metered" => $metered,
                      "add_channel" => $add_channel,
                      "stocks" => $stocks);
        array_push($dids, $item);
      }
      return view("pages.available_dids", compact('types', 'countries', 'dids'));
    }

    public function did_reservation(Request $request) {
      $key = $request->session()->get('api_key');
      $description = $request->input("description");
      $did_id = $request->input("did_id");
      $data = array(
        "data" => array(
          "type" => "did_reservations",
          "attributes" => array(
            "description" => $description
          ),
          "relationships" => array(
            "available_did" => array(
              "data" => array(
                "type" => "available_dids",
                "id" => $did_id
              )
            )
          )
        )
      );
      /* API URL */
      $url = 'https://api.didww.com/v3/did_reservations';

      /* Init cURL resource */
      $ch = curl_init($url);

      /* Array Parameter Data */

      /* pass encoded JSON string to the POST fields */
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

      /* set the content type json */
      curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
              'Api-Key:'.$key,
              'Accept:application/vnd.api+json',
              "Content-Type:application/vnd.api+json"
           )
      );

      /* set return type json */
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      /* execute request */
      $result = curl_exec($ch);

      /* close cURL resource */
      curl_close($ch);

      echo json_encode($result);
    }

    public function view_reservation($id) {
      $reservation = $this->getResultByUrl("did_reservations/".$id."?include=available_did,available_did.did_group,available_did.did_group.stock_keeping_units,available_did.did_group.country,available_did.did_group.did_group_type,available_did.did_group.city");
      $reservation_data = $reservation['data'];
      $did = $reservation['included'][0];
      $did_group = $reservation['included'][1];
      $did_stock = array();
      foreach ($reservation['included'] as $key => $value) {
        if($value['type'] == "stock_keeping_units")
          array_push($did_stock, $value);
      }

      $country_id = $did_group['relationships']['country']['data']['id'];
      $country = $this->getArrayById($this->countries, $country_id);

      $type_id = $did_group['relationships']['did_group_type']['data']['id'];
      $type = $this->getArrayById($this->types, $type_id);

      $add_channel = $did_group['attributes']['allow_additional_channels'];
      if($add_channel == true) $add_channel = "Yes";
      else $add_channel = "No";

      $reservation = array(
        "number" => $did['attributes']['number'],
        "description" => $reservation_data['attributes']['description'],
        'created_at' => date('Y-m-d h:i:s', strtotime($reservation_data['attributes']['created_at'])),
        "expire_at" =>  date('Y-m-d h:i:s', strtotime($reservation_data['attributes']['expire_at'])),
        "country" => $country['attributes']['name'],
        "area" => $did_group['attributes']['area_name'],
        "type" => $type['attributes']['name'],
        "features" => $did_group['attributes']['features'],
        "metered" => $did_group['attributes']['is_metered'],
        "add_channel" => $add_channel,
        "did_stocks" => $did_stock
      );

      return view("pages.did_reservations", compact('reservation'));
    }

    public function search(Request $request){
      $country = $request->input('country');
      $needs_registration = $request->input('needs_registration');
      $group_type = $request->input('group_type');
      $did_group_id = $request->input('did_group_id');
      $number = $request->input('number');
      $city = $request->input('city');
      $filters = array(
        "country" => $country,
        "needs_registration" => $needs_registration,
        'group_type' => $group_type,
        "did_group_id" => $did_group_id,
        "number" => $number
      );
      $filter_string = "";
      if($needs_registration != "") $filter_string .= "filter[did_group.needs_registration]=".$needs_registration;
      if($country != "") $filter_string .= "&filter[country.id]=".$country;
      if(count($group_type) > 0) {
        foreach ($group_type as $key => $type) {
          $filter_string .= "&filter[did_group_type.id]=".$type;
        }
      }
      if($did_group_id != "") $filter_string .= "&filter[did_group.id]=".$did_group_id;
      if($number != "") $filter_string .= "&filter[number_contains]=".$number;
      if($city != "") $filter_string .= "&filter[city.id]=".$city;
      
      $key = $request->session()->get('api_key');
      $client = new \GuzzleHttp\Client();

      $countries = $this->countries;
      $types = $this->types;
      $cities = $this->cities;
      $regions = $this->getResultByUrl("regions")['data'];

      $available_dids = $this->getResultByUrl("available_dids?".$filter_string."&include=did_group,did_group.stock_keeping_units,did_group.country,did_group.did_group_type&page[number]=1&page[size]=10");

      // echo "<pre>";
      // var_dump($available_dids);
      // echo "</pre>";
      // exit();
      $dids = array();

      if(count($available_dids['data']) > 0){
        $dids_data = $available_dids['data'];
        $dids_included = $available_dids['included'];

        $did_groups = array();
        $did_stocks = array();
        foreach ($dids_included as $key => $value) {
          if($value['type'] == "did_groups") array_push($did_groups, $value);
          if($value['type'] == "stock_keeping_units") array_push($did_stocks, $value);
        }

        
        foreach ($dids_data as $key => $did) {
          $did_id = $did["id"];
          $did_number = $did["attributes"]['number'];
          $did_group_id = $did["relationships"]['did_group']['data']['id'];
          $did_group = $this->getArrayById($did_groups, $did_group_id);


          $country_id = $did_group['relationships']['country']['data']['id'];
          $type_id = $did_group['relationships']['did_group_type']['data']['id'];

          $country = $this->getArrayById($this->countries, $country_id);
          $type = $this->getArrayById($this->types, $type_id);
          $features = $did_group['attributes']['features'];
          $metered = $did_group['attributes']['is_metered'];
          $add_channel = $did_group['attributes']['allow_additional_channels'];
          if($add_channel == true) $add_channel = "Yes";
          else $add_channel = "No";

          $stock_keeping_units = $did_group['relationships']['stock_keeping_units']['data'];

          $stocks = array();
          foreach ($stock_keeping_units as $key => $unit) {
            $unit_id = $unit['id'];
            $stock = $this->getArrayById($did_stocks, $unit_id);
            array_push($stocks, $stock);
          }
          $item = array("id" => $did_id,
                        "number" => $did_number,
                        "group_id" => $did_group_id,
                        "country" => $country['attributes']['name'],
                        "type" => $type['attributes']['name'],
                        "area" => $did_group['attributes']['area_name'],
                        "features" => $features,
                        "metered" => $metered,
                        "add_channel" => $add_channel,
                        "stocks" => $stocks);
          array_push($dids, $item);
        }
      }
      
      return view("pages.available_dids", compact('types', 'countries', 'dids', 'filters', 'cities'));
    }
    public function getRegions(Request $request) {
      $country_id = $request->input('country_id');
      $regions = $this->getResultByUrl("regions?filter[country.id]=".$country_id)['data'];
      // if(count($regions) == 0) {
      //   $cities = $this->getResultsByUrl("cities?filter[country.id]=".$country_id)['data'];
      // }
      //$cities = $this->getResultsByUrl("cities?filter[country.id]=".$country_id."&filter[region.id]=".$region_id)['data'];
    
      // if(count($regions) > 0) {
      //   $region_id = $regions[0]['id'];
      //   $cities = $this->getResultsByUrl("cities?filter[country.id]=".$country_id."&filter[region.id]=".$region_id)['data'];
      // } else {
      //   $cities = $this->getResultsByUrl("cities?filter[country.id]=".$country_id)['data'];
      // }
      echo json_encode(array("regions" => $regions, "cities" => count($regions)));
    }
    public function getCitiesByCountry(Request $request) {
      $country_id = $request->input('country_id');
      $cities = $this->getResultByUrl("cities?filter[country.id]=".$country_id)['data'];
      echo json_encode(array("cities" => $cities));
    }
}
