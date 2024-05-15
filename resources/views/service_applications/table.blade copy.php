<div class="card card-bordered card-preview mt-4">
    <div class="card-inner">
        <table class="nowrap table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Application Form Payment Status</th>
                    <th>Date of Inspection</th>
                    <th>Inspection Message</th>
                    <th>Service Type</th>
                    <th>Status Summary</th>
                    <th>My Documents</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($service_applications as $application)
                @php $user = Auth::user();
                            $app_form_fee = \App\Models\ApplicationFormFee::where('branch_id', $user->branch->id)->where("service_id",$application->service_id)->first();
                            $doc_upload = \App\Models\DocumentUpload::where('branch_id', $user->branch->id)->where("service_id",$application->service_id)->first();
                            $pro_fee = \App\Models\ProcessingFee::where('branch_id', $user->branch->id)->where("service_id",$application->service_id)->where("processing_type_id",$application->service_type_id)->first();
                            $ins_fee = \App\Models\InspectionFee::where('branch_id', $user->branch->id)->where("service_id", $application->service_id)->first();
                            $app_fee = \App\Models\Payment::where('payment_status', 1)->where('approval_status', 1)->where('payment_type', 1)->where("employer_id", $user->id)->latest()->first();
                           @endphp

                    <tr>
                        <td>{{ $application->service ? $application->service->name : '' }}</td>
                        <td>{{ $application->application_form_payment_status ? 'Paid' : 'Not Paid' }}
                        </td>
                        <td>{{ $application->date_of_inspection }}</td>
                        <td>{{ $application->comments_on_inspection }}</td>
                        {{-- <td>{{ $application->service_type_id == 'mechanical' ? 'Mechanical' : 'NILL' }}</td> --}}
                        <td>{{ ucwords($application->pname) }}</td>
                        <td>{{ $application->status_summary }}</td>
                        <td> @if($application->current_step > 5)
                            <a href="{{ route('service-applications.documents.index', $application->id) }}"
                            title="Documents"><span class="nk-menu-icon text-secondary">View
                               Documents</span></a>
                            @endif
                            </td>
                        <td>{{ $application->created_at }}</td>
                        <td>

                            @if($app_form_fee)
                            @if ($application->current_step == 2 || !$application->application_form_payment_status)
                                <a href="{{ route('application_form_payment', $application->id) }}"
                                    title="Application form payment"><span class="nk-menu-icon text-danger">Pay for
                                        Application form</span>
                                </a>
                            @endif
                            @else
                            <a href="{{ route('service-applications.documents.index', $application->id) }}"
                                 title="Documents"><span class="nk-menu-icon text-secondary">Add
                                    Documents</span></a>
                            @endif
                            @if($doc_upload)
                            @if($app_fee)
                            @if ($application->current_step == 4)
                                <a href="{{ route('service-applications.documents.index', $application->id) }}"
                                     title="Documents"><span class="nk-menu-icon text-secondary">Add
                                        Documents</span></a>
                            @endif
                            @endif
                            @else
                            <p class="color:red;">No document setup name found for this service </p>
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
                           @if($pro_fee)
                           @if ($application->current_step == 6 && !$is_processing_fee_paid)
                                <a href="{{ route('processing_fee_payment', $application->id) }}"
                                    title="Processing fee payment"><span class="nk-menu-icon text-danger">Pay for
                                        Processing Fee</span>
                                </a>
                            @endif
                            @endif

                            @if($ins_fee)
                            @if ($application->current_step == 7)
                                <a href="{{ route('inspection_fee_payment', $application->id) }}"
                                    title="Inspection fee payment"><span class="nk-menu-icon text-danger">Pay for
                                        Inspection Fee</span>
                                </a>
                            @endif
                            @endif

                            @if ($application->current_step == 11)
                                <a href="{{ route('equipment_fee_payment', $application->id) }}"
                                    title="Equipment fee payment"><span class="nk-menu-icon text-danger">Pay for
                                        Equipment and Monitoring Fees</span>
                                </a>
                            @endif

                            @if ($application->current_step == 15)
                                <a href="{{ route('download_permit', $application->id) }}"  title="Download Permit" target="_blank"><span
                                        class="nk-menu-icon text-secondary">Download Permit</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div><!-- .card-preview -->
