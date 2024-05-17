<?php

namespace App\Http\Controllers\Auth;

use App\Models\Epromoterservices;
use App\Models\Epromoteruser;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Mail\EmployerRegisteredMail;
use App\Models\Branch;
use App\Models\State;
use App\Providers\RouteServiceProvider;
use App\Models\Employer;
use App\Models\Service;
//use App\Notifications\EmployerRegistrationNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
        // Customize the redirect logic here
        //return route('payment.steps');
        return route('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
           // 'branch_id' => ['required'],
            'contact_surname' => ['required', 'string', 'max:255'],
            'contact_firstname' => ['required', 'string', 'max:255'],
            //'contact_middlename' => ['nullable', 'string', 'max:255'],
           // 'contact_position' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'string', 'max:255', 'unique:employers'],
            'user_type' => ['required', 'string', 'max:255'],
            //'contact_number' => ['nullable', 'string', 'max:255'],

           // 'company_state' => ['nullable', 'string', 'max:255'],
            //'company_localgovt' => ['nullable', 'string', 'max:255'],
            //'company_name' => ['nullable', 'string', 'max:255'],

            //'company_name' => ['required', 'string', 'max:255'],

            //'business_area' => ['required', 'string', 'max:255'],

            //'company_rcnumber' => ['nullable', 'string', 'max:255'],
            //'cac_reg_year' => ['nullable', 'date', 'max:255'],

            //'company_address' => ['nullable', 'string'],

            'company_email' => ['nullable', 'string', 'email', 'max:255', 'unique:employers'], // 'unique:employers'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // 'certificate_of_incorporation' => ['required', 'file', 'mimes:pdf'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Employer
     */
    protected function create(array $data)
    {
        unset($data['password_confirmation']);
        $data['user_id'] = 1;
        $password = $data['password'];
        $data['password'] = Hash::make($data['password']);

        //if ($data['employer_status'] == "new") {
            $last_ecs = Employer::get()->last();

            if ($last_ecs) {
                //if selected ecs belongs to another employer
                do {
                    $ecs = $last_ecs['ecs_number'] + 1;
                    $employer_exists = Employer::where('ecs_number', $ecs)->get()->last();
                } while ($employer_exists);
            } else {
                $ecs = '1000000001';
            }

            $data['ecs_number'] = $ecs;
        //}

        //record ECS registration payment for OLD Employers
        //if($data['employer_status'] != "new") {
            $data['paid_registration'] = 1;
        //}
        // Randomly select a user_id from the staff table in the same branch
        /* $randomUserId = DB::table('staff')
        ->where('branch_id', $data['branch_id'])
        ->inRandomOrder()
        ->value('user_id'); */

       /*  if ($randomUserId) {
            // Do something with the $randomUserId
        } else {
            // No user found in the same branch
            $errorMessage = "No user found in the same branch.";
        } */
        /* $file = $request->file('certificate_of_incorporation');
        $path = "employer/";
         $title = str_replace(' ', '', $data['company_name']);
         $fileName = $title . 'v1' . rand() . '.' . $file->getClientOriginalExtension();

         // Upload the file to the S3 bucket
         $documentUrl = Storage::disk('s3')->putFileAs($path, $file, $fileName); */

         $data['certificate_of_incorporation'] =  "0";//$documentUrl;

        $data['account_officer_id'] = "0";
        $data['company_rcnumber'] = "0";
       /*  $data['company_name'] = $data['company_name'] ? $data['company_name'] : $data['contact_firstname'] .' '.$data['contact_surname'];
        $data['company_address'] = $data['company_address'] ? $data['company_address'] : $data['personal_address'];
        $data['contact_number'] = $data['contact_number'] ? $data['contact_number'] : $data['company_phone'];
 */
$data['company_name'] = $data['contact_firstname'] .' '.$data['contact_surname'];
$data['contact_number'] = $data['company_phone'];

        $employer = Employer::updateOrCreate(['ecs_number' => $data['ecs_number']], $data); //new employer

        //send notification
        //$employer->notify(new EmployerRegistrationNotification($employer));
        //send email
        try {
            Mail::to($employer->company_email)->send(new EmployerRegisteredMail($employer, $password));
            // Your success logic here
        } catch (\Exception $e) {
            // Handle the exception
            // For example, you can log the error, redirect the user, or display a friendly error message
            //return redirect()->back()->with('error', 'Failed to send registration email: ' . $e->getMessage());
        }

        return $employer;
    }


    public function showRegistrationForm()
    {
        //$region = Region::all();
        $branches = Branch::all();

        $allOption = new Branch();
        $allOption->id = 0; // Use an ID that signifies "All" or whatever is appropriate for your logic.
        $allOption->branch_name = 'All'; // Adjust this field name according to your branch model's field.

        // Prepend the "All" option to the collection
        $branches->prepend($allOption);
        // dd($branches);
        $states = State::all();
        // dd($branches);
        $services = Service::all();

        $allservices = new Service();
        $allservices->id=0;
        $allservices->name='ALL';
        $services->prepend($allservices);
        // $services->prepend('All Services','')
        // dd($services);
        return view('auth.sign_up', compact('branches', 'services', 'states'));
    }


    public function loginaspromoter(Request $request)
    {
        // Retrieve the user by email
        $user = Epromoteruser::where('email', $request->username)->first();
        // Check if the user exists and the password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // dd($user);

            $branches = Branch::all();


            $applicants = Employer::where('promotercode', $user->promotercode)->get();



            return view('promota.index')
                ->with('user', $user)
                ->with('applicants',  $applicants)
                ->with('branches', $branches);
        } else {

            return redirect()->back()->with('error', 'Wrong Credentials');
        }
    }


    public function saveregidtrationform(Request $request)
    {

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
        $employer->company_email = $request->company_email;
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
                $type->areaoffice_id = $office[$key];
                $type->save();
            }

            # code...
        }
        return redirect()->route('login')->with('success', 'SUBMITTED , AWAITING APPROVAL');


        //for the service e those




        // $employer->password_confirmation=Hash::make($request->password_confirmation) ;


        // if ($request->service_type !== null) {
        //     //the code should be different
        //     $promotercode = 'NIPR-' . substr(rand(0, time()), 0, 5);
        //     $promoter = new Epromoteruser();
        //     $promoter->promotercode = $promotercode;
        //     $promoter->first_name = $request->contact_firstname;
        //     $promoter->other_name = $request->contact_surname;
        //     $promoter->phone_number = $request->company_phone;
        //     $promoter->email = $request->company_email;
        //     $promoter->office_id = $request->areaoffice;
        //     $promoter->service_id = $request->service_type;
        //     $promoter->status = $request->status;



        //     $promoter->password = Hash::make($request->password);
        //     $promoter->password_confirmation = Hash::make($request->password_confirmation);

        //     $promoter->save();
        //     return redirect()->back()->with('success', 'Registration Successful, Awaiting Approval');
        // } else {

        //     $employer = new Employer();
        //     if ($request->company_name) {
        //         $employer->company_name = $request->company_name;
        //     }
        //     if ($request->company_address) {
        //         $employer->company_address = $request->company_address;
        //     }
        //     if ($request->promotercode) {
        //         $employer->promotercode = $request->promotercode;
        //     }
        //     if ($request->contact_number) {
        //         $employer->contact_number = $request->contact_number;
        //     }
        //     if ($request->company_email) {
        //         $employer->company_email = $request->company_email;
        //     }
        //     $employer->user_type = $request->user_type;
        //     $employer->contact_firstname = $request->contact_firstname;
        //     $employer->contact_surname = $request->contact_surname;
        //     $employer->company_phone = $request->company_phone;
        //     $employer->company_email = $request->company_email;
        //     $employer->password = Hash::make($request->password);
        //     $employer->status = $request->status;
        //     // $employer->password_confirmation=Hash::make($request->password_confirmation) ;

        //     $employer->applicant_code = $code;
        //     $employer->save();
        //     try {
        //         Mail::to($employer->company_email)->send(new EmployerRegisteredMail($employer, $password));
        //         // Your success logic here
        //     } catch (\Exception $e) {
        //         // Handle the exception
        //         // For example, you can log the error, redirect the user, or display a friendly error message
        //         //return redirect()->back()->with('error', 'Failed to send registration email: ' . $e->getMessage());
        //     }

        //     // return $employer;

        //     return redirect()->route('login')->with('success', 'SUBMITTED , AWAITING APPROVAL');
        // }
    }


    public function epromoterapplicant(Request $request)
    {
        // dd('ss');
        // dd($request->all());
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
        $employer->company_email = $request->company_email;
        $employer->password = Hash::make($request->password);
        $employer->status = $request->status;
        // $employer->password_confirmation=Hash::make($request->password_confirmation) ;

        $employer->applicant_code = $code;
        $employer->save();
        try {
            Mail::to($employer->company_email)->send(new EmployerRegisteredMail($employer, $password));
            // Your success logic here
        } catch (\Exception $e) {
            // Handle the exception
            // For example, you can log the error, redirect the user, or display a friendly error message
            //return redirect()->back()->with('error', 'Failed to send registration email: ' . $e->getMessage());
        }

        // return $employer;


        return redirect()->back()->with('success', 'SUBMITTED , AWAITING APPROVAL');
    }
}
