@extends('layouts.main')

@section('content')
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Available Dids</h3>
        </div>
    </div>
    <div class="content-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
                <h4 class="card-title">Search</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
              <div class="card-body">
                <form action="{{url('/')}}/available_dids/search" method="post">
                  {{csrf_field()}}
                  <div class="row">
                    <div class="col-4 form-group">
                      <div class="row">
                        <div class="col-12 form-group">
                            <div class="text-bold-600 font-medium-2 mb-1">
                                Country:
                            </div>
                            <select class="select2 form-control" name="country">
                              <option value="">Select country...</option>
                              @foreach($countries as $country)
                                <option <?php if($country['id'] == $filters['country']) echo "selected";?> value="{{$country['id']}}">{{$country['attributes']['name']}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6 form-group city_section" <?php if(count($cities) == 0) echo "style='display: none;'"?> >
                          <div class="text-bold-600 font-medium-2 mb-1">
                              City:
                          </div>
                          <select class="select2 form-control" name="city">
                              <option value="">Select city...</option>
                              @if(count($cities) > 0)
                                @foreach($cities as $city)
                                  <option <?php if($filters['city'] == $city['id']) echo "selected";?> value="{{$city['id']}}">{{$city['attributes']['name']}}</option>
                                @endforeach
                              @endif
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-2 form-group">
                      <div class="text-bold-600 font-medium-2 mb-1">
                          Registration
                      </div>
                      <select class="form-control" name="needs_registration">
                        <option value="">any</option>
                        <option <?php if($filters['country'] == "true") echo "selected";?> value="true">Required</option>
                        <option <?php if($filters['needs_registration'] == "false") echo "selected";?> value="false">Not Required</option>
                      </select>
                    </div>
                    <div class="col-2 form-group">
                      <div class="text-bold-600 font-medium-2 mb-1">
                          Number types
                      </div>
                      <div class="skin skin-flat">
                        @if(count($filters['group_type']) > 0)
                          @foreach($types as $type)
                          <fieldset style="min-width: 150px;">
                              <input <?php if(array_search($type['id'], $filters['group_type']) > -1) echo "checked";?> type="checkbox" id="input-15" value="{{$type['id']}}" name="group_type[]">
                              <label for="input-15">{{$type['attributes']['name']}} </label>
                          </fieldset>
                          @endforeach
                        @else
                          @foreach($types as $type)
                          <fieldset style="min-width: 150px;">
                              <input type="checkbox" id="input-15" checked value="{{$type['id']}}" name="group_type[]">
                              <label for="input-15">{{$type['attributes']['name']}} </label>
                          </fieldset>
                          @endforeach
                        @endif
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="row">
                        <div class="col-12 form-group">
                          <div class="text-bold-600 font-medium-2 mb-1">
                              Did Group ID
                          </div>
                          <input type="text" class="form-control" name="did_group_id" value={{$filters['did_group_id']}}>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 form-group">
                          <div class="text-bold-600 font-medium-2 mb-1">
                              Number
                          </div>
                          <input type="text" class="form-control" name="number" value="{{$filters['number']}}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-2">
                        <button class="btn btn-primary">Search</button>
                    </div>
                  </div>
                </form>
                <hr>
                <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Number</th>
                      <th>Country</th>
                      <th>Type</th>
                      <th>Area Name</th>
                      <th class="text-center">Voice | T.38 | SMS</th>
                      <th>Metered</th>
                      <th>Add. channels</th>
                      <th>Stock Keeping Units</th>
                      <th>NRC</th>
                      <th>MRC</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($dids as $key => $did)
                     <tr order="{{$key}}">
                       <td><input type="checkbox"></td>
                       <td>{{$did['number']}}</td>
                       <td>{{$did['country']}}</td>
                       <td>{{$did['type']}}</td>
                       <td>{{$did['area']}}</td>
                       <td class="text-center text-nowrap">
                          @if(array_search("voice", $did['features']) > -1)
                            <i class="fa fa-check mr-1"></i>
                          @else
                            <i class="fa fa-times mr-1"></i>
                          @endif

                          @if(array_search("t38", $did['features']) > -1)
                            <i class="fa fa-check mr-1"></i>
                          @else
                            <i class="fa fa-times mr-1"></i>
                          @endif
                          @if(array_search("sms", $did['features']) > -1)
                            <i class="fa fa-check mr-1"></i>
                          @else
                            <i class="fa fa-times mr-1"></i>
                          @endif
                       </td>
                       <td>
                         @if($did['metered'] == true)
                          <i class="fa fa-check mr-1"></i>
                         @else
                          <i class="fa fa-times mr-1"></i>
                         @endif
                       </td>
                       <td>{{$did['add_channel']}}</td>
                       <td>
                         <select class="form-control reservation_list_unit form-control-sm" data-order="{{$key}}">
                           <option>0</option>
                           <option>2</option>
                         </select>
                       </td>
                       <td class="reservation_list_nrc_0">{{$did['stocks'][0]['attributes']['setup_price']}}</td>
                       @if(count($did['stocks']) > 1)
                       <td class="reservation_list_nrc_2" style="display: none;">{{$did['stocks'][1]['attributes']['setup_price']}}</td>
                       @endif
                       <td class="reservation_list_mrc_0" >{{$did['stocks'][0]['attributes']['monthly_price']}}</td>
                       @if(count($did['stocks']) > 1)
                       <td class="reservation_list_mrc_2" style="display: none;">{{$did['stocks'][1]['attributes']['monthly_price']}}</td>
                       @endif
                       <td class="action">
                         <button class="btn btn-outline-info btn-sm reserve" data-toggle="modal" data-target="#reservation_modal" data-id="{{$did['id']}}" data-order="{{$key}}"><i class="fa fa-check">Reserve</i></button>
                         <button class="btn btn-outline-success btn-sm"><i class="fa fa-shopping-cart">Order</i></button>
                       </td>
                     </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="modal fade text-left" id="reservation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <form id="reserve_form">
                              <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel1">Reserve DID</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <label>Description</label>
                                  <input type="hidden" name="did_id">
                                  <input type="text" class="form-control" name="description">
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-outline-primary reserve_confirm">Reserve</button>
                              </div>
                            </form>

                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<script>
  //var cities = {!! json_encode($cities) !!};  
</script>
