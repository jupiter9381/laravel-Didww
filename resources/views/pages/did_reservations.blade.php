@extends('layouts.main')

@section('content')
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Reservation Detail</h3>
        </div>
    </div>
    <div class="content-body">
      <div class="row">
        <div class="col-6">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title">DID Reservation Details</h4>
            </div>
            <div class="card-content collapse show">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th width="30%">Number</th>
                        <td class="text-center">{{$reservation['number']}}</td>
                      <tr>
                      <tr>
                        <th width="30%">Expiration</th>
                        <td class="text-center">{{$reservation['expire_at']}}</td>
                      <tr>
                      <tr>
                        <th width="30%">Description</th>
                        <td class="text-center">{{$reservation['description']}}</td>
                      <tr>
                      <tr>
                        <th width="30%">Created At</th>
                        <td class="text-center">{{$reservation['created_at']}}</td>
                      <tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title">DID Group Details</h4>
            </div>
            <div class="card-content collapse show">
              <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th width="30%">Country</th>
                      <td class="text-center">{{$reservation['country']}}</td>
                    <tr>
                    <tr>
                      <th width="30%">Area Name</th>
                      <td class="text-center">{{$reservation['area']}}</td>
                    <tr>
                    <tr>
                      <th width="30%">Did Group Type</th>
                      <td class="text-center">{{$reservation['type']}}</td>
                    <tr>
                    <tr>
                      <th width="30%">Features</th>
                      <td class="text-center">
                        @if(array_search("voice", $reservation['features']) > -1)
                          <i class="fa fa-check mr-1"></i>
                        @else
                          <i class="fa fa-times mr-1"></i>
                        @endif

                        @if(array_search("t38", $reservation['features']) > -1)
                          <i class="fa fa-check mr-1"></i>
                        @else
                          <i class="fa fa-times mr-1"></i>
                        @endif
                        @if(array_search("sms", $reservation['features']) > -1)
                          <i class="fa fa-check mr-1"></i>
                        @else
                          <i class="fa fa-times mr-1"></i>
                        @endif
                      </td>
                    <tr>
                    <tr>
                      <th width="30%">Metered</th>
                      <td class="text-center">
                        @if($reservation['metered'] == true)
                         <i class="fa fa-check mr-1"></i>
                        @else
                         <i class="fa fa-times mr-1"></i>
                        @endif
                      </td>
                    <tr>
                    <tr>
                      <th width="30%">Allow Additional Channels</th>
                      <td class="text-center">{{$reservation['add_channel']}}</td>
                    <tr>
                    <tr>
                      <th width="30%">Stock Keeping Units</th>
                      <td class="text-center">
                        <select class="form-control reservation_unit">
                          <option>0</option>
                          <option>2</option>
                        </select>
                      </td>
                    <tr>
                    <tr>
                      <th width="30%">NRC</th>
                      <td class="text-center reservation_nrc_0">{{$reservation['did_stocks'][0]['attributes']['setup_price']}}</td>
                      <td class="text-center reservation_nrc_2" style="display: none;">{{$reservation['did_stocks'][1]['attributes']['setup_price']}}</td>
                    <tr>
                    <tr>
                      <th width="30%">MRC</th>
                      <td class="text-center reservation_mrc_0">{{$reservation['did_stocks'][0]['attributes']['monthly_price']}}</td>
                      <td class="text-center reservation_mrc_2" style="display: none;">{{$reservation['did_stocks'][1]['attributes']['monthly_price']}}</td>
                    <tr>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
