@extends('admin.layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    List Car
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table" id="data_table">
                            <thead>
                                <tr>
                                    <th class="nosort">Avatar</th>
                                    <th>Name</th>
                                    <th>Model</th>
                                    <th>Company</th>
                                    <th>Seater</th>
                                    <th>Status</th>
                                    {{-- <th class="nosort">Actions</th> --}}
                                    <th class="nosort">&nbsp;</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @if (Session::has('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('msg') }}
                                    </div>
                                @endif
                                @forelse ($cars as $car)
                                    <tr>
                                        <td><img src="\img\user1.png" class="table-user-thumb" alt=""></td>
                                        <td>{{ $car->name }}</td>
                                        <td>{{ $car->providerDetails->provider_type_id }}</td>
                                        <td>{{ $car->providerDetails->company_name }}</td>
                                        <td>{{ $car->providerDetails->level }}</td>
                                        <td>
                                            <a href="{{ route('allCar.show',[$car->id]) }}" class="btn btn-danger mb-2" style="width: 100px;display:inline-block">Delete</a>
                                            <a href="{{route('allCar.edit',[$car->id])}}" class="btn btn-success mb-2" style="width: 100px;display:inline-block">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <h5>You have no Car.</h5>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection