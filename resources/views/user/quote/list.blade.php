@extends('layouts.user')

@section('title')
    Quote || Dashboard
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
                            <h4>Quote List</h4>
                            <div class="card-header-action">
                                <a href="{{ route('quote.add') }}" class="btn btn-primary">
                                    Add Quote
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <table class="table table-striped table-hover" id="table-1" style="width:100%;">
                                    <thead>
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th>Cutomer Name</th>
                                            <th>Quote Number</th>
                                            <th>Total Amount</th>
                                            <th>Quote Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quote as $row)
                                            <tr>
                                                <td>{{ $row->display_name }}</td>
                                                <td>{{ $row->quote_number }}</td>
                                                <td>{{ $row->total_amount }}</td>
                                                <td>{{ $row->quote_date }}</td>
                                                <td>
                                                    <a href="{{ route('quote.edit', $row->quotesid) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger" id="deleteQuote"
                                                        data-id="{{ $row->quotesid }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <a href="{{ route('quote.clone', $row->quotesid) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="far fa-copy"></i>
                                                    </a>
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
            $("#table-1").on("click", "button#deleteQuote", function() {
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
                            var url = '{{ url('/quote/delete') }}' + '/' + id;
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
