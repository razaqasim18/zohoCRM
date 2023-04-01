@extends('layouts.user')

@section('title')
    Tax || Dashboard
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tax List</h4>
                            <div class="card-header-action">
                                <a href="{{ route('tax.add') }}">
                                    <button class="btn btn-primary">Add Tax</button>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Tax Name</th>
                                            <th>Tax Rate</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tax as $row)
                                            <tr>
                                                <td>
                                                    {{ $row->name }}
                                                </td>
                                                <td>
                                                    {{ $row->rate }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('tax.edit', ['id' => $row->id]) }}">
                                                        <button id="editTax" data-id="{{ $row->id }}"
                                                            class="btn btn-sm btn-sm btn-primary">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <button id="deleteTax" data-id="{{ $row->id }}"
                                                        class="btn btn-sm btn-sm btn-danger"><i
                                                            class="fas fa-trash"></i></button>
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
    <script src="{{ asset('js/page/advance-table.js') }}"></script>
    <script src="{{ asset('js/page/datatables.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#save-stage").on("click", "button#deleteTax", function() {
                var id = $(this).data("id");
                swal({
                        title: 'Are you sure?',
                        text: 'Are you sure you want the procced!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Yes!",
                        closeOnConfirm: false
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var token = $("meta[name='csrf-token']").attr("content");
                            var url = '{{ url('tax/delete') }}' + '/' + id;
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
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    swal('Error', 'Tax is in use', 'error');
                                }
                            });
                        }
                    });
            });
        });
    </script>
@endsection
