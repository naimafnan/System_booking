<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\doctor;
use App\Models\User;
use App\Models\Time;
use App\Models\Appointment;
use DateTime;
use Carbon\CarbonPeriod;
use App\Mail\UserBooking;
use App\Mail\doctorEmail;
use App\Models\provider;
use App\Models\provider_details;
use App\Models\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\Timer\Duration;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $reserves=provider_details::all();
        $providers=provider::all();
        return view('reserve.index',compact('reserves','providers'));
    }
    public function fetch(Request $request){
        $services = Services::where('provider_id',$request->provider)->get();
        return response()->json($services);

        // $services=DB::table('services')->where('services_id',$request->provider)->pluck('name','id');
        // return response()->json($services);
    }
    public function fetchCompany(Request $request){
        $company =provider_details::where('services_id',$request->service)->get();
        return response()->json($company);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['dateText'=>'required']);
        $request->validate(['time'=>'required']);
        
        //validate 1 booking only
        // $check=$this->checkBookingTimeInterval();
        // if($check){
        //     return redirect()->back()->with('errmsg','You have already booked an appointment');
        // }
        
        $date=Carbon::parse($request->dateText)->format('Y-m-d');
        $date2=$request->dateText2;
        if($request->dateText2 != null){
            $date2=Carbon::parse($request->dateText2)->format('Y-m-d');
        }else{
            $date2 = null;
        }
        $time=Carbon::parse($request->time)->format('H:i:s'); 
        $time2=$request->time2;
        if($request->time2 != null){
            $time2=Carbon::parse($request->time2)->format('H:i:s');
        }else{
            $time2 = null;
        }
        $remarks=$request->reasons;
        if ($request->time != $request->time2){
        Appointment::create([
            'user_id'=>auth()->user()->id,
            'provider_id'=>$request->provider_id,
            'providerDetails_id'=>$request->providerDetails_id,
            'start_time'=>$time,
            'end_time'=>$time2,
            'duration'=>$request->quantity,
            'start_date'=>$date,
            'end_date'=>$date2,
            'status'=>0,
            'remarks'=>$remarks,
        ]);
        $userBooking=[
            'name'=>auth()->user()->name,
            'time'=>$time,
            'date'=>Carbon::parse($date)->format('d/m/Y'),
            'providerName'=>request()->get('providerName'),
            'company_name'=>request()->get('company_name'),
            'Add1'=>request()->get('Add1'),
            'Add2'=>request()->get('Add2'),
            'Add3'=>request()->get('Add3'),
            'Add4'=>request()->get('Add4'),
            'Postcode'=>request()->get('Postcode'),
            'State'=>request()->get('State')
            
        ];

        $appointment=Appointment::all();
        
        $doctorEmail=[
            'name'=>auth()->user()->name,
            'time'=>$time,
            'date'=>Carbon::parse($date)->format('d/m/Y'),
            'providerName'=>request()->get('providerName'),
            'doctor_email'=>request()->get('doc_email'),
            'company_name'=>request()->get('company_name'),
            'Add1'=>request()->get('Add1'),
            'Add2'=>request()->get('Add2'),
            'Add3'=>request()->get('Add3'),
            'Add4'=>request()->get('Add4'),
            'Postcode'=>request()->get('Postcode'),
            'State'=>request()->get('State')
        ];
        
        Mail::to(request()->get('doc_email') )->send(new \App\Mail\doctorEmail($doctorEmail));

        Mail::to(auth()->user()->email)->send(new \App\Mail\UserBooking($userBooking));
        return redirect()->back()->with('msg','Your appointment was booked');
        
    }else{
        return redirect()->back()->with('errmsg','Start time cannot be the same as End time');
    }
        
    }
    public function carBooking(Request $request){
        $date=Carbon::parse($request->datepicker3)->format('Y-m-d');
        $time=Carbon::parse($request->time3)->format('H:i:s'); 
        $duration=$request->quantity;
        $remarks=$request->reasons;
        Appointment::create([
            'user_id'=>auth()->user()->id,
            'provider_id'=>$request->provider_id,
            'providerDetails_id'=>$request->providerDetails_id,
            'start_time'=>$time,
            'end_time'=>null,
            'duration'=>$request->quantity,
            'start_date'=>$date,
            // 'end_date'=>$date2,
            'status'=>0,
            'remarks'=>$remarks,
        ]);
        return redirect()->back()->with('msg','Your appointment was booked');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($providerId,$providerDetailsId)
    {
        $appointments=Appointment::where('provider_id',$providerId)->get();
        $providers=provider_details::where('id',$providerDetailsId)->where('provider_id',$providerId)->first();
        $provider_id=$providerId;
        $providerDetails_id=$providerDetailsId;

        return view('reserve.appointment',compact('providers','provider_id','appointments','providerDetails_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function search(Request $request){
            $keyword=$request->get('keyword');
            $company=$request->get('company');
            $address=$request->get('add');
            $services=$request->get('service');
            $providers=$request->input('provider');
             
            $providers=provider::all();
            $reserves=User::join("provider_details","provider_details.user_id","=","users.id")
            ->where('provider_details.status','=','0')
            ->get(); 
            // if($providers){
            //     $reserves=User::join("provider_details","provider_details.user_id","=","users.id")
            //     ->Where("provider_details.provider_id","LIKE","%".$providers."%")
            //     ->Where("users.name","LIKE","%".$providers."%")
            //     ->get();
                
            // }
            if($keyword){
                $reserves=User::join("provider_details","provider_details.user_id","=","users.id")
                ->Where("users.name","LIKE","%".$keyword."%")
                ->orWhere("provider_details.company_name","LIKE","%".$keyword."%")
                ->orWhere("provider_details.provider_type_id","LIKE","%".$keyword."%")
                ->get();
            }
            // if($company){
            //     $reserves=User::join("provider_details","provider_details.user_id","=","users.id")
            //     ->where('provider_details.company_name','LIKE','%'.$company.'%')
            //     ->get();
            // }
            // if($services){
            //     $reserves=User::join("provider_details","provider_details.user_id","=","users.id")
            //     ->where('provider_details.services_id','LIKE','%'.$services.'%')->get();
            // }
            // if($address){
            //     $reserves=User::join("provider_details","provider_details.user_id","=","users.id")
            //     ->where('users.address1','LIKE','%'.$address.'%')
            //     ->orWhere("users.address2","LIKE","%".$address."%")
            //     ->orWhere("users.address3","LIKE","%".$address."%")
            //     ->orWhere("users.address4","LIKE","%".$address."%")
            //     ->orWhere("users.postcode","LIKE","%".$address."%")
            //     ->get();
            // }
            return view('reserve.search',compact('reserves','providers'));
        }

        public function getTimeCar(Request $request) { 

            $providers=provider_details::where('id',$request->providerDetails_id)->first();
            $appointment=Appointment::where('providerDetails_id',$request->providerDetails_id)
            ->where('start_date',$request->input('datepicker'))
            ->first();
            if($appointment == null){
                
                //start_time from appointment
            
            $sometimeOut=$providers->slot_duration;
            $start=$providers->start_time;
            $startRest=$providers->start_rest_time;
            $endRest=$providers->end_rest_time; 
            $end=$providers->end_time; 

            //sampai jam berapa dia guna 
            $data2=[];
            $timeSlot = $this->getTimeSlot($sometimeOut, $start, $startRest);
            $timeSlot2 = $this->getTimeSlot2($sometimeOut, $endRest, $end);
            $data1=[];
            $data3=[];
            foreach($timeSlot as $timeSlots){
                $arr=array($timeSlots);
                array_push($data1,$arr);
                // dd($timeSlots);
            }

            foreach($timeSlot2 as $timeSlot2s){
                $arr3=array($timeSlot2s);
                array_push($data3,$arr3);
            }
            // foreach($time as $times){
            //     $arr2=array(Carbon::parse($times->start_time)->format('H:i'));
            //     // dd($arr2);
            //     array_push($data2,$arr2);
            //     // dd($data2);
            // }
                $test1 = array_column($data1, '0');
                $test3 = array_column($data3, '0');
                $result=array_merge($test1,$test3);
                // dd($test2);
                // dd($combined);
                // if()
            return response()->json($result);
            
            }else{
                //start_time from appointment
            $start2=$appointment->start_time;
            
            $sometimeOut=$providers->slot_duration;
            $start=$providers->start_time;
            $startRest=$providers->start_rest_time;
            $endRest=$providers->end_rest_time; 
            $end=$providers->end_time;
            $duration=$appointment->duration;
            $masa = date("Y-m-d H:i:s", strtotime($start2) + $duration * 60 * 60);
            // dd($masa);

            //sampai jam berapa dia guna
            // $totalHours=strtotime($start2)+$duration;
            // dd($timeInMinutes);
            // $time=date('H:i',$totalHours);
            // dd($time);
            $data2=[];
            $timeSlot = $this->getTimeSlot($sometimeOut, $start, $startRest);
            $timeSlot2 = $this->getTimeSlot2($sometimeOut, $endRest, $end);
            $timeSlot3= $this->getTimeSlotCar($sometimeOut,$start2,$masa);
            // dd($timeSlot);
            $data1=[];
            $data3=[];


            //morning slot
            foreach($timeSlot as $timeSlots){
               // $arr=array($timeSlots);
                array_push($data1,$timeSlots);
              //  dd($data1);
            }
            // dd($data1);
            //evening slot
            foreach($timeSlot2 as $timeSlot2s){
                array_push($data3,$timeSlot2s);
            }
            // dd($data3);
            //disable slot
            foreach($timeSlot3 as $timeSlot3s){
                array_push($data2,$timeSlot3s);
                
            }
            // dd($data2);


                $test1 = array_column($data1, '0');
                $test2 = array_column($data2, '0');
                $test3 = array_column($data3, '0');
                $result=array_merge($data1,$data3);
                // dd($data2);
                $combined2 = array_diff($result,$data2);
                // dd($combined2);
                // if()
            return response()->json($combined2);
            }
            
        }
        public function getTime(Request $request) {

            // dd($request->datepicker);
            $providers=provider_details::where('id',$request->providerDetails_id)->first();

            $sometimeOut=$providers->slot_duration;
            $start=$providers->start_time;
            $startRest=$providers->start_rest_time;
            $endRest=$providers->end_rest_time; 
            $end=$providers->end_time;
            // dd($request->datepicker);
            $time = Appointment::select('start_time','end_time') 
            ->when($request->datepicker !=null,function($query) use ($request){
                $query->where('provider_id',$request->provider_id)
                        ->where('providerDetails_id',$request->providerDetails_id)
                        ->where('status','!=',2)
                        ->whereDate('start_date',$request->datepicker);
            })
            ->when($request->datepicker2 !=null,function($query) use ($request){
                $query->where('provider_id',$request->provider_id)
                        ->where('providerDetails_id',$request->providerDetails_id) 
                        ->whereDate('end_date',$request->datepicker2);
            })
            ->get();
            // dd($time);
            
            $data2=[];
            $timeSlot = $this->getTimeSlot($sometimeOut, $start, $startRest);
            $timeSlot2 = $this->getTimeSlot2($sometimeOut, $endRest, $end);
            $data1=[];
            $data3=[];
            foreach($timeSlot as $timeSlots){
                $arr=array($timeSlots);
                array_push($data1,$arr);
                // dd($timeSlots);
            }

            foreach($timeSlot2 as $timeSlot2s){
                $arr3=array($timeSlot2s);
                array_push($data3,$arr3);
            }
            foreach($time as $times){
                $arr2=array(Carbon::parse($times->start_time)->format('H:i'));
                // dd($arr2);
                array_push($data2,$arr2);
                // dd($data2);
            }
                $test1 = array_column($data1, '0');
                $test2 = array_column($data2, '0');
                $test3 = array_column($data3, '0');
                $result=array_merge($test1,$test3);
                // dd($test2);
                $combined = array_diff($result,$test2);
                // dd($combined);
                // if()
            return response()->json($combined);
        }

        private function getTimeSlot($sometimeOut, $start, $startRest)
            {
                $start = new DateTime($start);
                $end = new DateTime($startRest);
                $BeginTimeStemp = $start->format('H:i'); // Get time Format in Hour and minutes
                $lastTimeStemp = $end->format('H:i');
                $i=0;
                while(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                    $start = $BeginTimeStemp;
                    $end = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $BeginTimeStemp = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $i++;
                    if(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                                           
                            $time[$i]= $start; 
                    
                    }
                }
                return $time;
            }
        private function getTimeSlot2($sometimeOut, $endRest, $end)
            {
                $endRest = new DateTime($endRest);
                $end = new DateTime($end);
                $BeginTimeStemp = $endRest->format('H:i'); // Get time Format in Hour and minutes
                $lastTimeStemp = $end->format('H:i');
                $i=0;
                while(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                    $endRest = $BeginTimeStemp;
                    $end = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $BeginTimeStemp = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $i++;
                    if(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                        $time[$i] = $endRest; 
                    }
                }
                return $time;
            }
        private function getTimeSlotCar($sometimeOut, $startSlot, $endSlot)
            {
                $startSlot = new DateTime($startSlot);
                $endSlot = new DateTime($endSlot);
                $BeginTimeStemp = $startSlot->format('H:i'); // Get time Format in Hour and minutes
                $lastTimeStemp = $endSlot->format('H:i');
                $i=0;
                while(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                    $startSlot = $BeginTimeStemp;
                    $endSlot = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $BeginTimeStemp = date('H:i',strtotime('+'.$sometimeOut.' minutes',strtotime($BeginTimeStemp)));
                    $i++;
                    if(strtotime($BeginTimeStemp) <= strtotime($lastTimeStemp)){
                        $time[$i] = $startSlot; 
                    }
                }
                return $time;
            }
}
