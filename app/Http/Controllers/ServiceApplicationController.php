<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\Service;
use App\Models\Branch;
use App\Models\ServiceApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceApplicationDocument;
use App\Http\Requests\StoreSwitchAreaOfficeRequest;
use App\Http\Requests\StoreServiceApplicationRequest;
use App\Http\Requests\UpdateServiceApplicationRequest;
use App\Http\Requests\StoreServiceApplicationDocumentRequest;
use App\Models\ApplicationFormFee;
use App\Models\DocumentUpload;
use App\Models\ProcessingType;
use Illuminate\Support\Facades\DB;
use App\Models\Employer;
use App\Models\Signature;
use App\Models\IncomingDocuments;
use Illuminate\Http\Request as Requests;
use App\Models\Axis;
use Illuminate\Support\Facades\Session;
use App\Models\DeclinedDocument;
use App\Mail\EmployerDocumentEmail;
use App\Mail\IncomingAndServiceEmail;
use Illuminate\Support\Facades\Mail;




class ServiceApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $service_applications = ServiceApplication::orderBy('id', 'desc')->where('user_id', $user->id)->paginate(10);
        $service_app = ServiceApplication::where('user_id', $user->id)->first();

        return view('service_applications.index', compact('service_applications', 'service_app'));
    }
    public function epromoterindex($id)
    {

        // $user = Auth::user();
        $user =Employer::find($id);

        $service_applications = ServiceApplication::orderBy('id', 'desc')->where('user_id', $id)->paginate(10);
        // dd($service_applications);
        $service_app = ServiceApplication::where('user_id', $id)->first();

        return view('promota.applied', compact('service_applications', 'user','service_app'));
    }

    public function area_office_document()
    {
        $branches = Branch::get()->pluck('branch_name', 'id')->prepend('Select Area Office', '');
        $services = Service::where('branch_id', 1)->get();
        $branch_id = Session::get('branch_id');
        $service_id = Session::get('service_id');

        return view('service_applications.area_office_create', compact('branches', 'services', 'branch_id', 'service_id'));
    }

    public function epromotaarea_office_document($id)
    {

        $user = Employer::findOrFail($id);
        $branches = Branch::get()->pluck('branch_name', 'id')->prepend('Select Area Office', '');
        $services = Service::where('branch_id', 1)->get();
        $branch_id = Session::get('branch_id');
        $service_id = Session::get('service_id');

        return view('promota.area_office_create', compact('branches', 'user', 'services', 'branch_id', 'service_id'));
    }

    public function storeIncoming(Requests $request)
    {

    // Validate the request
$validatedData = $request->validate([
    'service_id' => 'required',
    'full_name' => 'required',
    'email' => 'required|email',
    'phone' => 'required|numeric',
    'department_id' => 'required|numeric',
    'branch_id' => 'required|numeric',
    'status' => 'required|numeric',
    'description' => 'required',
    'file' => 'required|mimes:pdf,doc,docx,jpeg,png,gif|max:1024',
], [
    'file.mimes' => 'Please select a valid file format (PDF, DOC, DOCX, JPEG, PNG, GIF).',
    'file.max' => 'File size exceeds the maximum limit of 1MB.',
]);

// Prepare document input
$document_input = [
    'title' => $validatedData['service_id'],
    'description' => $validatedData['description'],
    'full_name' => $validatedData['full_name'],
    'email' => $validatedData['email'],
    'phone' => $validatedData['phone'],
    'category_id' => 1,
    'created_by' => 0,
    'status' => $validatedData['status'],
    'department_id' => $validatedData['department_id'],
    'branch_id' => $validatedData['branch_id']
];

// Save file
$path = "documents";
$file = $request->file('file');
$fileExtension = $file->getClientOriginalExtension();
$title = str_replace(' ', '', $validatedData['service_id']);
$file_name = $title . '_v1_' . uniqid() . '.' . $fileExtension;
$file->move(public_path($path), $file_name);
$document_input['document_url'] = $path . "/" . $file_name;

// Create IncomingDocument
//IncomingDocuments::create($document_input);
$inserted = DB::table('incoming_documents_manager')->insert($document_input);

// start
$userID = Auth::user()->id;

// Create an array with session values
$input = [
    'user_id' => $userID,
    'branch_id' => Session::get('branch_id'),
    'service_id' => Session::get('service_id'),
    'axis_id' => Session::get('axis_id'),
    'service_type_id' => Session::get('service_type_id'),
    'latitude1' => Session::get('latitude1'),
    'longitude1' => Session::get('longitude1'),
    'latitude2' => Session::get('latitude2'),
    'longitude2' => Session::get('longitude2')
];

// Create a new ServiceApplication instance and save it
$serviceApplication = ServiceApplication::create($input);

// Update employer's branch_id
$employer = Employer::findOrFail($userID);
$employer->branch_id = $input['branch_id']; // Assuming branch_id is one of the session values
$employer->save();

 //send to area manager
 $area_manager = DB::table('staff')
 ->join('users', 'staff.user_id', '=', 'users.id')
 ->where('staff.branch_id', auth()->user()->branch_id)
 ->where('users.level_id', 3)
 ->select('users.first_name', 'users.email') // Select both first_name and email
 ->first();
 $incoming = 1;

         try {
             
             $user = Auth::user();
             Mail::to($area_manager->email)->send(new IncomingAndServiceEmail($incoming, $user, $area_manager, $serviceApplication, $document_input));

             //return redirect('/dashboard')->with('success', 'Invoice notification sent successfully.');
         } catch (\Exception $e) {
             // Handle the exception
             //return redirect('/dashboard')->with('error', 'Failed to send invoice notification: ' . $e->getMessage());
         }

Session::forget('branch_id');
Session::forget('service_id');
Session::forget('axis_id');
Session::forget('service_type_id');
Session::forget('latitude1');
Session::forget('longitude1');
Session::forget('latitude2');
Session::forget('longitude2');

return redirect(route('service-applications.index'))->with('success', 'Document sent and application created successfully.');
// Removing an item from the session
// Session::forget('key');
// end



        //return redirect()->back()->with('success', 'Document sent successfully. We will get back to you later. Thank you');

    }
    public function epromotastoreIncoming(Requests $request)
    {

        $user_id= $request->user_id;
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'department_id' => 'required|numeric',
            'branch_id' => 'required|numeric',
            'status' => 'required|numeric',
            'description' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,jpeg,png,gif|max:1024',
        ], [
            'file.mimes' => 'Please select a valid file format (PDF, DOC, DOCX, JPEG, PNG, GIF).',
            'file.max' => 'File size exceeds the maximum limit of 1MB.',
        ]);

        // Prepare document input
        $document_input = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'category_id' => 1,
            'created_by' => 0,
            'status' => $validatedData['status'],
            'department_id' => $validatedData['department_id'],
            'branch_id' => $validatedData['branch_id']
        ];

        // Save file
        $path = "documents";
        $file = $request->file('file');
        $fileExtension = $file->getClientOriginalExtension();
        $title = str_replace(' ', '', $validatedData['title']);
        $file_name = $title . '_v1_' . uniqid() . '.' . $fileExtension;
        $file->move(public_path($path), $file_name);
        $document_input['document_url'] = $path . "/" . $file_name;

        // Create IncomingDocument
        DB::table('incoming_documents_manager')->insert($document_input);

        $userID = $user_id;

        // Create an array with session values
        $input = [
            'user_id' => $userID,
            'branch_id' => Session::get('branch_id'),
            'service_id' => Session::get('service_id'),
            'axis_id' => Session::get('axis_id'),
            'service_type_id' => Session::get('service_type_id'),
            'latitude1' => Session::get('latitude1'),
            'longitude1' => Session::get('longitude1'),
            'latitude2' => Session::get('latitude2'),
            'longitude2' => Session::get('longitude2')
        ];

        // Create a new ServiceApplication instance and save it
        $serviceApplication = ServiceApplication::create($input);

        // Update employer's branch_id
        $employer = Employer::findOrFail($userID);
        $employer->branch_id = $input['branch_id'];
        $employer->save();

        Session::forget(['branch_id', 'service_id', 'axis_id', 'service_type_id', 'latitude1', 'longitude1', 'latitude2', 'longitude2']);

        return redirect(route('epromota_service_application_index',[$user_id]))->with('success', 'Document sent and application created successfully.');
    }

    /*
     * A client can apply for a service here
     */
    public function ServiceApplication()
    {
        $user = Auth::user();
        $branches = Branch::all();
        $service_applications = ServiceApplication::with('processingType')
            ->where('user_id', $user->id)
            ->select('service_applications.*', 'processing_types.name as pname')
            ->join('processing_types', 'service_applications.service_type_id', '=', 'processing_types.id')
            ->paginate(10);
        $service_app = ServiceApplication::where('user_id', $user->id)->first();
        $services = Service::where('branch_id', 1)->get();
        $axis = Axis::all();

        return view('service_applications.service_application', compact('service_applications', 'service_app', 'branches', 'services', 'axis'));
    }

    public function Epromoterserviceapplication($id)
    {
        $user = Employer::findOrFail($id);
        $branches = Branch::all();
        $service_applications = ServiceApplication::with('processingType')
            ->where('user_id', $user->id)
            ->select('service_applications.*', 'processing_types.name as pname')
            ->join('processing_types', 'service_applications.service_type_id', '=', 'processing_types.id')
            ->paginate(10);
        $service_app = ServiceApplication::where('user_id', $user->id)->first();
        $services = Service::where('branch_id', 1)->get();
        $axis = Axis::all();

        return view('promota.applyforaservice', compact('service_applications', 'user', 'service_app', 'branches', 'services', 'axis'));
    }

    public function switchAreaOffice()
    {
        $branches = Branch::all();
        return view('service_applications.switch_area_office', compact('branches'));
    }

    public function switchAreaOfficeSave(StoreSwitchAreaOfficeRequest $request)
    {
        $userID = Auth::user()->id;
        $branch_id = $request->input('branch_id');

        if ($branch_id) {
            $employer = Employer::findOrFail($userID);
            $employer->branch_id = $branch_id;
            if ($employer->save()) {
                return redirect()->back()->with('success', 'Your area office has been switched successfully');
            } else {
                return redirect()->back()->with('error', 'Your area office has not been switched. Contact the administrator for assistance');
            }
        } else {
            return redirect()->back()->with('error', 'Please select an Area Office');
        }
    }

    public function getProcessingTypes($id)
    {
        $processingTypes = ProcessingType::where('service_id', $id)->get();
        return response()->json($processingTypes);
    }

    public function getServicesByBranch($id)
    {
        $services = Service::where('branch_id', $id)->where('status', 1)->get();
        return response()->json($services);
    }

    public function documentIndex($id)
    {
        $user = Auth::user();
        $service_application = ServiceApplication::findOrFail($id);
        $documents = ServiceApplicationDocument::where('service_application_id', $service_application->id)->paginate(10);

        if ($service_application) {
            $doc_uploads = DocumentUpload::select('id', 'name')
                ->where('service_id', $service_application->service_id)
                ->groupBy('id', 'name')
                ->get();
        }

        return view('service_applications.documents', compact('documents', 'service_application', 'doc_uploads'));
    }
    
    public function documentAdd($id)
    {
        $user = Auth::user();
        $service_application = ServiceApplication::findOrFail($id);
        $documents = ServiceApplicationDocument::where('service_application_id', $service_application->id)->paginate(10);

        if ($service_application) {
            $doc_uploads = DeclinedDocument::select('id', 'name')
                ->where('service_id', $service_application->id)
                ->where('user_id', auth()->user()->id)
                ->groupBy('id', 'name')
                ->get();
        }

        return view('service_applications.add_documents', compact('documents', 'service_application', 'doc_uploads'));
    }

    public function EpromotadocumentIndex($service_application_id, $user_id)
    {
        // Fetch user and service application
        $user = Employer::findOrFail($user_id);
        $service_application = ServiceApplication::findOrFail($service_application_id);

        // Get documents related to the service application
        $documents = ServiceApplicationDocument::where('service_application_id', $service_application->id)->paginate(10);

        // Fetch document uploads if service application exists
        if ($service_application) {
            $doc_uploads = DocumentUpload::select('id', 'name')
                ->where('service_id', $service_application->service_id)
                ->groupBy('id', 'name')
                ->get();
        }

        // Return the view with the fetched data
        return view('promota.documents', compact('documents', 'user', 'service_application', 'doc_uploads'));
    }


    public function resubmitDocuments($id)
    {
        $service_application = ServiceApplication::findOrFail($id);
        $service_application->current_step = 5;
        $service_application->status_summary = 'Waiting for document and payment verification';
        $service_application->save();



        return redirect(route('service-applications.index', $service_application->id))->with('success', 'Documents resubmitted for verification.');
    }

    public function documentStore(StoreServiceApplicationDocumentRequest $request, $service_application_id)
    {
        // Retrieve all input data from the request
        $input = $request->all();

        // Define the documents array mapping input names to file input names
        $documents = [
            'title_document' => 'title_document_file',
        ];

        // Find the service application by ID
        $service_application = ServiceApplication::findOrFail($service_application_id);

        // Define the storage path and get the user ID
        $path = 'documents/';
        $userID = Auth::id(); // Use Auth::id() to get the authenticated user's ID

        // Array to store file paths
        $filePaths = [];

        // Iterate through the documents array and process each file
        //foreach ($documents as $titleInput => $fileInput) {
        foreach ($request->file('title_document_file') as $index => $file) {
            // Generate a unique file name
            $name = $this->generateFileName($file);

            // Move the file to the storage directory
            $file->move(public_path('storage/' . $path), $name);

            // Construct the file path
            $filePath = $path . $name;

            // Store the file path in the array
            $filePaths[$request->title_document[$index]] = $filePath;

           $service_doc = ServiceApplicationDocument::create([
                'service_application_id' => $service_application->id,
                'name' => $request->title_document[$index],
                'path' => $filePath,
            ]);

            

        }

        //send to area manager
        $area_manager = DB::table('staff')
        ->join('users', 'staff.user_id', '=', 'users.id')
        ->where('staff.branch_id', auth()->user()->branch_id)
        ->where('users.level_id', 3)
        ->select('users.first_name', 'users.email') // Select both first_name and email
        ->first();
    
                $declined_documents = DB::table('declined_documents')
        ->join('service_applications_documents', 'declined_documents.service_id', '=', 'service_applications_documents.service_application_id')
        ->where('declined_documents.service_id', $service_application->id)
        ->where('declined_documents.user_id', auth()->user()->id)
        ->select('service_applications_documents.name', 'service_applications_documents.path')
        ->get();
    
    
                try {
                    
                    $user = Auth::user();
                    Mail::to($area_manager->email)->send(new EmployerDocumentEmail($declined_documents, $user, $area_manager));
    
                    //return redirect('/dashboard')->with('success', 'Invoice notification sent successfully.');
                } catch (\Exception $e) {
                    // Handle the exception
                    //return redirect('/dashboard')->with('error', 'Failed to send invoice notification: ' . $e->getMessage());
                }
                
                $declined_documents1 = DeclinedDocument::where('user_id', auth()->user()->id)
    ->where('service_id', $service_application->id)
    ->get();

if ($declined_documents1->count() > 0) {
    foreach ($declined_documents1 as $document) {
        $document->delete();
    }
}

        // Save the user ID to the input data
        $input['user_id'] = $userID;

        // Iterate through the file paths and create ServiceApplicationDocument records
       /*  foreach ($filePaths as $title => $filePath) {
            ServiceApplicationDocument::create([
                'service_application_id' => $service_application->id,
                'name' => $title,
                'path' => $filePath,
            ]);
        } */

        // Update the current step of the service application
        $service_application->status_summary = 'Waiting for documents verification and approval';
        $service_application->current_step = 5;
        $service_application->save();

        // Redirect back with success message
        /* return redirect(route('service-applications.documents.index', $service_application->id))
            ->with('success', 'Documents saved successfully.'); */
            return redirect(route('service-applications.index'))
            ->with('success', 'Documents saved successfully.');
    }
    public function epromotadocumentStore(StoreServiceApplicationDocumentRequest $request, $service_application_id,$user_id)
    {
        // Retrieve all input data from the request
        $input = $request->all();

        // Define the documents array mapping input names to file input names
        $documents = [
            'title_document' => 'title_document_file',
        ];

        // Find the service application by ID
        $service_application = ServiceApplication::findOrFail($service_application_id);

        // Define the storage path and get the user ID
        $path = 'documents/';

        $userID =$user_id;

        // Array to store file paths
        $filePaths = [];

        // Iterate through the documents array and process each file
        //foreach ($documents as $titleInput => $fileInput) {
        foreach ($request->file('title_document_file') as $index => $file) {
            // Generate a unique file name
            $name = $this->generateFileName($file);

            // Move the file to the storage directory
            $file->move(public_path('storage/' . $path), $name);

            // Construct the file path
            $filePath = $path . $name;

            // Store the file path in the array
            $filePaths[$request->title_document[$index]] = $filePath;

            ServiceApplicationDocument::create([
                'service_application_id' => $service_application->id,
                'name' => $request->title_document[$index],
                'path' => $filePath,
            ]);

        }

        // Save the user ID to the input data
        $input['user_id'] = $userID;

        // Iterate through the file paths and create ServiceApplicationDocument records
       /*  foreach ($filePaths as $title => $filePath) {
            ServiceApplicationDocument::create([
                'service_application_id' => $service_application->id,
                'name' => $title,
                'path' => $filePath,
            ]);
        } */

        // Update the current step of the service application
        $service_application->status_summary = 'Waiting for document and payment verification';
        $service_application->current_step = 5;
        $service_application->save();

        // Redirect back with success message
        /* return redirect(route('service-applications.documents.index', $service_application->id))
            ->with('success', 'Documents saved successfully.'); */
            return redirect(route('epromota_service_application_index',[$userID]))
            ->with('success', 'Documents saved successfully.');
    }

    // Function to generate a unique file name
    private function generateFileName($file)
    {
        $userID = auth()->id();
        $timestamp = time();
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        return "{$userID}_{$timestamp}_{$originalName}";
    }

    public function applicationFormPayment($service_application_id)
    {
        $payments = $payments = auth()->user()->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment = auth()->user()->payments()
            ->where('payment_type', 1)
            ->where('payment_status', 0)
            ->get()->last();

        return view('service_applications.application_form_payment', compact('payments', 'service_application_id', 'pending_payment'));
    }

    public function epromotaapplicationFormPayment($service_application_id,$user_id)
    {
        // dd($user_id);
        // dd($service_application_id);


        //atp change the auth user to user_id
        $user=Employer::find($user_id);

        $payments = $payments =  $user->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment =  $user->payments()
            ->where('payment_type', 1)
            ->where('payment_status', 0)
            ->get()->last();

        return view('promota.application_form_payment', compact('payments', 'user', 'service_application_id', 'pending_payment'));
    }

    public function processingFeePayment($service_application_id)
    {
        $payments = auth()->user()->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment = auth()->user()->payments()
            ->where('payment_type', 2)
            ->where('payment_status', 0)
            ->get()->last();

        $service_application = ServiceApplication::findOrFail($service_application_id);

        return view('service_applications.processing_fee_payment', compact('payments', 'pending_payment', 'service_application', 'service_application_id'));
    }
    public function epromotaprocessingFeePayment($service_application_id,$userid)
    {
        $user= Employer::findOrFail($userid);
        $payments = $user->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment = $user->payments()
            ->where('payment_type', 2)
            ->where('payment_status', 0)
            ->get()->last();

        $service_application = ServiceApplication::findOrFail($service_application_id);

        // return view('service_applications.processing_fee_payment', compact('payments', 'pending_payment', 'service_application', 'service_application_id'));
        return view('promota.processing_fee_payment', compact('payments','user', 'pending_payment', 'service_application', 'service_application_id'));
    }

    public function inspectionFeePayment($service_application_id)
    {
        $payments = auth()->user()->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment = auth()->user()->payments()
            ->where('payment_type', 3)
            ->where('payment_status', 0)
            ->get()->last();

        $service_application = ServiceApplication::findOrFail($service_application_id);

        return view('service_applications.inspection_fee_payment', compact('payments', 'pending_payment', 'service_application', 'service_application_id'));
    }

    public function processingInspectionFeePayment($service_application_id)
    {
        $payments = auth()->user()->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment = auth()->user()->payments()
            ->where('payment_type', 2)
            ->where('payment_status', 0)
            ->get()->last();

        $service_application = ServiceApplication::findOrFail($service_application_id);

        return view('service_applications.processing_inspection_fee_payment', compact('payments', 'pending_payment', 'service_application', 'service_application_id'));
    }

    public function epromotainspectionFeePayment($service_application_id, $user_id)
    {
        // Fetch the user
        $user = Employer::findOrFail($user_id);

        // Fetch all payments in descending order
        $payments = $user->payments()->orderBy('created_at', 'DESC')->get();

        // Fetch the last pending payment of type 3
        $pending_payment = $user->payments()
            ->where('payment_type', 3)
            ->where('payment_status', 0)
            ->latest()
            ->first();

        // Fetch the service application
        $service_application = ServiceApplication::findOrFail($service_application_id);

        // Return the view with the fetched data
        return view('promota.inspection_fee_payment', compact(
            'payments',
            'user',
            'pending_payment',
            'service_application',
            'service_application_id'
        ));
    }

    public function equipmentFeePayment($service_application_id)
    {
        $payments = auth()->user()->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment = auth()->user()->payments()
            ->where('payment_type', 5)
            ->where('payment_status', 0)
            ->get()->last();

        $service_application = ServiceApplication::findOrFail($service_application_id);

        return view('service_applications.equipment_fee_payment', compact('payments', 'pending_payment', 'service_application'));
    }
    public function epromotaequipmentFeePayment($service_application_id,$userid)
    {
        $user= Employer::findOrFail($userid);
        $payments = $user->payments()->orderBy('created_at', 'DESC')->get();

        $pending_payment = $user->payments()
            ->where('payment_type', 5)
            ->where('payment_status', 0)
            ->get()->last();

        $service_application = ServiceApplication::findOrFail($service_application_id);

        return view('promota.equipment_fee_payment', compact('payments','user', 'pending_payment', 'service_application'));
    }

    public function downloadPermit($service_application_id)
    {
        $service_application = ServiceApplication::findOrFail($service_application_id);
        $signature = Signature::find(1);

        return view('service_applications.permit', compact('service_application', 'signature'));
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

    public function store(StoreServiceApplicationRequest $request)
    {
        $input = $request->all();
        $userID = Auth::user()->id;

        Session::put('branch_id', $input['branch_id']);
        Session::put('service_id', $input['service_id']);
        Session::put('axis_id', $input['axis_id']);
        Session::put('service_type_id', $input['service_type_id']);
        Session::put('latitude1', $input['latitude1']);
        Session::put('longitude1', $input['longitude1']);
        Session::put('latitude2', $input['latitude2']);
        Session::put('longitude2', $input['longitude2']);

        $find = IncomingDocuments::where('email', Auth::user()->company_email)->where('branch_id', $input['branch_id'])->where('title', $input['service_id'])->first();

        if($find) {
        $path = 'documents/';


        $input['user_id'] = $userID;


        // Removing an item from the session
        // Session::forget('key');
        $serviceApplication = ServiceApplication::create($input);

        $employer = Employer::findOrFail($userID);
        $employer->branch_id = $input['branch_id'];
        $employer->save();

        //send to area manager
 $area_manager = DB::table('staff')
 ->join('users', 'staff.user_id', '=', 'users.id')
 ->where('staff.branch_id', auth()->user()->branch_id)
 ->where('users.level_id', 3)
 ->select('users.first_name', 'users.email') // Select both first_name and email
 ->first();
 $incoming = 0;

         try {
             
             $user = Auth::user();
             $document_input = [];
             Mail::to($area_manager->email)->send(new IncomingAndServiceEmail($incoming, $user, $area_manager, $serviceApplication, $document_input));

             //return redirect('/dashboard')->with('success', 'Invoice notification sent successfully.');
         } catch (\Exception $e) {
             // Handle the exception
             //return redirect('/dashboard')->with('error', 'Failed to send invoice notification: ' . $e->getMessage());
         }

        return redirect(route('service-applications.index'))->with('success', 'Application created successfully.');

        }else{

        return redirect(route('add.new.incoming.document'));

        }

    }

        public function Epromotastore(StoreServiceApplicationRequest $request)
    {
        $input = $request->all();
// dd($input);
        $user = Employer::find($request->user_id);

        $userID = $user->id;
        Session::put('branch_id', $input['branch_id']);
        Session::put('service_id', $input['service_id']);
        Session::put('axis_id', $input['axis_id']);
        Session::put('service_type_id', $input['service_type_id']);
        Session::put('latitude1', $input['latitude1']);
        Session::put('longitude1', $input['longitude1']);
        Session::put('latitude2', $input['latitude2']);
        Session::put('longitude2', $input['longitude2']);
        // dd($userID);
        // $user= Employer::where('promotercode',$request->promotercode)->first();
        // dd($input);
        // $userID = Auth::user()->id;
        // $userID=$request->applicant_id;
        // dd($user);

        $find = IncomingDocuments::where('email',  $user->company_email)->where('branch_id', $input['branch_id'])->where('title', $input['service_id'])->first();
// dd( $find );
        if ($find) {
            $path = 'documents/';


            $input['user_id'] = $userID;

            $serviceApplication = ServiceApplication::create($input);

            $employer = Employer::findOrFail($userID);
            $employer->branch_id = $input['branch_id'];
            $employer->save();

            return redirect(route('epromota_service_application_index',[$user->id]))->with('success', 'Application created successfully.');
        } else {

            return redirect(route('epromotaadd.new.incoming.documente', [$userID]));
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceApplication $serviceApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceApplication $serviceApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceApplicationRequest $request, ServiceApplication $serviceApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceApplication $serviceApplication)
    {
        //
    }
}
