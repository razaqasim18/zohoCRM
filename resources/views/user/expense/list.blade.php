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
            <div class="card col-md-12">


                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="other-detail-tab" data-toggle="tab" href="#recordExpense" role="tab" aria-controls="other-detal" aria-selected="true">Record Expense</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Bulk Add Expense</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="recordExpense" role="tabpanel" aria-labelledby="other-detail-tab">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="date">Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exaccount">Expense Account</label>
                                    <span class="text-danger">*</span>
                                    <select name="" class="form-control" id="">
                                        <option value="" selected disabled>Select Account</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="date">Amount</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exaccount">Paid Through</label>
                                    <span class="text-danger">*</span>
                                    <select name="" class="form-control" id="">
                                        <option value="" selected disabled>Select Account</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="date">Vendor</label>
                                    <select name="" class="form-control" id="">
                                        <option value="" selected disabled>Select Vendor</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exaccount">Reference#</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="notes">Notes</label>
                                    <textarea name="" id="notes" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="cname">Customer Name</label>
                                    <select name="" class="form-control" id="cname">
                                        <option value="" selected disabled>Select Customer</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customer_id">Upload</label>
                                    <input type="file" class="form-control" name="image[]" id="image" multiple="">
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <div class="row">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date*</th>
                                            <th scope="col">EXPENSE ACCOUNT</th>
                                            <th scope="col">AMOUNT</th>
                                            <th scope="col">PAID THROUGH</th>
                                            <th scope="col">VENDOR</th>
                                            <th scope="col">CUSTOMER NAME</th>
                                            <th scope="col">PROJECTS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="div_contact_person">
                                            <td>
                                                <input type="date" name="" class="form-control" id="">
                                            </td>
                                            <td>
                                                <select name="" class="form-control" id="">
                                                    <option value="" selected disabled>Select Amount</option>
                                                    <option value="">Advertising and Marketing</option>
                                                    <option value="">Automobile Expenses</option>
                                                    <option value="">Bad Debt</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Amount" name="contact_last_name[]" id="contact_last_name" value="">
                                            </td>
                                            <td>
                                                <select name="" class="form-control" id="">
                                                    <option value="" selected disabled>Paid Through</option>
                                                    <option value="">Advance Tax</option>
                                                    <option value="">Employee Advance</option>
                                                    <option value="">Prepaid Expenses</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Vendor" name="contact_mobile[]" id="contact_mobile" value="">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Customer Name" name="contact_phone_no[]" id="contact_phone_no" value="">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Project" name="contact_phone_no[]" id="contact_phone_no" value="">
                                            </td>

                                            <td style="text-align: center;vertical-align: middle;">
                                                <button type="button" class="btn btn-primary btn-sm m1" id="addnewcontactperson">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{ asset('js/page/advance-table.js') }}"></script>

@endsection