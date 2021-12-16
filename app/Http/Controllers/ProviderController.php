<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\provider_details;
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
        return view('admin.provider.create');
    }
    public function create2()
    {
        return view('admin.provider.createMeetingRoom');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users=User::create([
            'name'=>$request->input('name'),
            'role_id'=>4,
            'address1'=>$request->input('add1'),
            'address2'=>$request->input('add2'),
            'address3'=>$request->input('add3'),
            'address4'=>$request->input('add4'),
            'postcode'=>$request->input('postcode'),
            'state'=>$request->input('state')
        ]);
        $details=provider_details::create([
            'user_id'=>$users->id,
            'provider_id'=>3,
            'provider_type'=>$request->input('provider_type'),
            'company_name'=>$request->input('company_name'),
            'services_id'=>$request->input('service'),
            'level'=>$request->input('level')
        ]);
        return redirect()->back()->with('msg','Provider Car has been added');

    }
    public function store2(Request $request)
    {
        $users=User::create([
            'name'=>$request->input('name'),
            'role_id'=>5,
            'address1'=>$request->input('address1'),
            'address2'=>$request->input('address2'),
            'address3'=>$request->input('address3'),
            'address4'=>$request->input('address4'),
            'postcode'=>$request->input('postcode'),
            'state'=>$request->input('state')
        ]);
        $details=provider_details::create([
            'user_id'=>$users->id,
            'provider_id'=>2,
            'provider_type'=>$request->input('provider_type'),
            'company_name'=>$request->input('company_name'),
            'services_id'=>$request->input('service'),
            'level'=>$request->input('level')
        ]);

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
        $users=User::find($id);
        return view('admin.provider.edit',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users=User::find($id);
        return view('admin.provider.edit',compact('users'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
