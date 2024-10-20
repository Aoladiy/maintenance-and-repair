<?php use App\Models\ServiceCharacteristics; ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduled Maintenances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <p class="mt-4">
        <a href="{{route('index')}}" class="btn btn-secondary">Все детали</a>
    </p>
</div>
<div class="container">
    <table id="scheduled-maintenances-table" class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>Id</th>
            <th>Serviceable Id</th>
            <th>Serviceable name</th>
            <th>Datetime of next service</th>
        </tr>
        </thead>
        <tbody>
        <?php /** @var ServiceCharacteristics $s */ ?>
        @foreach($serviceCharacteristics as $s)
            <tr>
                <td>{{$s->id}}</td>
                <td>{{$s->serviceable->id}}</td>
                <td>
                    <a href="{{$s->serviceable->url}}">
                        {{$s->serviceable->name}}
                    </a>
                </td>
                <td>{{$s->datetime_of_next_service}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#scheduled-maintenances-table').DataTable({
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });
</script>
</body>
</html>
