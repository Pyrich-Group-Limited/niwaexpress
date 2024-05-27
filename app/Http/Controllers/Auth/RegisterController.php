<?php

namespace App\Http\Controllers\Auth;

use App\Models\State;
use App\Models\Branch;
use App\Models\Service;

use App\Models\Employer;
use Illuminate\Http\Request;
use App\Models\Epromoteruser;
use App\Models\Epromoterservices;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\EmployerRegisteredMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
        return route('home');
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'contact_surname' => ['required', 'string', 'max:255'],
            'contact_firstname' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'string', 'max:255', 'unique:employers'],
            'user_type' => ['required', 'string', 'max:255'],
            'company_email' => ['nullable', 'string', 'email', 'max:255', 'unique:employers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        unset($data['password_confirmation']);
        $data['user_id'] = 1;
        $password = $data['password'];
        $data['password'] = Hash::make($data['password']);

        $last_ecs = Employer::latest()->first();

        if ($last_ecs) {
            do {
                $ecs = $last_ecs->ecs_number + 1;
                $employer_exists = Employer::where('ecs_number', $ecs)->latest()->first();
            } while ($employer_exists);
        } else {
            $ecs = '1000000001';
        }

        $data['ecs_number'] = $ecs;
        $data['paid_registration'] = 1;
        $data['certificate_of_incorporation'] = "0";
        $data['account_officer_id'] = "0";
        $data['company_rcnumber'] = "0";
        $data['company_name'] = $data['contact_firstname'] . ' ' . $data['contact_surname'];
        $data['contact_number'] = $data['company_phone'];

        $employer = Employer::updateOrCreate(['ecs_number' => $data['ecs_number']], $data);

        try {
            Mail::to($employer->company_email)->send(new EmployerRegisteredMail($employer, $password));
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
        }

        return $employer;
    }

    public function showRegistrationForm()
    {
        $branches = Branch::all();

        $states = State::all();


        // $allOption = new Branch();
        // $allOption->id = 0;
        // $allOption->branch_name = 'All';
        // $branches->prepend($allOption);

        $services = Service::where('branch_id', 1)->get();

        $allservices = new Service();
        $allservices->id = 0;
        $allservices->name = 'ALL';
        $services->prepend($allservices);

        return view('auth.sign_up', compact('branches', 'services', 'states'));
    }

    public function loginaspromoter(Request $request)
    {
        $user = Epromoteruser::where('email', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $branches = Branch::all();
            $applicants = Employer::where('promotercode', $user->promotercode)->get();

            return view('promota.index', compact('user', 'applicants', 'branches'));
        } else {
            return redirect()->back()->with('error', 'Wrong Credentials');
        }
    }

    public function saveregidtrationform(Request $request)
    {
        // dd($request->all());
        $existingEmployer = Employer::where('company_email', $request->company_email)->first();
        if ($existingEmployer) {
            return redirect()->back()->with('error', 'User already exists');
        }


        $code = 'NIRC' . date('Y') . '-' . substr(rand(0, time()), 0, 5);
        $password = $request->password;

        $employer = new Employer();
        $employer->user_type = $request->user_type;
        $employer->contact_firstname = $request->contact_firstname;
        $employer->contact_surname = $request->contact_surname;
        $employer->company_phone = $request->company_phone;
        $employer->contact_number = $request->company_phone;
        $employer->branch_id = $request->areaoffice;
        //put the company_phone into the contact_phone
        $employer->company_email = $request->company_email;
        if ($request->user_type =='private') {
            $employer->company_name = $request->contact_firstname .' '. $request->contact_surname;
            # code...
        } elseif($request->user_type=='company'){
            $employer->company_name=$request->company_name;
            $employer->company_address=$request->conpany_address;
        }
        $employer->password = Hash::make($password);
        $employer->status = $request->status;
        $employer->applicant_code = $code;

        if ($request->promotercode) {
            $employer->promotercode = $request->promotercode;
        }

        $employer->save();

        if ($request->user_type == 'e-promoter') {
            $service = $request->service_type;
            $office = $request->areaoffice;
            foreach ($service as $key => $value) {
                $type = new Epromoterservices();
                $type->applicant_code = $employer->applicant_code;
                $type->service_id = $service[$key];
                $type->areaoffice_id = $office;
                $type->save();
            }
        }
        try {
            Mail::to($employer->company_email)->send(new EmployerRegisteredMail($employer, $password));
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
        }
        Auth::login($employer);
        return redirect()->route('home')->with('success', 'Registration Successful, Awaiting Approval');
    }

    public function epromoterapplicant(Request $request)
    {
        $code = 'NIRC' . date('Y') . '-' . substr(rand(0, time()), 0, 5);
        $password = $request->password;

        $employer = new Employer();
        if ($request->company_name) {
            $employer->company_name = $request->company_name;
        }
        if ($request->company_address) {
            $employer->company_address = $request->company_address;
        }
        if ($request->promotercode) {
            $employer->promotercode = $request->promotercode;
        }
        if ($request->contact_number) {
            $employer->contact_number = $request->contact_number;
        }
        if ($request->company_email) {
            $employer->company_email = $request->company_email;
        }

        $employer->user_type = $request->user_type;
        $employer->contact_firstname = $request->contact_firstname;
        $employer->contact_surname = $request->contact_surname;
        $employer->company_phone = $request->company_phone;
        $employer->password = Hash::make($request->password);
        $employer->status = $request->status;
        $employer->applicant_code = $code;

        $employer->save();

        try {
            Mail::to($employer->company_email)->send(new EmployerRegisteredMail($employer, $password));
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
        }

        return redirect()->back()->with('success', 'SUBMITTED, AWAITING APPROVAL');
    }
}
