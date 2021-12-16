@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-12 text-center">
            <h1>A New Experience with Booking</h1>
        </div>
        <div class="col-12">
        </div>
    </div>
    <div class="mb-5">
        <form class="form-inline justify-content-center" action="{{ url('/search') }}" method="GET" role="search">
            {{csrf_field()}}
             <!-- Can add label if want -->
            <select class="form-control mb-2 mr-2" id="provider" name="provider" data-dependent="provider">
                <option value="" selected disabled>Provider</option>
                @foreach ($providers as $provider)
                <option value="{{ $provider->id }}" >{{ $provider->name }}</option>
                @endforeach
            </select>
            <select class="form-control mb-2 mr-2 dynamic" id="service" name="service" data-dependent="service">
                <option value="">Service</option>
            </select>
                        
            <select class="form-control mb-2 mr-2 dynamic" name="company" id="company" data-dependent="company">
                <option value="">Company Name</option>
            </select>
            <input type="text" class="form-control mb-2 mr-2" name="add" placeholder="Enter Location" id="add" >
            <input type="text" class="form-control mb-2 mr-2" name="keyword" placeholder="Enter Provider,Company,Specialist,etc.. " id="keyword" >
            <button type="submit" class="btn btn-primary mb-2 mr-2">Search</button>
        </form>
    </div>
</div>
@endsection
@push('script')
    <script>
        // $(document).ready(function() {
        //     $('#provider').on('change', function() {
        //        var providerID = $(this).val();
        //        if(providerID) {
        //            $.ajax({
        //                url: '/getProvider/'+providerID,
        //                type: "GET",
        //                data : {"_token":"{{ csrf_token() }}"},
        //                dataType: "json",
        //                success:function(data)
        //                {
        //                  if(data){
        //                     $('#service').empty();
        //                     $('#service').append('<option hidden>Service</option>'); 
        //                     $.each(data, function(key, course){
        //                         $('select[name="service"]').append('<option value="'+ key +'">' + course.service+ '</option>');
        //                     });
        //                 }else{
        //                     $('#service').empty();
        //                 }
        //              }
        //            });
        //        }else{
        //          $('#service').empty();
        //        }
        //     });
        //     });
        // $(document).ready(function() {
        //     $('#service').on('change', function() {
        //        var providerID = $(this).val();
        //        if(providerID) {
        //            $.ajax({
        //                url: '/getCompany/'+providerID,
        //                type: "GET",
        //                data : {"_token":"{{ csrf_token() }}"},
        //                dataType: "json",
        //                success:function(data)
        //                {
        //                  if(data){
        //                     $('#company').empty();
        //                     $('#company').append('<option hidden>Company Name</option>'); 
        //                     $.each(data, function(key, courses){
        //                         $('select[name="company"]').append('<option value="'+ key +'">' + courses.company_name+ '</option>');
        //                     });
        //                 }else{
        //                     $('#company').empty();
        //                 }
        //              }
        //            });
        //        }else{
        //          $('#company').empty();
        //        }
        //     });
        //     });

        $('#provider').change(function(){
            var providerID = $(this).val();  
            if(providerID){
                $.ajax({
                type:"GET",
                url:"{{url('getProvider')}}?provider="+providerID,
                success:function(res){        
                if(res){
                    $("#service").empty();
                    $("#service").append('<option>Select Service</option>');
                    $.each(res,function(key,services){
                    $("#service").append('<option value="'+key+'">'+services.name+'</option>');
                    });
                
                }else{
                    $("#service").empty();
                }
                }
                });
            }else{
                $("#service").empty();
                $("#company").empty();
            }   
            });
            $('#service').on('change',function(){
            var serviceID = $(this).val();  
            if(serviceID){
                $.ajax({
                type:"GET",
                url:"{{url('getCompany')}}?service="+serviceID,
                success:function(res){        
                if(res){
                    $("#company").empty();
            $("#company").append('<option>Select Company</option>');
                    $.each(res,function(key,Company){
                    $("#company").append('<option value="'+key+'">'+Company.company_name+'</option>');
                    });
                
                }else{
                    $("#company").empty();
                }
                }
                });
            }else{
                $("#company").empty();
            }
                
            });



    </script> 
@endpush