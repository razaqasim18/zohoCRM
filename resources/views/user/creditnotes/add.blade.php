@extends('layouts.user')

@section('title')
    Credit Notes || Dashboard
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
                                <h4>Add Credit Notes</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('quote.list') }}" class="btn btn-primary">
                                        Credit Notes List
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
                                        <label for="quote_number">Credit Note#</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="quote_number" id="quote_number"
                                            value="" required>
                                        @error('quote_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                     <div class="form-group col-md-6">
                                        <label for="quote_number">Reference#</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="quote_number" id="quote_number"
                                            value="{{ getUniqueEstimateID() }}" required>
                                        @error('quote_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="quote_date">Credit Note Date</label>
                                        <span class="text-danger">*</span>
                                        <input type="date" class="form-control" name="quote_date" id="quote_date"
                                            value="{{ old('quote_date') }}" required>
                                        @error('quote_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                         <label for="reference_number">Subject</label>
                                        <input type="text" class="form-control" name="subject" id="subject"
                                            value="{{ old('subject') }}">
                                        @error('subject')
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
   <script>
          

        $(document).on('click', 'button#removenewitem', function() {
                console.log('ss');
                $(this).parent().parent().remove();
                countRowTr();
                calculateSubTotal();
        });
        
          function newItemCreate() {
            let output = '';
            output += '<tr><td>';
            output +='<select class="form-control select2 item_id"><option></option> ';
            output += '</select></td>';

            output += '<td>';
            output +='<select class="form-control select2 item_id"><option></option> ';
            output += '</select></td>';
            
            output += '<td><input type="text" class="form-control" value="1"> </td>';
            output += '<td><input type="text" class="form-control" value="0.0"></td>';
            output += '<td><select class="form-control tax select2"><option></option>';
            
            output += '</select></td>';
            output += '<td><input type="text" class="form-control" name="amount[]" id="amount" value="0.0" readonly></td>';
            output +=
                '<td style="display:flex;"><button onclick = "newItemCreate()" style="margin: 4px;" type="button" class="btn btn-primary btn-sm m1" id="addnewitem"><i class="fa fa-plus"></i></button>';
            output +=
                '<button style="margin: 4px;" type="button" class="btn btn-danger btn-sm m1" id="removenewitem"><i class="fa fa-minus"></i></button></td>';

            $("tbody#div_body").append(output);
            $('.item_id').select2({
                placeholder: "Select",
                allowClear: true,
            }).on('select2:open', () => {
                $(".select2-results:not(:has(a))").append(
                    '<a href="#" id="loaditemmodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new item</a>'
                );
            });
            $('.tax').select2({
                placeholder: "Select",
                allowClear: true,
            });
        }
       
        function countRowTr() {
            var count = $('#div_body tr').length;
            if (count == 0) {
                newItemnodelete();
            }
        }

        function newItemnodelete() {
            let output = '';
            output += '<tr><td>';
            output +=
                '<select class="form-control select2 item_id"><option></option> ';
          
            output += '</select></td>';
            output += '<td><input type="text" class="form-control" value="1"> </td>';
            output += '<td><input type="text" class="form-control" value="0.0"></td>';
            output += '<td><select class="form-control tax select2"><option></option>';
           
            output += '</select></td>';
            output += '<td><input type="text" class="form-control" name="amount[]" id="amount" value="0.0" readonly></td>';
            output +=
                '<td style="display:flex;"><button style="margin: 4px;" type="button" class="btn btn-primary btn-sm m1" id="addnewitem"><i class="fa fa-plus"></i></button></td>';
            $('.tax').select2({
                placeholder: "Select",
                allowClear: true,
            });
            $("tbody#div_body").append(output);
        }
        </script>
@endsection




 