<div class="card card-bordered card-preview mt-4">
    <div class="card-header">
        @if ($documents->count() == 6)
            <form action="{{ route('documents.resubmit', $service_application->id) }}" method="post">
                @csrf
                <button class="btn">Resubmit for verification</button>
            </form>
        @endif
    </div>
    <div class="card-inner">
        <table class="nowrap table">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Document Name</th>
                    <th>Document (PDF)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($documents as $document)
                    <tr>
                        <td>
                            @php
                                echo $no++;
                            @endphp
                        </td>
                        <td>{{ $document->name }}</td>
                        <td>
                            <a href="{{ 'storage/' . $document->path }}" target="_blank">
                                View File
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div><!-- .card-preview -->
