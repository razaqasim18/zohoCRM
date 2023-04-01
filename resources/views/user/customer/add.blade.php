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
                                <h4>Customer Primary Detail</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('customer.list') }}" class="btn btn-primary">
                                        Customer List
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
                                        <label>Customer Type</label>
                                        <div class="form-row mt-2">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="business_type" name="is_business"
                                                        class="custom-control-input" value='1'
                                                        {{ old('is_business') == '1' ? 'checked' : '' }} checked>
                                                    <label class="custom-control-label" for="business_type">Business</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="individual_type" name="is_business"
                                                        class="custom-control-input" value='0'
                                                        {{ old('is_business') == '0' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="individual_type">Individual</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="salutation">Salutation</label>
                                        <span class="text-danger">*</span>
                                        <select id="salutation" name="salutation" class="form-control" required>
                                            <option value="">Choose...</option>
                                            @foreach ($salutation as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (old('salutation') == $row->id)  @endif>{{ $row->salutation }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('salutation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name">First Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="last_name">Last Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                            value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="email">Customer Email</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="email" id="email"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="display_name">Customer Display Name</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="display_name" id="display_name"
                                            value="{{ old('display_name') }}" required>
                                        @error('display_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="contact_mobile">Customer Mobile</label>
                                        <input type="text" class="form-control" name="customer_mobile"
                                            id="customer_mobile" value="{{ old('customer_mobile') }}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" name="company_name" id="company_name"
                                            value="{{ old('company_name') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="customer_phone">Customer Work Phone</label>
                                        <input type="text" class="form-control" name="customer_phone"
                                            id="customer_phone" value="{{ old('customer_phone') }}">
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="designation">Designation</label>
                                        <input type="text" class="form-control" name="designation" id="designation"
                                            value="{{ old('designation') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="department">Department</label>
                                        <input type="text" class="form-control" name="department" id="department"
                                            value="{{ old('department') }}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="skype">Customer Skype Name/Number</label>
                                        <input type="text" class="form-control" name="skype" id="skype"
                                            value="{{ old('skype') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="skwebsiteype">Website</label>
                                        <input type="url" class="form-control" name="website" id="website"
                                            value="{{ old('website') }}">
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="card">
                            <div class="card-header">
                                <h4>Customer Secondary Detail</h4>
                            </div>

                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="other-detail-tab" data-toggle="tab"
                                            href="#other_detail" role="tab" aria-controls="other-detal"
                                            aria-selected="true">Other Detail</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="address-tab" data-toggle="tab" href="#address"
                                            role="tab" aria-controls="address" aria-selected="false">Address</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-person-tab" data-toggle="tab"
                                            href="#contact_person" role="tab" aria-controls="contact-person"
                                            aria-selected="false">Contact Person</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="remarks-tab" data-toggle="tab" href="#remarks"
                                            role="tab" aria-controls="remarks" aria-selected="false">Remarks</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="other_detail" role="tabpanel"
                                        aria-labelledby="other-detail-tab">

                                        <div class="form-row">
                                            <label class="form-group col-md-3">Currency</label>
                                            <div class="form-group col-md-9">
                                                <select id="currency" name="currency" class="form-control select2"
                                                    style="width: 100%">
                                                    <option value="">Select option</option>
                                                    @foreach ($currency as $row)
                                                        <option value="{{ $row->id }}">
                                                            {{ $row->symbol . ' - ' . $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <label class="form-group col-md-3">Tax</label>
                                            <div class="form-group col-md-9">
                                                <select id="tax" name="tax" class="form-control select2"
                                                    style="width: 100%">
                                                    <option value="">Select option</option>
                                                    @foreach ($tax as $row)
                                                        <option value="{{ $row->id }}">
                                                            {{ $row->name . ' [' . $row->rate . ']' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <label class=" form-group col-md-3">Opening Balance</label>
                                            <div class="form-group col-md-9">
                                                <input type="type" class="form-control" name="opening_balance"
                                                    id="opening_balance">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <label class="form-group col-md-3">Facebook</label>
                                            <div class="form-group col-md-9">
                                                <input type="type" class="form-control" name="facebook_link"
                                                    id="facebook">
                                                <span class="text-muted font-xs">http://www.facebook.com/<strong
                                                        id="facebooklabel"></strong>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <label class=" form-group col-md-3">Twitter</label>
                                            <div class="form-group col-md-9">
                                                <input type="type" class="form-control" name="twitter_link"
                                                    id="twitter">
                                                <span class="text-muted font-xs">http://www.twitter.com/<strong
                                                        id="twitterlabel"></strong>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade" id="address" role="tabpanel"
                                        aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-group">Billing Address</label>
                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Attention</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="b_attention"
                                                            id="b_attention" value="{{ old('b_attention') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class="form-group col-md-3">Country</label>
                                                    <div class="form-group col-md-9">
                                                        <select id="b_country" name="b_country"
                                                            class="form-control select2" style="width: 100%">
                                                            <option value="">Select option</option>
                                                            @foreach ($country as $row)
                                                                <option value={{ $row->id }}
                                                                    {{ old('name') == $row->id ? 'selected' : '' }}>
                                                                    {{ $row->country }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Address</label>
                                                    <div class="form-group col-md-9">
                                                        <textarea class="form-control" name="b_address" id="b_address">{{ old('b_address') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">City</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="b_city"
                                                            id="b_city" value="{{ old('b_city') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">State</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="b_state"
                                                            id="b_state" value="{{ old('b_state') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Zip code</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="b_zipcode"
                                                            id="b_zipcode" value="{{ old('b_zipcode') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Mobile</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="b_mobile"
                                                            id="b_mobile" value="{{ old('b_mobile') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Fax</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="b_fax"
                                                            id="b_fax" value="{{ old('b_fax') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-group">Shipping Address</label>
                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Attention</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control"
                                                            name="shipping_attention" id="shipping_attention"
                                                            value="{{ old('shipping_attention') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class="form-group col-md-3">Country</label>
                                                    <div class="form-group col-md-9">
                                                        <select id="shipping_country" name="shipping_country"
                                                            class="form-control select2" style="width: 100%">
                                                            <option value="">Select option</option>
                                                            @foreach ($country as $row)
                                                                <option value={{ $row->id }}
                                                                    {{ old('name') == $row->id ? 'selected' : '' }}>
                                                                    {{ $row->country }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Address</label>
                                                    <div class="form-group col-md-9">
                                                        <textarea class="form-control" name="shipping_address" id="shipping_address">{{ old('shipping_address') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">City</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="shipping_city"
                                                            id="shipping_city" value="{{ old('shipping_city') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">State</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="shipping_state"
                                                            id="shipping_state" value="{{ old('shipping_state') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Zip code</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control"
                                                            name="shipping_zipcode" id="shipping_zipcode"
                                                            value="{{ old('shipping_zipcode') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Mobile</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="shipping_mobile"
                                                            id="shipping_mobile" value="{{ old('shipping_mobile') }}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <label class=" form-group col-md-3">Fax</label>
                                                    <div class="form-group col-md-9">
                                                        <input type="text" class="form-control" name="shipping_fax"
                                                            id="shipping_fax" value="{{ old('shipping_fax') }}">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact_person" role="tabpanel"
                                        aria-labelledby="contact-person-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Salutation</th>
                                                        <th scope="col">First Name</th>
                                                        <th scope="col">Last Last</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Mobile</th>
                                                        <th scope="col">Work Phone</th>
                                                        <th scope="col">Designation</th>
                                                        <th scope="col">Department</th>
                                                        <th scope="col">Skype Name/Number</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="div_contact_person">
                                                        <td>
                                                            <select id="contact_salutation" name="contact_salutation[]"
                                                                class="form-control" name="contact_salutation">
                                                                <option></option>
                                                                @foreach ($salutation as $row)
                                                                    <option value="{{ $row->id }}">
                                                                        {{ $row->salutation }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_first_name[]" id="contact_first_name"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_last_name[]" id="contact_last_name"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_email[]" id="contact_email" value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_mobile[]" id="contact_mobile"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_phone_no[]" id="contact_phone_no"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_designation[]" id="contact_designation"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_department[]" id="contact_department"
                                                                value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="contact_skype[]" id="contact_skype" value="">
                                                        </td>
                                                        <td style="text-align: center;vertical-align: middle;">
                                                            <button type="button" class="btn btn-primary btn-sm m1"
                                                                id="addnewcontactperson">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="remarks" role="tabpanel"
                                        aria-labelledby="remarks-tab">
                                        <div class="form-group mb-0">
                                            <label>Remarks</label>
                                            <textarea class="form-control" id="remarks" name="remarks"></textarea>
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
        $(document).ready(function() {

            $(document).on('click', 'a.nav-link', function() {
                if ($('a#contact-person-tab').hasClass('active')) {
                    $('div#div_contact_person #contact_email,#contact_last_name,#contact_first_name').attr(
                        'required', true);
                } else {
                    $('div#div_contact_person #contact_email,#contact_last_name,#contact_first_name').attr(
                        'required', false);
                }
            });

            $("#twitter").keyup(function() {
                $("#twitterlabel").text($(this).val());
            });

            $("#facebook").keyup(function() {
                $("#facebooklabel").text($(this).val());
            });


            $(document).on('click', 'button#addnewcontactperson', function() {
                createNewContactPerson();
            });

            $(document).on('click', 'button#removenewcontactperson', function() {
                $(this).parent().parent().remove();
            });

        });

        function createNewContactPerson() {
            output = '';
            output +=
                '<tr><td><select id="contact_salutation" class="form-control" name="contact_salutation[]" >';
            output += '<option></option>';
            @foreach ($salutation as $row)
                output += '<option value="' + {{ $row->id }} + '">';
                output += '{{ $row->salutation }}';
                output += '</option>';
            @endforeach
            output += '</select></td>';
            output +=
                '<td><input type="text" class="form-control" name="contact_first_name[]" id="contact_first_name" value="" required></td>';
            output +=
                '<td><input type="text" class="form-control" name="contact_last_name[]" id="contact_last_name" value="" required > </td>';
            output +=
                '<td><input type="text" class="form-control" name="contact_email[]" id="contact_email" value="" required></td>';
            output +=
                '<td> <input type="text" class="form-control" name="contact_mobile[]" id="contact_mobile" value="" > </td>';
            output +=
                '<td> <input type="text" class="form-control" name="contact_phone_no[]" id="contact_phone_no" value="" ></td>';
            output +=
                '<td><input type="text" class="form-control" name="contact_designation[]" id="contact_designation" value="" ></td>';
            output +=
                '<td> <input type="text" class="form-control" name="contact_department[]" id="contact_department" value="" ></td>';
            output +=
                '<td><input type="text" class="form-control" name="contact_skype[]" id="contact_skype" value="" ></td><td style="display:flex;">';
            output +=
                '<button type="button" class="btn btn-primary btn-sm m-1" id="addnewcontactperson"><i class="fa fa-plus"></i></button>';
            output +=
                '<button type="button" class="btn btn-danger btn-sm m-1" id="removenewcontactperson"><i class="fa fa-minus"></i></button>';

            output += '</td></tr>';
            $("#div_contact_person").after(output);
        }
    </script>
@endsection
