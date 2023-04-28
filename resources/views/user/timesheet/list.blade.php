@extends('layouts.user')

@section('title')
Customer || Dashboard
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Timesheet</h4>
                        <div class="card-header-action">
                            <a href="{route('timesheet.add')}}" class="btn btn-primary">
                                <i data-feather="clock" class="smClock"></i> Start
                            </a>
                            <a href="" class="btn btn-primary">
                                Long Time
                            </a>
                            <!-- <a href="#" class="dropdown-item">Log Time</a>
                            <a href="#" class="dropdown-item">Weekly Log</a> -->
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover" id="table-1" style="width:100%;">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th style="width: fit-content;">View By</th>
                                        <th style="width: 20%">
                                            <select class="form-control select2 item_id">
                                                <option value="Status" selected disabled>Status</option>
                                                <option>All</option>
                                                <option>Non Billable</option>
                                                <option>Billable</option>
                                                <option>Unbilled</option>
                                                <option>Invoiced</option>
                                            </select>
                                        </th>
                                        <th style=" width: 20%">
                                            <select class="form-control select2 item_id">
                                                <option value="Period" selected disabled>Period</option>
                                                <option>All</option>
                                                <option>Today</option>
                                                <option>This Week</option>
                                                <option>This Month</option>
                                                <option>This Quarter</option>
                                            </select>
                                        </th>
                                        <th style=" width: 20%">
                                            <select class="form-control select2 item_id">
                                                <option value="Select Customer" selected disabled>Select Customer</option>
                                                <option></option>
                                            </select>
                                        </th>
                                        <th style=" width: 20%">
                                            <select class="form-control select2 item_id">
                                                <option value="Select a Project" selected disabled>Select a Project</option>
                                                <option></option>
                                            </select>
                                        </th>
                                        <th style=" width: 20%">
                                            <select class="form-control select2 item_id">
                                                <option value="Select a User" selected disabled>Select a User</option>
                                                <option></option>
                                            </select>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td> <input type="checkbox" id="date"> <label for="date">Date</label> </td>
                                        <td> Project</td>
                                        <td> Customer </td>
                                        <td> Task </td>
                                        <td></td>
                                        <td> User </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ asset('bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/page/datatables.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#table-1").on("click", "button#deleteCustomer", function() {
            var id = $(this).data("id");
            swal({
                    title: 'Are you sure?',
                    text: "You want to delete this Invoice",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "Yes!",
                    closeOnConfirm: false
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var token = $("meta[name='csrf-token']").attr("content");
                        var url = '{{ url(' / customer / delete ') }}' + '/' + id;
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                "id": id,
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
                                var typeOfResponse = response.type;
                                var res = response.msg;
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