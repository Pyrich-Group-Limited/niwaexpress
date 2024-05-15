<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\RegistrationFee;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $metrics = [
            'app_fee' => Payment::where('payment_type',1)->where('employer_id', auth()->user()->id)->sum('amount'),
            'services' => Payment::where('payment_type',4)->where('employer_id', auth()->user()->id)->where('service_id','!=', null)->count(),
            'pro_fee' => Payment::where('payment_type',2)->where('employer_id', auth()->user()->id)->sum('amount'),
            'inspect' => Payment::where('payment_type',3)->where('employer_id', auth()->user()->id)->sum('amount'),
            'demand' => Payment::where('payment_type',3)->where('employer_id', auth()->user()->id)->sum('amount'),
            'total' => Payment::where('employer_id', auth()->user()->id)->sum('amount'),
            'accident_claims' => ['amount' => 0, 'number'=> auth()->user()->accident_claims()->count()],
            'death_claims' => ['amount' => 0, 'number'=> auth()->user()->death_claims()->count()],
            'disease_claims' => ['amount' => 0, 'number'=> auth()->user()->disease_claims()->count()],
        ];
        /* $reg_setup = RegistrationFee::where('branch_id', auth()->user()->branch->id)->first();
        // Customize the redirect logic here
        if(isset($reg_setup) && $reg_setup->amount != null){
            if (Auth::user()->paid_registration != 1){
                return view('payments.steps');
            }else{
                return view('home', compact(['metrics']));
            }
        }else{
            return view('home', compact(['metrics']));
        } */
        return view('home', compact(['metrics']));
        
    }
}
