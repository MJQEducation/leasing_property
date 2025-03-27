@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Data for Abbreviation: {{ request()->route('abbreviation') }}</h3>
        <table id="exitClearanceList" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name (EN)</th>
                    <th>Abbreviation</th>
                    <th>Name (KH)</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table = $('#exitClearanceList').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('abbreviation.show', ['abbreviation' => request()->route('abbreviation')]) }}",
                "type": "GET", 
                "data": function(d) {
                 
                    d._token = $('meta[name="csrf-token"]').attr('content'); 
                }
            },
            "columns": [
                { "data": "code" },
                { "data": "name_en" },
                { "data": "abbreviation" },
                { "data": "name_kh" }
            ],
            "order": [[1, 'asc']],
            "searchDelay": 500,
            "stateSave": true,
            "responsive": true
        });
    });
</script>
@endsection