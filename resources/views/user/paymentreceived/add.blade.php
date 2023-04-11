@extends('layouts.user')

@section('title')
    Payment Received || Dashboard
@endsection
@section('style')
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('quote.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>Add Payment Received</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('quote.list') }}" class="btn btn-primary">
                                        Payment Received List
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
                                        <label for="">Amount Received</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="amountReceived" id="amountReceived"
                                            value="" required>
                                        @error('')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="">Bank Charges (if any)</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="bankCharges" id="bankCharges"
                                            value="" required>
                                        @error('')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                     <div class="form-group col-md-6">
                                       <label for="">Payment Date</label>
                                        <span class="text-danger">*</span>
                                        <input type="date" class="form-control" name="paymentDate" id="paymentDate"
                                            value="{{ old('') }}" required>
                                        @error('')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror 
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="">Payment#</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="payment" id="payment"
                                            value="{{ old('') }}" required>
                                        @error('')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Payment Mode</label>
                                        <select class="form-control" name="paymentMode" id ="paymentMode">
                                            <option>Choose the payment term or type to add</option>
                                            <option value=""></option>
                                        </select>
                                        @error('paymentMode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="">Deposit To</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control" name="depositTo" id ="depositTo">
                                            <option></option>
                                        </select>
                                        @error('depositTo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Reference#</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="reference" id="reference"
                                            value="{{ old('reference') }}" required>
                                        @error('reference')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="">Tax Deducted</label>
                                        <span class="text-danger"  style="margin-right: 3rem">*</span>
                                        <input class="form-check-input ms-3 ps-4" type="radio" name="tax" id="noTax"> 
                                        <label class="form-check-label" for="noTax" style="margin-right: 3rem">
                                           No Tax deducted
                                        </label>
                                        <input class="form-check-input" type="radio" name="tax" id="yesTax">
                                         <label class="form-check-label" for="tyesTax">
                                           Yes, TDS
                                        </label>
                                        @error('depositTo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                   
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Item Detail</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="20%">Item Detail</th>
                                                <th scope="col" width="20%">Account</th>
                                                <th scope="col" width="15%">Quantity</th>
                                                <th scope="col" width="15%">Rate</th>
                                                <th scope="col" width="20%">Tax</th>
                                                <th scope="col" width="15%">Amount</th>
                                                <th scope="col" width="10%">Action</th>
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
                                                    <select class="form-control select2 item_id">
                                                        <option></option>
                                                     
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="quantity[]"
                                                        id="quantity" min="1" value="1">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="rate[]" id="rate"
                                                        min="1" value="0.0">
                                                </td>
                                                <td>
                                                    <select id="tax" name="tax[]" class="form-control tax select2"
                                                        name="tax">
                                                        <option></option>
                                                       
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="amount[]"
                                                        id="amount" value="0.0" readonly>
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    <button type="button" onclick= "newItemCreate()" class="btn btn-primary btn-sm m1"
                                                        id="addnewitem">
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
                                <h4>Quote Detail</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="form-group col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="customer_id">Customer Note</label>
                                                <textarea class="form-control" name="note" id="note" rows="5" style="height: 125px !important;"> {{ old('note') }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="customer_id">Terms & Conditions</label>
                                                <textarea class="form-control" name="terms_condition" id="terms_condition" rows="5"
                                                    style="height: 125px !important;">{{ old('terms_condition') }}</textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="customer_id">Upload</label>
                                                <input type="file" class="form-control" name="image[]" id="image"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="sub_total">Sub Total</label>
                                                <input type="number" id="sub_total" name="sub_total"
                                                    class="form-control numbers addinput"
                                                    value="{{ old('sub_total') ? old('sub_total') : '0.0' }}" readonly>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="tax_id">Tax</label>
                                                <select class="form-control select2" id="tax_id" name="tax_id">
                                                    <option value="">Choose...</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="discount">Discount</label>
                                                <div class="input-group">
                                                    <input type="number" id="ddiscount" name="ddiscount"
                                                        class="form-control numbers ddiscount"
                                                        value="{{ old('ddiscount') ? old('ddiscount') : '0.0' }}"
                                                        min="0">
                                                    <input type="hidden" id="discount" name="discount"
                                                        class="form-control"
                                                        value="{{ old('discount') ? old('discount') : '0.0' }}">
                                                    <div class="input-group-append">
                                                        <select class="form-control" id="discountopt" name="discountopt">
                                                            <option value="1">
                                                                {{ Auth::guard('web')->user()->business->country->currency }}
                                                            </option>
                                                            <option value="2"> % </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="shipping_charges">Shipping Charges</label>
                                                <div class="input-group">
                                                    <input type="number" id="shipping_charges" name="shipping_charges"
                                                        class="form-control numbers addinput" min="0"
                                                        value="{{ old('shipping_charges') ? old('shipping_charges') : '0.0' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mt-2">
                                                <label for="adjustment_name">Adjustment Name</label>
                                                <input type="text" id="adjustment_name" name="adjustment_name"
                                                    class="form-control"
                                                    value="{{ old('adjustment_name') ? old('adjustment_name') : 'Adjustment' }}">
                                            </div>
                                            <div class="form-group col-md-6 mt-2">
                                                <label for="adjustment_name_value">Adjustment Value</label>
                                                <input type="number" id="adjustment_name_value"
                                                name="adjustment_name_value" class="form-control numbers addinput"
                                                min="0"
                                                value="{{ old('adjustment_name_value') ? old('adjustment_name_value') : '0.0' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label>Sub Total Amount</label>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <h5 class="text-left">Sub Total (
                                                    {{ Auth::guard('web')->user()->business->country->currency }} )
                                                </h5>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <h5 class="text-right" id="label_sub_total_amount">0.0</h5>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Tax Amount</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <h5>Tax (
                                                    {{ Auth::guard('web')->user()->business->country->currency }} )
                                                </h5>
                                            </div>
                                            <div class="form-group col-md-6 text-right">
                                                <h5 id="label_tax_amount">0.0</h5>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Discount Amount</label>
                                            </div>
                                            <div class="form-group col-md-8">
                                                <h5>Discount (
                                                    {{ Auth::guard('web')->user()->business->country->currency }} )
                                                </h5>
                                            </div>
                                            <div class="form-group col-md-4 text-right">
                                                <h5 id="label_discount_amount">0.0</h5>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Total Amount</label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <h5>Total (
                                                    {{ Auth::guard('web')->user()->business->country->currency }} )
                                                </h5>
                                            </div>
                                            <div class="form-group col-md-6 text-right">
                                                <h5 id="label_total_amount">0.0</h5>
                                                <input type="hidden" id="total_amount" name="total_amount" />
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
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('js/page/advance-table.js') }}"></script>
    <script>
    </script>
@endsection
