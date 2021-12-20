<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\provider_details;
use App\Models\state;
use App\Models\provider_type;
use App\Models\Services;
use NunoMaduro\Collision\Contracts\Provider;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states=state::all();
        $services=Services::where('provider_id',3)->get();
        $provider_types=provider_type::where('provider_id',3)->get();
        return view('admin.provider.create',compact('states','provider_types','services'));
    }
    public function create2()
    {
        $states=state::all();
        $services=Services::where('provider_id',2)->get();
        $provider_types=provider_type::where('provider_id',2)->get();
        return view('admin.provider.createMeetingRoom',compact('states','provider_types','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = new User();
        $users-> name = $request->input('name');
        $users-> role_id = 4;
        $users-> address1 = $request->input('add1');
        $users-> address2 =$request->input('add2');
        $users-> address3 = $request->input('add3');
        $users-> address4 = $request->input('add4');
        $users-> postcode = $request->input('postcode');
        $users-> states_id = $request->input('state');
        $users-> save();

        $providerDetails = new provider_details();
        $providerDetails->user_id = $users->id;
        $providerDetails->provider_id=3;
        $providerDetails->provider_type_id=$request->input('provider_type');
        $providerDetails->company_name=$request->input('company_name');
        $providerDetails->services_id=$request->input('service');
        $providerDetails->level=$request->input('level');
        $providerDetails->save();
        

        return redirect()->back()->with('msg','Provider Car has been added');

    }
    public function store2(Request $request)
    {
        $users = new User();
        $users-> name = $request->input('name');
        $users-> role_id = 5;
        $users-> address1 = $request->input('address1');
        $users-> address2 =$request->input('address2');
        $users-> address3 = $request->input('address3');
        $users-> address4 = $request->input('address4');
        $users-> postcode = $request->input('postcode');
        $users-> states_id = $request->input('state');
        $users-> save();

        $providerDetails = new provider_details();
        $providerDetails->user_id = $users->id;
        $providerDetails->provider_id=2;
        $providerDetails->provider_type_id=$request->input('provider_type');
        $providerDetails->company_name=$request->input('company_name');
        $providerDetails->services_id=$request->input('service');
        $providerDetails->level=$request->input('level');
        $providerDetails->save();
        

        return redirect()->back()->with('msg','Provider Meeting Room has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id=$request->input('user_id');
        $user = User::find($user_id);
        $user->name=$request->name;
        $user->address1=$request->address1;
        $user->address2=$request->address2;
        $user->address3=$request->address3;
        $user->address4=$request->address4;
        $user->postcode=$request->postcode;
        $user->state=$request->state;
        $user->save();

        $provider = provider_details::where('user_id',$user_id)->first();
        $provider->company_name=$request->company_name ?? null;
        $provider->provider_type=$request->provider_type ?? null;
        $provider->services_id=$request->service ?? null;
        $provider->level=$request->level ?? null;
        $provider->save();

        // $reserves->update();
        return redirect()->back()->with('success', 'Meeting Room Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
