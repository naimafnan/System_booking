@extends('layouts.app')
@section('content')
    <div class="container" >
        <div class="row">
            {{-- @foreach ($appointments as $key=>$appointment) --}}
            <div class="col-md-8 mb-3">
                <div class="card bg-white">
               
                    <div class="card-header bg-info">Booking Details</div>
                    <div class="card-body">
                        
                            <h6 class="card-title text-black-50">Provider's Name</h6>
                            <h5 class="card-text">{{ $appointments->appUser->name }}</h5>
                            <h6 class="card-title text-black-50">Time</h6>
                            <h5 class="card-text">{{ $appointments->start_time }}</h5>
                            <h6 class="card-title text-black-50">Date</h6>
                            <h5 class="card-text">{{ $appointments->start_date }}</h5>
                            <h6 class="card-title text-black-50">Location</h6>
                            <h5 class="card-text">{{ $appointments->appUser->address1 }},{{ $appointments->appUser->address2 }},{{ $appointments->appUser->address3 }},{{ $appointments->appUser->address4 }},{{ $appointments->appUser->postcode }},{{ $appointments->appUser->state }}</h5>
                            <h6 class="card-title text-black-50">Clinic's name</h6>
                            <h5 class="card-text">{{ $appointments->providerDetailsApp->company_name }}</h5>
                            <h6 class="card-title text-black-50">Status</h6>
                                @if($appointments->status==0)
                                    <h5 class="">Not visited</h5>
                                @elseif($appointments->status==2)
                                    <h5>Cancelled</h5>
                                @else
                                    <h5>Checked</h5>
                                @endif
                                @if ($appointments->status==1)
                                    <h6 class="card-title text-black-50">Remarks</h6>
                                    <h5 class="card-text">{{ $appointments->remarks }}</h5>
                                @endif
                            
                    </div>
                </div>
            </div>
            {{-- @endforeach --}}
        </div>
    </div>
@endsection