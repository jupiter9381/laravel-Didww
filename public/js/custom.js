$(document).ready(function(){
  var selectedRow ;
  $("button.reserve").click(function(e){
    var id = $(this).data('id');
    $("#reservation_modal input[name='did_id']").val(id);
    selectedRow = $(this).data('order');
  });
  $("#reserve_form").submit(function(e){
    e.preventDefault();
    var form_data = {
      "description": $("#reservation_modal input[name='description']").val(),
      "did_id": $("#reservation_modal input[name='did_id']").val(),
      "_token": $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
			url : '/did_reservation',
      type : 'post',
      dataType : 'json',
      data: form_data,
      success: function(data){
        var reservation = JSON.parse(data);
        var reservation_id = reservation['data']['id'];
        $("#reservation_modal").modal("hide");
        $("tr[order='"+selectedRow+"'] td.action").html("<a class='btn btn-primary btn-sm' href='/did_reservations/"+reservation_id+"'><i class='fa fa-eye mr-1'>See Reservation</i></a>");
      }
		})
  });

  $(".reservation_unit").change(function(e){
    if($(this).val() === "0") {
      $(".reservation_nrc_0").css("display","block");
      $(".reservation_nrc_2").css("display","none");
      $(".reservation_mrc_0").css("display","block");
      $(".reservation_mrc_2").css("display","none");
    } else {
      $(".reservation_nrc_0").css("display","none");
      $(".reservation_nrc_2").css("display","block");
      $(".reservation_mrc_0").css("display","none");
      $(".reservation_mrc_2").css("display","block");
    }
  });
  $(".reservation_list_unit").change(function(e){
    var order = $(this).data('order');
    if($(this).val() === "0") {
      $("tr[order='"+order+"'] td.reservation_list_nrc_0").removeAttr("style");
      $("tr[order='"+order+"'] td.reservation_list_nrc_2").css("display", "none");
      $("tr[order='"+order+"'] td.reservation_list_mrc_0").removeAttr("style");
      $("tr[order='"+order+"'] td.reservation_list_mrc_2").css("display", "none");
    } else {
      $("tr[order='"+order+"'] td.reservation_list_nrc_0").css("display", "none");
      $("tr[order='"+order+"'] td.reservation_list_nrc_2").removeAttr("style");
      $("tr[order='"+order+"'] td.reservation_list_mrc_0").css("display", "none");
      $("tr[order='"+order+"'] td.reservation_list_mrc_2").removeAttr("style");
    }
  })
  
  $("select[name='country']").change(function(e){
    // var html = "";
    // $(".city_section").css('display', 'block');
    // html += "<option value=''>Select city...</option>";
    // for(var i = 0; i < cities.length; i++) {
    //   if(cities[i]['relationships']['country']['data']['id'] == $(this).val()) {
    //     html += "<option value='"+cities[i]['id']+"'>"+cities[i]['attributes']['name']+"</option>";
    //   }
    //   $("select[name='city']").html(html);
    //   $("select[name='city']").select2();
    // }
    if($(this).val() == "") {
      $(".city_section").css('display', 'none');
      $("select[name='city']").html("");
      $("select[name='city']").select2();
    } else {
      $.ajax({
        url : '/getCitiesById',
        type : 'post',
        dataType : 'json',
        data: {country_id: $(this).val(), "_token": $('meta[name="csrf-token"]').attr('content')},
        success: function(data){
          var cities = data['result'];
          if(cities.length > 0) $(".city_section").css('display', 'block');
          var html = "";
          html += "<option value=''>Select city...</option>";
          for (var i = 0; i < cities.length; i++) {
            html += "<option value='"+cities[i]['id']+"'>"+cities[i]['attributes']['name']+"</option>";
          }
          $("select[name='city']").html(html);
          $("select[name='city']").select2();
        }
      })
    }
  });
});
