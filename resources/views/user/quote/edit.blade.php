@extends('layouts.user')

@section('title')
    Quote || Dashboard
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
                    <form action="{{ route('quote.update', $quote->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Quote</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('quote.list') }}" class="btn btn-primary">
                                        Quote List
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
                                        <x-customer-select selectedid="{{ $quote->customer_id }}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <x-saleperson-select selectedid="{{ $quote->sales_person_id }}" />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="quote_number">Quote Number</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="quote_number" id="quote_number"
                                            value="{{ $quote->quote_number }}" readonly>
                                        @error('quote_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="reference_number">Reference Number</label>
                                        <input type="text" class="form-control" name="reference_number"
                                            id="reference_number" value="{{ $quote->reference_number }}">
                                        @error('reference_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="quote_date">Quote Date</label>
                                        <span class="text-danger">*</span>
                                        <input type="date" class="form-control" name="quote_date" id="quote_date"
                                            value="{{ $quote->quote_date }}" required>
                                        @error('quote_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="reference_number">Expiry Date</label>
                                        <input type="date" class="form-control" name="expiry_date" id="expiry_date"
                                            min="{{ $quote->quote_date }}" value="{{ $quote->expiry_date }}">
                                        @error('expiry_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="reference_number">Subject</label>
                                        <input type="text" class="form-control" name="subject" id="subject"
                                            value="{{ $quote->subject }}">
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
                                                <th scope="col" width="20%">Quantity</th>
                                                <th scope="col" width="20%">Rate</th>
                                                <th scope="col" width="20%">Tax</th>
                                                <th scope="col" width="20%">Amount</th>
                                                <th scope="col" width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="div_body">
                                            @foreach ($itemquote as $item)
                                                <tr>
                                                    <td><input type='hidden' id='items_id' class='items_id'
                                                            name='items_id[]' value="{{ $item->itemsid }}" /><input
                                                            type='text' id='item_name' class='form-control item_name'
                                                            value="{{ $item->name }}" readonly /></td>
                                                    <td><input type='number' id='quantity'
                                                            class='form-control quantity' name='quantity[]'
                                                            value="{{ $item->quantity }}" min='1' required /></td>
                                                    <td><input type='number' id='rate' class='form-control rate'
                                                            name='rate[]' value="{{ $item->rate }}" required /></td>
                                                    <td><select id="tax" name="tax[]"
                                                            class="form-control select2">
                                                            @foreach ($tax as $row)
                                                                <option>Choose</option>
                                                                <option value="{{ $row->id }}"
                                                                    @if ($row->id == $item->tax_id) selected @endif>
                                                                    {{ $row->name . ' [' . $row->rate . ']' }}
                                                                </option>
                                                            @endforeach
                                                        </select></td>
                                                    <td><input type='text' id='amount'
                                                            class='form-control inputamount' name='amount[]'
                                                            value="{{ $item->amount }}" readonly /></td>
                                                    <td style="display:flex">
                                                        <button type="button" class="btn btn-primary btn-sm m-1"
                                                            id="addnewitem">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm m-1"
                                                            id="removedbitem" data-id={{ $item->quoteid }}><i
                                                                class="fa fa-minus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <select class="form-control select2 item_id">
                                                        <option></option>
                                                        @foreach ($allitem as $row)
                                                            <option value="{{ $row->id }}">
                                                                {{ $row->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="quantity[]"
                                                        id="quantity" value="1">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="rate[]"
                                                        id="rate" value="0.0">
                                                </td>
                                                <td>
                                                    <select id="tax" name="tax[]" class="form-control select2"
                                                        name="tax">
                                                        <option>Choose</option>
                                                        @foreach ($tax as $row)
                                                            <option value="{{ $row->id }}">
                                                                {{ $row->name . ' [' . $row->rate . ']' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="amount[]"
                                                        id="amount" value="0.0" readonly>
                                                </td>
                                                <td style="text-align: center;vertical-align: middle;">
                                                    <button type="button" class="btn btn-primary btn-sm m1"
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
                                                <textarea class="form-control" name="note" id="note" rows="5" style="height: 125px !important;"> {{ $quote->note }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="customer_id">Terms & Conditions</label>
                                                <textarea class="form-control" name="terms_condition" id="terms_condition" rows="5"
                                                    style="height: 125px !important;">{{ $quote->terms_condition }}</textarea>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="customer_id">Upload</label>
                                                <input type="file" class="form-control" name="image[]" id="image"
                                                    multiple>
                                                <input type="hidden" name="imageShow" value="{{ $quote->image }}" />
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
                                                <select class="form-control tax select2" id="tax_id" name="tax_id">
                                                    <option value="">Choose...</option>
                                                    @foreach ($tax as $row)
                                                        <option value="{{ $row->id . '|' . $row->rate }}"
                                                            @if ($row->id == $quote->tax_id) selected @endif>
                                                            {{ $row->name . ' - ' . $row->rate }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="discount">Discount</label>
                                                <div class="input-group">
                                                    <input type="number" id="ddiscount" name="ddiscount"
                                                        class="form-control numbers ddiscount"
                                                        value="{{ $quote->discount ? $quote->discount : '0.0' }}"
                                                        min="0">
                                                    <input type="hidden" id="discount" name="discount"
                                                        class="form-control"
                                                        value="{{ $quote->discount ? $quote->discount : '0.0' }}">
                                                    <div class="input-group-append">
                                                        <select class="form-control" id="discountopt" name="discountopt">
                                                            <option value="1"
                                                                @if ($quote->discount_is_percentage == '0') selected @endif>
                                                                {{ Auth::guard('web')->user()->business->country->currency }}
                                                            </option>
                                                            <option value="2"
                                                                @if ($quote->discount_is_percentage == '1') selected @endif> %
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="shipping_charges">Shipping Charges</label>
                                                <div class="input-group">
                                                    <input type="number" id="shipping_charges" name="shipping_charges"
                                                        class="form-control numbers addinput" min="0"
                                                        value="{{ $quote->shipping_charges ? $quote->shipping_charges : '0.0' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mt-2">
                                                <label for="adjustment_name">Adjustment Name</label>
                                                <input type="text" id="adjustment_name" name="adjustment_name"
                                                    class="form-control"
                                                    value="{{ $quote->adjustment_name ? $quote->adjustment_name : 'Adjustment' }}">
                                            </div>
                                            <div class="form-group col-md-6 mt-2">
                                                <label for="adjustment_name_value">Adjustment Value</label>
                                                <input type="number" id="adjustment_name_value"
                                                    name="adjustment_name_value" class="form-control numbers addinput"
                                                    min="0"
                                                    value="{{ $quote->adjustment_value ? $quote->adjustment_value : '0.0' }}">
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
                                                <h5>Total ( {{ Auth::guard('web')->user()->business->country->currency }} )
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

    <x-customer-model />
    <x-saleperson-model />
    <x-item-model />
@endsection
@section('script')
    <script src="{{ asset('js/page/advance-table.js') }}"></script>
    <script>
        $(document).ready(function() {

            calculateSubTotal();
            calculateDiscount();
            calculateTotal();

            $('#customer_id').select2().on('select2:open', () => {
                $(".select2-results:not(:has(a))").append(
                    '<a href="#" id="loadcustomermodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new customer</a>'
                );
            });

            $('#sales_person_id').select2().on('select2:open', () => {
                $(".select2-results:not(:has(a))").append(
                    '<a href="#" id="loadsalepersonmodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new sales person</a>'
                );
            });

            $('.item_id').select2().on('select2:open', () => {
                $(".select2-results:not(:has(a))").append(
                    '<a href="#" id="loaditemmodal" style="padding: 6px;height: 20px;display: inline-table; width: 100%;"><i class="fas fa-plus-circle"></i> Create new item</a>'
                );
            });

            $(document).on('click', "a#loadcustomermodal", function() {
                $('#customer_id').select2('close');
                $("#customerModel").modal('show');
            });

            $(document).on('click', "a#loadsalepersonmodal", function() {
                $('#sales_person_id').select2('close');
                $("#salepersonModel").modal('show');
            });

            $(document).on('click', "a#loaditemmodal", function() {
                $('.item_id').select2('close');
                $("#itemModel").modal('show');
            });

            $(document).on('change', "input#quote_date", function() {
                $("input#expiry_date").attr("min", $(this).val());
            });

            $(document).on('keyup', 'input.quantity', function() {
                var result = Number($(this).val()) * Number($(this).closest('tr').find('input.rate').val());
                $(this).closest('tr').find('input.inputamount').val(result);
                calculateSubTotal();
            });

            $(document).on('keyup', 'input.rate', function() {
                var result = Number($(this).val()) * Number($(this).closest('tr').find('input.quantity')
                    .val());
                $(this).closest('tr').find('input.inputamount').val(result);
                calculateSubTotal();
            });

            $(document).on('change', "select.item_id", function() {
                let thiss = $(this);
                let item = $('option:selected', thiss).attr('value');
                let url = '{{ url('/quote/item/detail') }}' + '/' + item;
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    complete: function() {
                        $(".loader").hide();
                    },
                    success: function(response) {
                        $(thiss).parent().parent().remove();
                        $('.tax').select2({
                            placeholder: "Select",
                            allowClear: true,
                        });
                        $("#div_body").append(response);
                        calculateSubTotal();
                    }
                });
            });

            $(document).on('click', 'button#addnewitem', function() {
                newItemCreate();
            });

            $(document).on('click', 'button#removenewitem', function() {
                $(this).parent().parent().remove();
                countRowTr();
                calculateSubTotal();
            });

            $(document).on('keyup', 'input.addinput', function() {
                calculateTotal();
            });

            $(document).on('keyup', 'input.ddiscount', function() {
                calculateDiscount();
            });

            $(document).on('change', 'select#discountopt', function() {
                calculateDiscount();
            });

            $(document).on('change', 'select#tax_id', function() {
                calculateTotal();
            });

            $(document).on('click', 'button#removedbitem', function() {
                let thiss = $(this);
                let id = $(this).data('id');
                swal({
                        title: 'Are you sure?',
                        text: "You want to delete this item? This action can't ne reverted",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Yes!",
                        closeOnConfirm: false
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            let url = '{{ url('/quote/item/delete') }}' + '/' + id;
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                data: {
                                    "id": id,
                                    "_token": '{{ csrf_token() }}',
                                },
                                beforeSend: function() {
                                    $(".loader").show();
                                },
                                complete: function() {
                                    $(".loader").hide();
                                },
                                success: function(response) {
                                    $(thiss).parent().parent().remove();
                                    calculateSubTotal();
                                    calculateDiscount();
                                    calculateTotal();
                                }
                            });
                        }
                    });
            });
        });


        function calculateDiscount() {
            let value = Number($('input#ddiscount').val());
            let option = $('select#discountopt option:selected').val();
            let result = 0;
            if (option == '2' || option == 2) {
                let total = 0;
                $("input.addinput").each(function() {
                    total = Number(total) + Number($(this).val());
                });
                result = (total * (value / 100)).toFixed(2);;
            } else {
                result = value.toFixed(2);
            }
            $('#label_discount_amount').text(result);
            $('input#discount').val(result);
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            let tax = $('select#tax_id option:selected').val();
            $("input.addinput").each(function() {
                total = Number(total) + Number($(this).val());
            });
            let totaltax = 0;
            if (tax != '') {
                let taxvalue = tax.split('|');
                totaltax = (Number(total) * (taxvalue[1] / 100)).toFixed(2);
                $("h5#label_tax_amount").text(totaltax);
            }
            let discount = $("input#discount").val();
            let result = (Number(total) + Number(totaltax) - Number(discount)).toFixed(2);
            $("input#total_amount").val(result);
            $("h5#label_total_amount").text(result);
        }

        function calculateSubTotal() {
            let total = 0;
            $("input.inputamount").each(function() {
                total = (Number(total) + Number($(this).val())).toFixed(2);;
            });
            $("input#sub_total").val(total);
            $("#label_sub_total_amount").html(total);
            calculateTotal();
        }

        function newItemCreate() {
            let output = '';
            output += '<tr><td>';
            output +=
                '<select class="form-control select2 item_id"><option></option> ';
            @foreach ($allitem as $row)
                output += '<option value="' + {{ $row->id }} + '">';
                output += '{{ $row->name }}';
                output += '</option>';
            @endforeach
            output += '</select></td>';
            output += '<td><input type="text" class="form-control" value="1"> </td>';
            output += '<td><input type="text" class="form-control" value="0.0"></td>';
            output += '<td><select class="form-control tax select2"><option></option>';
            @foreach ($tax as $row)
                @php $label = $row->name . ' ['. $row->rate . ']'; @endphp
                output += '<option value="' + {{ $row->id }} + '">';
                output += '{{ $label }}';
                output += '</option>';
            @endforeach
            output += '</select></td>';
            output += '<td><input type="text" class="form-control" name="amount[]" id="amount" value="0.0" readonly></td>';
            output +=
                '<td style="display:flex;"><button style="margin: 4px;" type="button" class="btn btn-primary btn-sm m1" id="addnewitem"><i class="fa fa-plus"></i></button>';
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
            @foreach ($allitem as $row)
                output += '<option value="' + {{ $row->id }} + '">';
                output += '{{ $row->name }}';
                output += '</option>';
            @endforeach
            output += '</select></td>';
            output += '<td><input type="text" class="form-control" value="1"> </td>';
            output += '<td><input type="text" class="form-control" value="0.0"></td>';
            output += '<td><select class="form-control select2 tax_id"><option></option>';
            @foreach ($tax as $row)
                @php $label = $row->name . ' ['. $row->rate . ']'; @endphp
                output += '<option value="' + {{ $row->id }} + '">';
                output += '{{ $label }}';
                output += '</option>';
            @endforeach
            output += '</select></td>';
            output += '<td><input type="text" class="form-control" name="amount[]" id="amount" value="0.0" readonly></td>';
            output +=
                '<td style="display:flex;"><button style="margin: 4px;" type="button" class="btn btn-primary btn-sm m1" id="addnewitem"><i class="fa fa-plus"></i></button></td>';

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
    </script>
@endsection
