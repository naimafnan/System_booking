@extends('admin.layouts.main')
@section('content')

    <div class="container">
        @if (Session::has('msg'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('msg') }}
            </div>
        @endif
        <div class="row justify-content-center">
            
            <div class="card">
                <div class="card-header"><h3>Add Meeting Room</h3></div>
                <div class="card-body">
                    <form action="{{ route('createMeetingRoom') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <input type="text" name="name" class="form-control" placeholder="name">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="level" class="form-control" value="" placeholder="Floor">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="address1" class="form-control" value="" placeholder="Address 1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="address2" class="form-control" value="" placeholder="Address 2">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="address3" class="form-control" value="" placeholder="Address 3">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="address4" class="form-control" value="" placeholder="Address 4">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="postcode" class="form-control @error('address') is-invalid @enderror" placeholder="Postcode"  value="{{auth()->user()->postcode}}" maxlength="5">
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="state" id="STATE" class="form-control" onchange="change_state();">
                                    <option value="">Select State</option>
                                    <option value="Johor">JOHOR</option>
                                    <option value="Kedah">KEDAH</option>
                                    <option value="Kelantan">KELANTAN</option>
                                    <option value="Kuala Lumpur">KUALA LUMPUR</option>
                                    <option value="Melaka">MELAKA</option>
                                    <option value="Negeri Sembilan">NEGERI SEMBILAN</option>
                                    <option value="Pahang">PAHANG</option>
                                    <option value="Perak">PERAK</option>
                                    <option value="Perlis">PERLIS</option>
                                    <option value="Pulau Pinang">PULAU PINANG</option>
                                    <option value="Sabah">SABAH</option>
                                    <option value="Sarawak">SARAWAK</option>
                                    <option value="Terengganu">TERENGGANU</option>
                                    <option value="Selangor">SELANGOR</option>
                                    <option value="Putrajaya">PUTRAJAYA</option>
                                    <option value="Labuan">LABUAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{-- <div class="col-lg-6">
                                <select name="provider_id" id="provider_id" class="form-control" onchange="change_state();">
                                    <option value="">Select Provder Type</option>
                                    <option value="3">Car</option>
                                    <option value="2">Meeting Room</option>
                                </select>
                            </div> --}}
                            <div class="col-md-6">
                                <input type="company_name" name="company_name" class="form-control" value="" placeholder="Company Name">
                            </div>
                            <div class="col-lg-6">
                                <select name="service" id="service" class="form-control" onchange="change_state();">
                                    <option value="">Purpose</option>
                                    <option value="5">Dicussion</option>
                                    <option value="6">Event</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="provider_type" name="provider_type" class="form-control" value="" placeholder="Type of Meeting room">
                            </div>
                        </div>

                        <div class="form-group">
                                
                            <button class="btn btn-primary" type="submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection