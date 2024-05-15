<!-- resources/views/emails/employer-document.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Employer Documents</title>
</head>
<body>
    <p>Dear Employer,</p>

    <p>This is to notify you of a new client document from NIWA portal.</p>

    <p>Details of a new client document:</p>
    <ul>
        <li>Employer Name: {{ $user->contact_firstname.' '.$user->contact_surname }}</li>
        <li>Branch Name: {{ $user->branch->branch_name }}</li>
        <li>Document Name: {{ $employerDocuments->title }}</li>
        <li><a href="{{ {{ asset('storage/'.$employerDocuments->file_path) }} }}" target="_blank" class="text-dark">Open PDF Document</a></li>
        <!-- Add more details as needed -->
    </ul>

    <p>Visit the url below to follow up on the client documents and approve when necessary</p>

    <p><a href="https://ebs.eniwa.com.ng/documents/index">View Documents Status</a></p>

    <p>Best regards,</p>
    <p>NIWA EROM Portal</p>
</body>
</html>
