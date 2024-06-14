<!-- resources/views/emails/employer-document.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Client Documents</title>
</head>
<body>
    <p>Dear {{$areaManager->first_name}},</p>

    <p>This is to notify you of a new client document from NIWA express portal.</p>

    <p>Details of a new client document:</p>
    <ul>
        <li>Client Name: {{ $user->contact_firstname.' '.$user->contact_surname }}</li>
        <li>Branch Name: {{ $user->branch->branch_name }}</li>
        @foreach($employerDocuments as $document)
            <li>Document Name: {{ $document->name }}</li>
            <li><a href="{{ url('storage/'.$document->path) }}" target="_blank" class="text-dark">Open PDF Document</a></li>
            <!-- Add more details as needed -->
        @endforeach
    </ul>

    <p>Visit the url below to follow up on the client documents and approve when necessary</p>

    <p><a href="http://optima.eniwa.com.ng/serviceApplications">View Documents Status</a></p>

    <p>Best regards,</p>
    <p>NIWA Express Portal</p>
</body>
</html>
