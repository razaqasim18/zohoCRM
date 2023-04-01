@extends('layouts.user')

@section('title')
    Tax || Dashboard
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
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
                    <form action="{{ route('tax.insert') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Tax</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('tax.list') }}" class="btn btn-primary">
                                        Tax List
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
                                    <div class="form-group col-md-6">
                                        <label for="name">Tax Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name') }}" required>
                                        @error('name')
                                            <br /><span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="rate">Tax Rate</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="rate"
                                                value="{{ old('rate') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        @error('rate')
                                            <br /><span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <div class="form-check">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="iscompound"
                                                    id="iscompound" value="1">
                                                <label class="custom-control-label" for="iscompound">This tax is a compound
                                                    tax.</label>
                                                @error('iscompound')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
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
    <script>
        $(document).ready(function() {


        });
    </script>
@endsection
