@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
        @endforeach
        @if (Session::has('msg'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('msg') }}
            </div>
        @endif
        @if(Session::has('errmsg'))
            <div class="alert alert-danger">
                {{Session::get('errmsg')}}
            </div>
        @endif
        @if ($providers->provider_id=='1')
            <form action="{{ route('userAppointment') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-3 mb-2">
                        <div class="card">
                            <div class="card-body text-center   ">
                                
                                <h4 class="text-center">
                                    Provider Information
                                </h4>
                                    <img src="/img/dr.png" style="background-size: cover; border-radius: 999px; height: 120px; width: 120px; margin: 0 auto 20px auto" class="card-img-top" class="img-fluid rounded" class="" alt="...">
                                <br>
                                <p class="lead">
                                    Name : {{ ucfirst($providers->myProvider->name) }}
                                </p>
                                <p class="lead">  
                                    Level : {{ $providers->level}}
                                </p>
                                <p class="lead">
                                    Speciality : {{ $providers->providerTypes->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mb-2">
                        <div class="card" >
                            <div class="card-body">
                                <h4 class="text-center">
                                    Book your Appointment 
                                </h4>
                                    <input type='date' id="datepicker1" class="form-control mb-2" name="dateText" placeholder="Select date">
                                @foreach ($appointments as $appointment )
                                    <input type="hidden" name="end_time" value="{{ $appointment->start_time }}"> 
                                @endforeach
                                @php
                                    $test='<input type="text" id="selected" name="selected" value="">'; 
                                    
                                @endphp
                                <select class="form-control mb-2" name="time" id="time">
                                </select>
                                @if ($providers->provider_id=='3' || $providers->provider_id=='2')
                                    <label for="return_time">Return time</label>
                                    <select class="form-control mb-2" name="time2" id="time2">
                                    </select> 
                                @endif
                                <input type="hidden" id="provider_id" name="provider_id" value="{{ $provider_id }}"> 
                                <input type="hidden" id="providerDetails_id" name="providerDetails_id" value="{{ $providerDetails_id }}"> 
                                <input type="hidden" name="providerName" value="{{ $providers->myProvider->name }}"> 
                                <input type="hidden" name="company_name" value="{{ $providers->company_name }}"> 
                                <input type="hidden" name="Add1" value="{{ $providers->myProvider->address1 }}"> 
                                <input type="hidden" name="Add2" value="{{ $providers->myProvider->address2 }}"> 
                                <input type="hidden" name="Add3" value="{{ $providers->myProvider->address3 }}"> 
                                <input type="hidden" name="Add4" value="{{ $providers->myProvider->address4}}"> 
                                <input type="hidden" name="Postcode" value="{{ $providers->myProvider->postcode }}"> 
                                <input type="hidden" name="State" value="{{ $providers->myProvider->state }}"> 
                                <input type="hidden" name="start_time" value="{{ $providers->start_time }}"> 
                                <input type="hidden" name="end_time" value="{{ $providers->end_time }}"> 
                                <input type="hidden" name="doc_email" value="{{ $providers->myProvider->email }}">

                                <textarea style="width: 100%;min-height: 75px" id="remarks" name="reasons" placeholder="Remarks" required></textarea>
                                
                                @if (Auth::check())
                                    <button type="submit" class="btn btn-success btn-lg main-blink">Proceed</button> 
                                @else
                                    <p>Please login or register to make an appointment</p>
                                    <a href="{{ route('register') }}">Register</a><br>
                                    <a href="{{ route('login') }}">Login</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        @endif
        @if ($providers->provider_id=='3' || $providers->provider_id=='2')
            <form action="{{ route('carBooking') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-3 mb-2">
                        <div class="card">
                            <div class="card-body text-center   ">
                                
                                <h4 class="text-center">
                                    Provider Information
                                </h4>
                                @if ($providers->provider_id=='2')
                                    <img src="/img/meeting.png" style="background-size: cover; border-radius: 999px; height: 120px; width: 120px; margin: 0 auto 20px auto" class="card-img-top" class="img-fluid rounded" class="" alt="...">
                                @else
                                    <img src="/img/car.png" style="background-size: cover; border-radius: 999px; height: 120px; width: 120px; margin: 0 auto 20px auto" class="card-img-top" class="img-fluid rounded" class="" alt="...">
                                @endif
                                <br>
                                <p class="lead">
                                    Name : {{ ucfirst($providers->myProvider->name) }}
                                </p>
                                <p class="lead">  
                                    Level : {{ $providers->level}}
                                </p>
                                <p class="lead">
                                    Type : {{ $providers->providerTypes->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mb-2">
                        <div class="card" >
                            <div class="card-body">
                                <h4 class="text-center">
                                    Book your Appointment 
                                </h4>
                                    <input type='date' id="datepicker3" class="form-control mb-2" name="datepicker3" placeholder="Select date">
                                @foreach ($appointments as $appointment )
                                    <input type="hidden" name="end_time" id="end_time" value="{{ $appointment->start_time }}"> 
                                @endforeach
                                @php
                                    $test='<input type="text" id="selected" name="selected" value="">'; 
                                    
                                @endphp 
                                <select class="form-control mb-2" name="time3" id="time3">
                                </select>
                                <div class="comment mb-2">
                                    <input type="number" id="quantity" style="width: 100%;min-height: 15px" name="quantity" min="1" max="8" placeholder="Hours">
                                </div> 
                                <input type="hidden" id="provider_id" name="provider_id" value="{{ $provider_id }}"> 
                                <input type="hidden" id="providerDetails_id" name="providerDetails_id" value="{{ $providerDetails_id }}"> 
                                <input type="hidden" name="providerName" value="{{ $providers->myProvider->name }}"> 
                                <input type="hidden" name="company_name" value="{{ $providers->company_name }}"> 
                                <input type="hidden" name="Add1" value="{{ $providers->myProvider->address1 }}"> 
                                <input type="hidden" name="Add2" value="{{ $providers->myProvider->address2 }}"> 
                                <input type="hidden" name="Add3" value="{{ $providers->myProvider->address3 }}"> 
                                <input type="hidden" name="Add4" value="{{ $providers->myProvider->address4}}"> 
                                <input type="hidden" name="Postcode" value="{{ $providers->myProvider->postcode }}"> 
                                <input type="hidden" name="State" value="{{ $providers->myProvider->state }}"> 
                                <input type="hidden" name="start_time" value="{{ $providers->start_time }}"> 
                                <input type="hidden" name="end_time" value="{{ $providers->end_time }}"> 
                                <input type="hidden" name="doc_email" value="{{ $providers->myProvider->email }}">

                                <div class="comment">
                                    <textarea class="textinput" style="width: 100%;min-height: 75px" id="remarks" name="reasons" placeholder="Remarks" required></textarea>
                                </div>
                                @if (Auth::check())
                                    <button type="submit" class="btn btn-success btn-lg main-blink">Proceed</button> 
                                @else
                                    <p>Please login or register to make an appointment</p>
                                    <a href="{{ route('register') }}">Register</a><br>
                                    <a href="{{ route('login') }}">Login</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        @endif
    </div>
@endsection
@push('script')
<script>

    $("#datepicker1").on('change',function(){

        $('#time').html('');
        $('#time').append('<option value="">----- Processing -----</option>');
        $('#time').attr("disabled", true);

        $.ajax({
            type: "POST",
            url: "{{ route('getTime') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "datepicker": $('#datepicker1').val(),
                "provider_id": $('#provider_id').val(),
                "providerDetails_id":$('#providerDetails_id').val()
            },
        success: function (data) { 
            //  console.log(data);
                        $('#time').html('');
                        $('#time').append('<option value="">----- Please Select -----</option>');
                        $.each(data, function(i,v)
                        {
                            $('#time').append('<option value="'+ v + '">'+ v + '</option>');
                        });

                        $('#time').select().prop("disabled", false);
                    }        
            
        });
    });
    $("#datepicker3").on('change',function(){

        $('#time3').html('');
        $('#time3').append('<option value="">----- Processing -----</option>');
        $('#time3').attr("disabled", true);

        $.ajax({
            type: "POST",
            url: "{{ route('getTimeCar') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "datepicker": $('#datepicker3').val(),
                "provider_id": $('#provider_id').val(),
                "providerDetails_id":$('#providerDetails_id').val()
            },
        success: function (data) { 
            //  console.log(data);
                        $('#time3').html('');
                        $('#time3').append('<option value="">----- Please Select -----</option>');
                        $.each(data, function(i,v)
                        {
                            $('#time3').append('<option value="'+ v + '">'+ v + '</option>');
                        });

                        $('#time3').select().prop("disabled", false);
                    }        
            
        });
    });
    $("#datepicker2").on('change',function(){

        $('#time2').html('');
        $('#time2').append('<option value="">----- Processing -----</option>');
        $('#time2').attr("disabled", true);

        $.ajax({
            type: "POST",
            url: "{{ route('getTime') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "datepicker2": $('#datepicker2').val(),
                "provider_id": $('#provider_id').val(),
                "providerDetails_id":$('#providerDetails_id').val()
            },
        success: function (data) { 
            // console.log(data);
                        $('#time2').html('');
                        $('#time2').append('<option value="">----- Please Select -----</option>');
                        $.each(data, function(i,v)
                        {
                            $('#time2').append('<option value="'+ v + '">'+ v + '</option>');
                        });

                        $('#time2').select().prop("disabled", false);
                    }        
            
        });
    });
    $(function(){
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        $('#datepicker1').attr('min', maxDate);
        $('#datepicker3').attr('min', maxDate);

});


</script>
@endpush
