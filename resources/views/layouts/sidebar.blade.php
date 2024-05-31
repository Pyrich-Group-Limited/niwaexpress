<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">NIWA Service Portal</li>
                <li class="active">
                    <a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>

       {{--  <li class="submenu">
            <a href="#"><i class="fa fa-book"></i> <span> My Documents </span> <span class="menu-arrow"></span></a>
            <ul style="display: none;">
                <li><a href="{{ route('documents.index') }}">Documents List</a></li>
                <li><a href="{{ route('documents.create') }}">Add Documents</a></li>
            </ul>
        </li> --}}
        <?php
       // $reg_setup = \App\Models\RegistrationFee::where('branch_id', auth()->user()->branch->id)->first();
       // $userPayment = \App\Models\Payment::where('payment_type',0)->where('employer_id', auth()->user()->id)->latest()->first();
       // if(!empty($userPayment) && $userPayment->payment_status == 1){
        ?>
        {{-- <li>
            <a href="{{ route('payment.index') }}"><i class="fa fa-bank"></i> <span>Apply For A Service</span></a>
        </li> --}}
        {{-- <li class="{{ Request::is('apply_for_a_service*') ? 'active' : '' }}">
            <a href="{{ route('apply_for_a_service') }}"><i class="fa fa-user-md"></i> <span>Apply For A Service</span></a>
        </li>
        <li class="{{ Request::is('service-applications*') ? 'active' : '' }}">
            <a href="{{ route('service-applications.index') }}"><i class="fa fa-user-md"></i> <span>Application Management</span></a>
        </li>
        <li>
            <a href="{{ route('download.niwa.act') }}"><i class="fa fa-download"></i> <span>Download NIWA Act</span></a>
        </li> --}}
        <?php
        //}


        //if(empty($reg_setup)){
        ?>
        {{-- <li>
            <a href="{{ route('payment.index') }}"><i class="fa fa-bank"></i> <span>Apply For A Service</span></a>
        </li> --}}
        @if (auth()->user()->user_type != 'e-promota')
        <li class="{{ Request::is('apply_for_a_service*') ? 'active' : '' }}">
            <a href="{{ route('apply_for_a_service') }}"><i class="fa fa-user-md"></i> <span>Apply For A Service</span></a>
        </li>
        @endif

        @if (auth()->user()->user_type != 'e-promota')
        <li class="{{ Request::is('service-applications*') ? 'active' : '' }}">
            <a href="{{ route('service-applications.index') }}"><i class="fa fa-user-md"></i> <span>Transaction History</span></a>
        </li>
        @endif

        <li>
            <a href="{{ route('download.niwa.act') }}"><i class="fa fa-download"></i> <span>Download NIWA Act</span></a>
        </li>
        @if (auth()->check() && auth()->user()->user_type == 'e-promota' && auth()->user()->status > 1)
        <li>
            <a href="{{ route('downloadepromotacert') }}"  target="_blank"><i class="fa fa-download"></i> <span>e-Promota CERT.</span></a>
        </li>
        @endif

        @if (auth()->user()->user_type != 'e-promota')
        <li>
            <a href="{{ route('switch.area.office') }}"><i class="fa fa-globe"></i> <span>Switch Area Office</span></a>
        </li>
        @endif
        @if (auth()->user()->user_type == 'e-promota')

        <li>
            <a  href="{{ route('the.create') }}"><i class="fa fa-globe"></i>   <span> Register Applicant </span></a>
        </li>
        @endif


        @if (auth()->user()->user_type != 'e-promota')
        <li>
            <a href="{{ route('my.payments') }}"><i class="fa fa-globe"></i> <span>My Payments</span></a>
        </li>
        @endif

        <?php
       // }

        if(auth()->user()->inspection_status == 1){
        ?>
        <li>
            <a href="{{ route('payment.inspection') }}">
                <i class="fa fa-user-md"></i>
                <span>Inspection Status</span>
                <span class="badge badge-pill bg-danger" title="Make payment for the inspection of the service you registered">1</span> <!-- Add this line for the notification badge -->
            </a>
        </li>
        <?php } ?>
        {{-- <li>
            <a href="{{ route('payment.steps') }}"><i class="fa fa-user-circle"></i> <span>Service Registration Status</span></a>
        </li> --}}

            </ul>
        </div>
    </div>
</div>
