@extends('layouts.user')

@section('title')
Customer || Dashboard
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
                <form action="{{ route('customer.insert') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Invoice Primary Detail</h4>
                            <div class="card-header-action">
                                <a href="{{ route('invoice.list') }}" class="btn btn-primary">
                                    Invoice List
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
                                    <x-customer-select />
                                </div>
                                <div class="form-group col-md-6">
                                    <x-saleperson-select />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="invoice">Invoice</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="invoice" id="invoice" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="onumber">Order Number</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="onumber" id="onumber" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="date">Invoice Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" class="form-control" name="date" id="date" required>

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="terms">Terms</label>
                                    <select name="terms" id="mySelect" class="form-control">
                                        <option value="" disabled selected>Due on Recipt</option>
                                        <option value="">Net 15</option>
                                        <option value="">Net 30</option>
                                        <option value="">Net 45</option>
                                        <option value="">Net 45</option>
                                        <option value="">Due end of the month</option>
                                        <option value="">Due end of the next month</option>
                                        <option value="option1"><a href="#" data-toggle="modal" data-target="#modal">Configure Terms</a></option>
                                    </select>

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ddate">Due Date</label>
                                    <input type="date" class="form-control" name="ddate" id="ddate">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="reference_number">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject" }}">
                                    @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>





                        </div>

                    </div>



                </form>

            </div>
        </div>
    </div>
</section>
<div class="card">
    <div class="card-header">
        <h4>Item Details</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col" width="20%">Item Detail</th>
                        <th scope="col" width="20%">Quantity</th>
                        <th scope="col" width="20%">Rate</th>
                        <th scope="col" width="20%">Discount</th>
                        <th scope="col" width="20%">Amount</th>
                        <th scope="col" width="20%">Action</th>
                    </tr>
                </thead>
                <tbody id="div_body">
                    <tr>
                        <td>
                            <select class="form-control select2 item_id">
                                <option></option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="quantity[]" id="quantity" min="1" value="1">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="rate[]" id="rate" min="1" value="0.0">
                        </td>
                        <td>
                            <select id="tax" name="tax[]" class="form-control tax select2" name="tax">
                                <option></option>

                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="amount[]" id="amount" value="0.0" readonly>
                        </td>
                        <td style="text-align: center;vertical-align: middle;">

                            <button type="button" class="btn btn-primary btn-sm m1 p-2" id="addnewitem">
                                <i class="fa fa-plus"></i>
                            </button>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4>Customer Notes</h4>
    </div>
    <div class="card-body">
        <div class="form-row">

            <div class="form-group col-md-4">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="customerid">Customer Note</label>
                        <textarea class="form-control" name="note" id="note" rows="5" style="height: 125px !important;"> {{ old('note') }}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="customer_id">Upload</label>
                        <input type="file" class="form-control" name="image[]" id="image" multiple>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group col-md-12">
                    <label for="customerid">Terms & Conditions</label>
                    <textarea class="form-control" name="terms_condition" id="terms_condition" rows="5" style="height: 125px !important;">{{ old('terms_condition') }}</textarea>
                </div>
            </div>



            <div class="col-md-4">
                <div class="form-group m-0">
                    <div class="col-md-12 form-group m-0 p-0">
                        <label>Sub Total Amount</label>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <h5 class="text-left">Sub Total(PKR)
                            </h5>
                        </div>
                        <div class="form-group col-md-4">
                            <h5 class="text-right" id="label_sub_total_amount">0.0</h5>
                        </div>
                    </div>
                    <div class="col-md-12 form-group m-0 p-0">
                        <label>Total Amount</label>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <h5 class="text-left">Total(PKR)
                            </h5>
                        </div>
                        <div class="form-group col-md-4">
                            <h5 class="text-right" id="label_sub_total_amount">0.0</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card-footer text-right">
        <button class="btn btn-primary mr-1" type="submit">Submit</button>
        <button class="btn btn-secondary" type="reset">Reset</button>
    </div>
</div>
@endsection
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Configure Payment Terms</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="termtext">Term Name</label>
                            <input type="text" name="" id="termtext" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ndays">Number of Days</label>
                            <input type="number" name="" id="ndays" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@section('script')
<script src="{{ asset('js/page/advance-table.js') }}"></script>

<script>
    // popup on select option
    // Get the select input element
    var select = document.getElementById("mySelect");

    // Add event listener for changes to the select input
    select.addEventListener("change", function() {
        // Get the selected option
        var selectedOption = select.value;

        // If the selected option is "option1", open the modal
        if (selectedOption === "option1") {
            $('#myModal').modal('show');
        }
    });
</script>

@endsection