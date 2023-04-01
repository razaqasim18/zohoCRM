@extends('layouts.admin')

@section('title')
    Admin Business || Dashboard
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Businesses Admin List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-striped table-hover" id="table-1" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i = 1; @endphp
                                            @foreach ($customers as $row)
                                                <tr>
                                                    <td>
                                                        {{ $i++ }}
                                                    </td>
                                                    <td>
                                                        {{ $row->business }}
                                                    </td>
                                                    <td>
                                                        {{ $row->name }}
                                                    </td>
                                                    <td>
                                                        {{ $row->email }}
                                                    </td>
                                                    <td>
                                                        @if ($row->is_blocked)
                                                            <div class="badge badge-danger badge-shadow" id="statusChange"
                                                                data-userid="{{ $row->userid }}" data-status="0">Block
                                                            </div>
                                                        @else
                                                            <div class="badge badge-success badge-shadow" id="statusChange"
                                                                data-userid="{{ $row->userid }}" data-status="1">Active
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn  btn-primary">
                                                            Detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/page/datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#table-1").on("click", "div#statusChange", function() {
                var id = $(this).data("userid");
                var status = $(this).data("status");
                var custommessage = (status) ? 'You want to block this user!' :
                    'You want to un-block this user!';
                swal({
                        title: 'Are you sure?',
                        text: custommessage,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Yes!",
                        closeOnConfirm: false
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var token = $("meta[name='csrf-token']").attr("content");
                            var url = '{{ url('/admin/business/admin/change/status') }}';
                            $.ajax({
                                url: url,
                                type: 'POST',
                                dataType: 'json',

                                data: {
                                    "id": id,
                                    "status": status,
                                    "_token": token,
                                },
                                beforeSend: function() {
                                    $(".loader").show();
                                },
                                complete: function() {
                                    $(".loader").hide();
                                },
                                success: function(response) {
                                    var result = jQuery.parseJSON(JSON.stringify(response));
                                    var typeOfResponse = result['type'];
                                    var res = result['message'];
                                    if (typeOfResponse == 0) {
                                        swal('Error', res, 'error');
                                    } else if (typeOfResponse == 1) {
                                        swal({
                                                title: 'Success',
                                                text: res,
                                                icon: 'success',
                                                type: 'success',
                                                showCancelButton: false, // There won't be any cancel button
                                                showConfirmButton: true // There won't be any confirm button
                                            })
                                            .then((ok) => {
                                                if (ok) {
                                                    location.reload();
                                                }
                                            });
                                    }
                                }
                            });
                        }
                    });
            });
        });
    </script>
@endsection
