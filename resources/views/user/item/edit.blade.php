@extends('layouts.user')

@section('title')
    Item || Dashboard
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
                    <form action="{{ route('item.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Item</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('item.list') }}" class="btn btn-primary">
                                        Item List
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
                                        <label>Type</label>
                                        <div class="form-row mt-2">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="is_service_service" name="is_service"
                                                        class="custom-control-input" value='1'
                                                        {{ $item->is_service == '1' ? 'checked' : '' }} checked>
                                                    <label class="custom-control-label"
                                                        for="is_service_service">Service</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="is_service_good" name="is_service"
                                                        class="custom-control-input" value='0'
                                                        {{ $item->is_service == '0' ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_service_good">Goods</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name">Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $item->name }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="unit_id">Unit</label>
                                        <select id="unit_id" name="unit_id" class="form-control select2">
                                            <option value="">Choose...</option>
                                            @foreach ($unit as $row)
                                                <option value="{{ $row->id }}"
                                                    @if ($item->unit_id == $row->id) selected @endif>{{ $row->unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="selling_price">Selling Price</label>
                                        <span class="text-danger">*</span>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    {{ Auth::guard('web')->user()->business->country->currency }}
                                                </div>
                                            </div>
                                            <input type="number" class="form-control" id="selling_price"
                                                name="selling_price" value="{{ $item->selling_price }}" required>
                                        </div>

                                        @error('selling_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="account_type_id">Account</label>
                                        <span class="text-danger">*</span>
                                        <select id="account_type_id" name="account_type_id" class="form-control select2"
                                            required>
                                            <option value="">Choose...</option>
                                            @foreach ($account as $row)
                                                <option value="{{ $row->id }}"
                                                    @if ($item->account_type_id == $row->id) selected @endif>
                                                    {{ $row->account_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('account_type_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tax_id">Tax</label>
                                        <span class="text-danger">*</span>
                                        <select id="tax_id" name="tax_id" class="form-control select2" required>
                                            <option value="">Choose...</option>
                                            @foreach ($tax as $row)
                                                <option value="{{ $row->id }}"
                                                    @if ($item->tax_id == $row->id) selected @endif>
                                                    {{ $row->name . ' [' . $row->rate . ']' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tax_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="tax_id">Description</label>
                                        <textarea class="form-control" id="description" name="description">{{ $item->description }}</textarea>
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
            $("input#quote_date").change(function() {
                $("input#expiry_date").attr("min", $(this).val());
            });
        });
    </script>
@endsection
