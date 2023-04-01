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
                            <h4>Customer List</h4>
                            <div class="card-header-action">
                                <a href="{{ route('customer.add') }}" class="btn btn-primary">
                                    Add Customer
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-striped table-hover" id="table-1" style="width:100%;">
                                    <thead>
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th>Name</th>
                                            <th>Company Name</th>
                                            <th>Email</th>
                                            <th>Work Phone</th>
                                            <th>Receiveable</th>
                                            <th>Unused Credits</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer as $row)
                                            <tr>
                                                <td>{{ $row->display_name }}</td>
                                                <td>{{ $row->business }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->phone }}</td>
                                                <td>{{ 0.0 }}</td>
                                                <td>{{ 0.0 }}</td>
                                                <td>
                                                    <a href="{{ route('customer.edit', $row->customersid) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" id="deleteCustomer"
                                                        data-id="{{ $row->customersid }}">
                                                        <i class="fas fa-trash"></i>
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
                        text: "You want to delete this customer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Yes!",
                        closeOnConfirm: false
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var token = $("meta[name='csrf-token']").attr("content");
                            var url = '{{ url('/customer/delete') }}' + '/' + id;
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
