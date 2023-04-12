<html lang="en">
<head>
    <title>MailerLite Subscribers</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container">
    <h2>MailerLite Subscribers</h2>
    <table class="table table-bordered" id="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>subscribe date</th>
            <th>subscribe time</th>
            <th>actions</th>
        </tr>
        </thead>
    </table>
</div>
<script>
    $(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('mailerlite.subscribers.table') }}',
            columns: [
                {data: 'email', name: 'email', 'searchable': true},
                {data: 'name', name: 'name', 'searchable': false},
                {data: 'country', name: 'country', 'searchable': false},
                {data: 'subscribe_date', name: 'subscribe_date', 'searchable': false},
                {data: 'subscribe_time', name: 'subscribe_time', 'searchable': false},
                {data:'actions', name: 'actions', 'searchable': false},
            ]
        });
    });
</script>
</body>
</html>
