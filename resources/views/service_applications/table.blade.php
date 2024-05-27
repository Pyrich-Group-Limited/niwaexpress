@foreach ($service_applications as $application)
    @php
        $user = Auth::user();
        $app_form_fee = \App\Models\ApplicationFormFee::where('service_id', $application->service_id)
            ->where('processing_type_id', $application->service_type_id)
            ->first();
        $doc_upload = \App\Models\DocumentUpload::where('service_id', $application->service_id)
            ->first();
        $pro_fee = \App\Models\ProcessingFee::where('service_id', $application->service_id)
            ->where('processing_type_id', $application->service_type_id)
            ->first();
        $ins_fee = \App\Models\InspectionFee::where('service_id', $application->service_id)
            ->where('processing_type_id', $application->service_type_id)
            ->first();
        $app_fee = \App\Models\Payment::where('payment_status', 1)
            ->where('approval_status', 1)
            ->where('payment_type', 1)
            ->where('employer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
    @endphp

    <div class="card card-bordered card-preview mt-4 mb-3">
        <div class="card-body">
            <div class="card-title">
                <h4>Service: {{ $application->service ? $application->service->name : '' }}</h4>
            </div>
            {{-- @dd($application->current_step); --}}
            <div class="row">
                <div class="row col-6">
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Location:</span>
                        <span>{{ $application->branch ? $application->branch->branch_name : '' }}</span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Application Form Payment Status:</span>
                        <span>{{ $application->application_form_payment_status ? 'Paid' : 'Not Paid' }}</span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Date of Inspection:</span>
                        <span>{{ $application->date_of_inspection }}</span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Inspection Message:</span>
                        <span>{{ $application->comments_on_inspection }}</span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Service Type:</span>
                        <span>{{ $application->processingType ? ucwords($application->processingType->name) : '' }}</span>
                    </div>
                    @if($application->mse_document_verification_comment)
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Comments On Declined Documents:</span>
                        <span class="text-danger">{{ $application->mse_document_verification_comment }}</span>
                    </div>
                    @endif
                </div>
                <div class="row col-6">
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Status Summary:</span>
                        <span>{{ $application->status_summary }}</span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">My Documents:</span>
                        <span>
                            @if ($application->current_step > 5)
                                <a href="{{ route('service-applications.documents.index', $application->id) }}"
                                    title="Documents"><span class="nk-menu-icon text-secondary">View
                                        Documents</span></a>

                            @endif
                        </span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Created:</span>
                        <span>{{ $application->created_at }}</span>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-12 mb-3">
                        <span class="sub-text">Action:</span>
                        <span>
                            @if ($app_form_fee)
                                @if ($application->current_step == 2)
                                    <a href="{{ route('application_form_payment', $application->id) }}"
                                        title="Application form payment"><span class="nk-menu-icon text-danger">Pay for
                                            Application form</span>
                                    </a>
                                @endif

                            @endif
                            @if ($doc_upload)
                               {{--  @if ($app_fee) --}}
                                    @if ($application->current_step == 41)
                                        <a href="{{ route('service-applications.documents.index', $application->id) }}"
                                            title="Documents"><span class="nk-menu-icon text-danger">Add
                                                Documents</span></a>
                                    @endif
                                    @if ($application->current_step == 42)
                                        <a href="{{ route('service-applications.documents.add', $application->id) }}"
                                            title="Documents"><span class="nk-menu-icon text-danger">Add
                                                Documents</span></a>
                                    @endif
                               {{--  @endif --}}

                            @endif
                            @php
                                $processing_fee_payment = $application
                                    ->payments()
                                    ->where('payment_type', '=', 2)
                                    ->first();

                                if ($processing_fee_payment) {
                                    $is_processing_fee_paid = $processing_fee_payment->payment_status;
                                } else {
                                    $is_processing_fee_paid = 0;
                                }

                            @endphp
                            {{--  @if ($application->current_step == 4 && !$is_processing_fee_paid) --}}
                            @if ($pro_fee)
                                @if ($application->current_step == 6)
                                    <a href="{{ route('processing_fee_payment', $application->id) }}"
                                        title="Processing fee payment"><span class="nk-menu-icon text-danger">Pay for
                                            Processing Fee</span>
                                    </a>
                                @endif

                            @endif

                            @if ($ins_fee)
                                @if ($application->current_step == 7)
                                    <a href="{{ route('inspection_fee_payment', $application->id) }}"
                                        title="Inspection fee payment"><span class="nk-menu-icon text-danger">Pay for
                                            Inspection Fee</span>
                                    </a>
                                @endif

                               @endif

                            @if ($application->current_step == 13)
                                <a href="{{ route('equipment_fee_payment', $application->id) }}"
                                    title="Equipment fee payment"><span class="nk-menu-icon text-danger">Pay for
                                        Equipment and Monitoring Fees</span>
                                </a>
                            @endif

                            @if ($application->current_step == 15)
                                <a href="{{ route('download_permit', $application->id) }}" title="Download Permit"
                                    target="_blank"><span class="nk-menu-icon text-secondary">Download Permit</span>
                                </a>
                            @endif
                        </span>
                    </div>
                </div>


            </div>

        </div>
    </div>
@endforeach

<div class="card">
    {{ $service_applications->links() }}
</div>
