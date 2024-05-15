@extends('layouts.app')

@section('title', 'Employee')


@push('styles')
@endpush


@section('content')

    {{-- <div class="components-preview wide-md mx-auto"> --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Edit Sub-Service</h3>
                <div class="nk-block-des text-soft">
                    <p>Edit Sub-Service details</p>
                </div>
            </div><!-- .nk-block-head-content -->
            <!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <form action="{{ route('sub-services.update', $subservices->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('sub_services.form')
                </form>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->
    {{-- </div><!-- .components-preview --> --}}

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            function isInt(value) {
  return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
}

            let lga = '{{ $employee->local_govt_area ?? '' }}';
            lga = isInt(lga) ? lga : 1;
            //FETCH LGAs FROM STATE ID
            const lUrl = "{{ route('employer.lgas') }}?state=";
            $('#state_of_origin').change(function() {
                $.ajax({
                    url: lUrl + $(this).val(),
                    type: "GET",
                    data: null,
                    dataType: 'json',
                }).done(function(response) {
                    $('#local_govt_area').empty();
                    var lgas = '';
                    $.each(response.data, function(a, b) {
                        lgas += '<option value="' + b.id + '" '+(lga==b.id? 'selected':'')+'>' + b.name + '</option>';
                    });
                    $('#local_govt_area').html(lgas);
                });
            });

            $('#state_of_origin').trigger('change');
        });
    </script>
@endpush
