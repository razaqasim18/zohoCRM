@extends('layouts.user')

@section('title')
    Sale Person || Dashboard
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <style>
        .table-sm td,
        .table-sm th {
            padding: 0.3rem 0.2rem;
        }
    </style>
@endsection
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('sale.person.update', $saleperson->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Sale Person</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('sale.person.list') }}" class="btn btn-primary">
                                        Person List
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label for="name">Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $saleperson->name }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="name">Email</label>
                                        <span class="text-danger">*</span>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ $saleperson->email }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/page/advance-table.js') }}"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
