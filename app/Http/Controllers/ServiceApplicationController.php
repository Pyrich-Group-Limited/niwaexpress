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


class ServiceApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        //$services = Service::where('branch_id', $user->branch->id)->get();

        //$service_applications = ServiceApplication::where('user_id', $user->id)->paginate(10);
        /* $service_applications = ServiceApplication::with('processingType')->where('user_id', $user->id)
            ->select('service_applications.*', 'processing_types.name as pname')
            ->join('processing_types', 'service_applications.service_type_id', '=', 'processing_types.id')
            //->where('branch_id', Auth()->user()->branch->id)
            ->paginate(10); */
        $service_applications = ServiceApplication::orderBy('id', 'desc')->where('user_id', $user->id)
            ->paginate(10);


        $service_app = ServiceApplication::where('user_id', $user->id)->first();
        /* if($service_app){
        $pro_type = ProcessingType::where('service_id', $service_app->service_id)->get();
        } */

        return view('service_applications.index', compact('service_applications', 'service_app'));
    }

    public function area_office_document()
    {



        $branches = Branch::get()->pluck('branch_name', 'id');
        $branches = $branches->prepend('Select Area Office', '');
        $services = Service::where('branch_id', 1)->get();
        // Getting an item from the session
        $branch_id = Session::get('branch_id');
        $service_id = Session::get('service_id');
        // dd($service_id);


        return view('service_applications.area_office_create', compact(['branches', 'services', 'branch_id', 'service_id']));
    }

    //
    public function epromotaarea_office_document($id)
    {


        $user = Employer::findOrFail($id);



        $branches = Branch::get()->pluck('branch_name', 'id');
        $branches = $branches->prepend('Select Area Office', '');
        $services = Service::where('branch_id', 1)->get();
        // Getting an item from the session
        $branch_id = Session::get('branch_id');
        $service_id = Session::get('service_id');
        // dd($service_id);


        return view('promota.area_office_create', compact(['branches','user', 'services', 'branch_id', 'service_id']));
    }

    public function storeIncoming(Requests $request)
    {
        // dd($request->all());

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
        //IncomingDocuments::create($document_input);
        DB::table('incoming_documents_manager')->insert($document_input);





        return redirect()->back()->with('success', 'Document sent successfully. We will get back to you later. Thank you');
    }



    /*
     A client can apply for a service here
     */
    public function ServiceApplication()
    {
        $user = Auth::user();
        //$services = Service::where('branch_id', $user->branch->id)->get();

        $branches = Branch::all();

        //$service_applications = ServiceApplication::where('user_id', $user->id)->paginate(10);
        $service_applications = ServiceApplication::with('processingType')->where('user_id', $user->id)
            ->select('service_applications.*', 'processing_types.name as pname')
            ->join('processing_types', 'service_applications.service_type_id', '=', 'processing_types.id')
            ->paginate(10);

        $service_app = ServiceApplication::where('user_id', $user->id)->first();
        /* if($service_app){
        $pro_type = ProcessingType::where('service_id', $service_app->service_id)->get();
        } */
        $services = Service::where('branch_id', 1)->get();

        $axis = Axis::all();
        // dd('ss');

        return view('service_applications.service_application', compact('service_applications', 'service_app', 'branches', 'services', 'axis'));
    }

    public function Epromoterserviceapplication($id)
    {

        //pass the user add

        // $user = Auth::user();
        $user = $id;
        // dd($user);
        //$services = Service::where('branch_id', $user->branch->id)->get();

        $branches = Branch::all();

        //$service_applications = ServiceApplication::where('user_id', $user->id)->paginate(10);
        $service_applications = ServiceApplication::with('processingType')->where('user_id', $user)
            ->select('service_applications.*', 'processing_types.name as pname')
            ->join('processing_types', 'service_applications.service_type_id', '=', 'processing_types.id')
            ->paginate(10);

        $service_app = ServiceApplication::where('user_id', $user)->first();
        /* if($service_app){
        $pro_type = ProcessingType::where('service_id', $service_app->service_id)->get();
        } */
        $services = Service::where('branch_id', 1)->get();

        $axis = Axis::all();
        // dd('ss');
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
        $input = $request->all();
        $branch_id = $input['branch_id'];

        if ($branch_id != null) {
            $employer = Employer::findOrFail($userID);
            $employer->branch_id = $branch_id;
            $save = $employer->save();
            if ($save) {
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
        $service = Service::find($id);
        //$processingTypes = $processingType->where('branch_id', $service->branch_id)->get();
        $processingTypes = ProcessingType::where('service_id', $id)->get();
        return response()->json($processingTypes);
    }

    public function getServicesByBranch($id)
    {
        $services = Service::where('branch_id', $id)->where('status', 1)->get();
        //$processingTypes = $processingType->where('branch_id', $service->branch_id)->get();
        //$processingTypes = $service->processingTypes()->get();
        return response()->json($services);
    }

    public function documentIndex($id)
    {
        $user = Auth::user();

        $service_application = ServiceApplication::findOrFail($id);

        $documents = ServiceApplicationDocument::where('service_application_id', $service_application->id)->paginate(10);

        if ($service_application) {
            $doc_uploads = DocumentUpload::select('id', 'name') // Include all non-aggregated columns here
                //->where('branch_id', $user->branch->id)
                ->where('service_id', $service_application->service_id)
                ->groupBy('id', 'name') // Include all non-aggregated columns here
                ->get();
        }

        return view('service_applications.documents', compact('documents', 'service_application', 'doc_uploads'));
    }

    public function resubmitDocuments($id)
    {
        $user = Auth::user();

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
        return redirect(route('service-applications.index'))
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

        $find = IncomingDocuments::where('email', Auth::user()->company_email)->where('branch_id', $input['branch_id'])->where('title', $input['service_id'])->first();

        if ($find) {
            $path = 'documents/';


            $input['user_id'] = $userID;

            $serviceApplication = ServiceApplication::create($input);

            $employer = Employer::findOrFail($userID);
            $employer->branch_id = $input['branch_id'];
            $employer->save();

            return redirect(route('service-applications.index'))->with('success', 'Application created successfully.');
        } else {

            return redirect(route('add.new.incoming.document'));
        }
    }


    public function Epromotastore(StoreServiceApplicationRequest $request)
    {

        $input = $request->all();
        $userID = $request->applicant_id;


        $user = Employer::findOrFail($userID);


        $find = IncomingDocuments::where('email',  $user->company_email)->where('branch_id', $input['branch_id'])->where('title', $input['service_id'])->first();

        if ($find) {
            $path = 'documents/';


            $input['user_id'] = $userID;

            $serviceApplication = ServiceApplication::create($input);

            $employer = Employer::findOrFail($userID);
            $employer->branch_id = $input['branch_id'];
            $employer->save();

            return redirect(route('service-applications.index'))->with('success', 'Application created successfully.');
        } else {

            return redirect(route('epromotaadd.new.incoming.documente',[$user->id]));
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
