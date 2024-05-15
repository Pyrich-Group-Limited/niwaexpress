<?php

namespace App\Http\Controllers;

use App\Mail\PaymentStatusMail;
use App\Models\Employee;
use App\Models\Employer;
use App\Models\Payment;
use App\Models\EmployerDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmployerDocumentEmail;
use Illuminate\Support\Facades\DB;

class EmployerDocumentController extends Controller
{

    public function index()
    {
        $employer_documents = EmployerDocuments::where('employer_id', auth()->user()->id)->get();
        return view('documents.index', compact(['employer_documents']));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function niwaAct()
    {
        return view('documents.niwa_act');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_document' => 'required|string|max:255',
            'title_document_file' => 'required|file|mimes:pdf|max:2048',
            'survey_document' => 'required|string|max:255',
            'survey_document_file' => 'required|file|mimes:pdf|max:2048',
            'sand_search_report' => 'required|string|max:255',
            'sand_search_report_file' => 'required|file|mimes:pdf|max:2048',
            'cac_certificate' => 'required|string|max:255',
            'cac_certificate_file' => 'required|file|mimes:pdf|max:2048',
            'pre_post_dredge_survey_drawings' => 'required|string|max:255',
            'pre_post_dredge_survey_drawings_file' => 'required|file|mimes:pdf|max:2048',
            'eia_report' => 'required|string|max:255',
            'eia_report_file' => 'required|file|mimes:pdf|max:2048',
        ]);
        
        $documents = [
            'title_document' => 'title_document_file',
            'survey_document' => 'survey_document_file',
            'sand_search_report' => 'sand_search_report_file',
            'cac_certificate' => 'cac_certificate_file',
            'pre_post_dredge_survey_drawings' => 'pre_post_dredge_survey_drawings_file',
            'eia_report' => 'eia_report_file',
        ];
        
        $path = 'documents/';
        $userID = \Auth::user()->id;
        
        foreach ($documents as $titleInput => $fileInput) {
            $title = $request->input($titleInput);
            $file = $request->file($fileInput);
        
            if ($file) {
                $name = $userID . '_documents.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/' . $path), $name);
                $filePath = $path . $name;
        
              $employer_documents =  EmployerDocuments::create([
                    'employer_id' => auth()->user()->id,
                    'title' => $title,
                    'file_path' => $filePath,
                ]);
            }
        }
        
        $payment = Payment::where('employer_id', auth()->user()->id)->where('document_uploads', 1)->latest()->first();

           $payment->document_uploads = 0;
            $payment->save();

            
            try {
                // Fetch user roles, email, and department from the staff table and roles table
                $userDetails = DB::table('staff')
                    ->join('model_has_roles', 'staff.user_id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->join('users', 'staff.user_id', '=', 'users.id')
                    ->where('model_has_roles.model_type', 'App\Models\User')
                    ->select('users.email', 'roles.name as role', 'staff.department_id')
                    ->get();
            
                // Define the roles and departments you want to notify
                $targetRoles = ['HOD'];
                $targetDepartments = [7, 11, 13];
            
                // Filter email addresses based on user roles and departments
                $filteredEmailAddresses = [];
            
                foreach ($userDetails as $user) {
                    if (in_array($user->role, $targetRoles) && in_array($user->department_id, $targetDepartments)) {
                        $filteredEmailAddresses[] = $user->email;
                    }
                }
            
                // Send thank you email to each filtered email address
                foreach ($filteredEmailAddresses as $email) {
                    Mail::to($email)->send(new EmployerDocumentEmail($employer_documents, auth()->user()));
                }
            
                return redirect('/documents/index')->with('success', 'Document uploaded successfully. You will be notified as soon as they are approved.');
            } catch (\Exception $e) {
                // Handle the exception here
                return redirect()->route('documents.index')->with('error', 'Failed to notify everyone: ' . $e->getMessage());
            }            
        
        
    }
}