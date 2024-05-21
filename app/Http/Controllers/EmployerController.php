<?php

namespace App\Http\Controllers;

use App\Models\LGA;
use App\Models\Branch;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Models\Epromoterservices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\OTPNotification;
use function PHPUnit\Framework\isEmpty;

use App\Http\Requests\StoreEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        // Check if the email already exists in the database
        $exists = Employer::where('company_email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function checkPhone(Request $request)
    {
        $email = $request->input('phone');

        // Check if the email already exists in the database
        $exists = Employer::where('company_phone', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function index()
    {
        //
    }
    public function createpage()
    {
        $branches = Branch::all();

        return view('promota.create', compact('branches'));
    }

    public function storepage(Request $request)
    {
        if ($request->user_type == 'private') {
            // dd($request->all());

            $existingEmployer = Employer::where('company_email', $request->contact_email)->first();
        } else {

            $existingEmployer = Employer::where('company_email', $request->company_email)->first();
        }


        if ($existingEmployer) {
            // dd($existingEmployer);
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
        $employer->contact_middlename = $request->contact_middle;
        if ($request->user_type == 'private') {
            $employer->company_email = $request->contact_email;
            $employer->company_name =  $request->contact_firstname .''. $request->contact_surname;

            $employer->company_address = $request->contact_address;
        } else {
            $employer->company_address = $request->company_address;
            $employer->company_email = $request->company_email;
            $employer->company_name = $request->company_name;
        }
        $employer->branch_id = $request->company_state;
        $employer->password = Hash::make($password);

        $employer->contact_number = $request->contact_number;

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
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employer $employer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployerRequest $request, Employer $employer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        //
    }

    /**
     * Get Employer with ECS Number
     */
    public function ecs(Request $request)
    {
        if ($request->ecs == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Provide ECS Number!'
            ]);
        }

        try {
            $employer = Employer::where('ecs_number', $request->ecs)->firstOrFail();

            //generate otp
            $pin = rand(100000, 999999);
            $currentTimestamp = time();

            // Add 15 minutes in seconds (15 minutes * 60 seconds)
            $fifteenMinTimestamp = $currentTimestamp + (15 * 60);
            //save to db
            DB::table('otps')->updateOrInsert([
                'pinnable_type' => 'App\\Models\\Employer',
                'pinnable_id' => $employer->id,
                'expires_at' => date('Y-m-d H:i:s', $fifteenMinTimestamp)
            ], [
                'otp' => $pin,
            ]);

            //send notification
            $employer->notify(new OTPNotification($employer, $pin));

            return response()->json([
                'status' => 'success',
                'message' => 'Employer details found and populated! <br/>An OTP has been sent to email [<b>' . (substr($employer->company_email, 0, 1)) . '***' . (substr(explode('@', $employer->company_email)[0], -1, 1)) . substr($employer->company_email, strpos($employer->company_email, "@")) . '</b>]. <br/>Search again to <b>resend</b> OTP.',
                'employer' => $employer,
                'ecs' => $request->ecs,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found!'
            ]);
        }
    }

    public function verifyotp(Request $request)
    {
        $employer = Employer::where('ecs_number', $request->ecs)->first();

        $rows = DB::table('otps')
            ->where('pinnable_id', $employer->id)
            ->where('pinnable_type', 'App\\Models\\Employer')
            ->where('otp', $request->otp)
            ->whereRaw("expires_at >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)")
            ->count();

        if ($rows < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP!',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verification successful!',
        ]);
    }

    public function lgas(Request $request)
    {
        return response()->json([
            'data' => LGA::where('state_id', $request->state)->get() ?? [],
        ]);
    }

    public function profile()
    {
        return view('employers.profile');
    }
}
