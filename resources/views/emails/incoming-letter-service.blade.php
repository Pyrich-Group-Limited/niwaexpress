<!-- resources/views/emails/incoming-letter-service.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>New Incoming Letter & Service Application</title>
</head>
<body>
    <p>Dear {{$areaManager->first_name}},</p>

    @if($incoming == 1)
    <p>This is to notify you of a new incoming letter & service application from NIWA express portal.</p>

    <p>Details of a new incoming letter:</p>
    <ul>
        <li>Client Name: {{ $documentInput['full_name'] }}</li>
        <li>Email Address: {{ $documentInput['email'] }}</li>
        <li>Phone Number: {{ $documentInput['phone'] }}</li>
        <li>Branch Name: {{ $user->branch->branch_name }}</li>
        <li>Service Name: {{ $serviceApplication->service->name }}</li>
        <li>Description: {{ $documentInput['description'] }}</li>
        <li><a href="{{ url($documentInput['document_url']) }}" target="_blank" class="text-dark">Open PDF Document</a></li>
    </ul>
    @endif

    @if($incoming == 0)
    <p>This is to notify you of a new service application from NIWA express portal.</p>
    @endif

    <p>Details of a new service application:</p>
    <ul>
        <li>Client Name: {{ $user->contact_firstname.' '.$user->contact_surname }}</li>
        <li>Branch Name: {{ $user->branch->branch_name }}</li>
        <li>Service Name: {{ $serviceApplication->service->name }}</li>
        <li>Processing Service Type: {{ $serviceApplication->processingType->name }}</li>
        @if($serviceApplication->branch_id ==1)
        <li>Axis Name: {{ $serviceApplication->axis->name }}</li>
        @endif
    </ul>

    <p>Visit the url below to follow up on the client documents and approve when necessary</p>

    <p><a href="http://optima.eniwa.com.ng/serviceApplications">View Documents Status</a></p>

    <p>Best regards,</p>
    <p>NIWA Express Portal</p>
</body>
</html>
