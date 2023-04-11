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
                            <h4>Vendor Primary Detail</h4>
                            <div class="card-header-action">
                                <a href="{{ route('vendor.list') }}" class="btn btn-primary">
                                    Vendors List
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

                                <div class="form-group col-md-4">
                                    <label for="salutation">Salutation</label>
                                    <span class="text-danger">*</span>
                                    <select id="salutation" name="salutation" class="form-control" required>
                                        <option value="">Choose...</option>

                                        <option>Mr.</option>
                                        <option>Ms.</option>
                                        <option>Sir.</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="first_name">First Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror


                                </div>
                                <div class="form-group col-md-4">
                                    <label for="last_name">Last Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="email">Vendor Email</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="display_name">Vendor Display Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="display_name" id="display_name" value="{{ old('display_name') }}" required>
                                    @error('display_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="contact_mobile">Vendor Mobile</label>
                                    <input type="text" class="form-control" name="customer_mobile" id="customer_mobile" value="{{ old('customer_mobile') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" id="company_name" value="{{ old('company_name') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="customer_phone">Vendor Work Phone</label>
                                    <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}">
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="designation">Designation</label>
                                    <input type="text" class="form-control" name="designation" id="designation" value="{{ old('designation') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="department">Department</label>
                                    <input type="text" class="form-control" name="department" id="department" value="{{ old('department') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="skype">Vendor Skype Name/Number</label>
                                    <input type="text" class="form-control" name="skype" id="skype" value="{{ old('skype') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="skwebsiteype">Website</label>
                                    <input type="url" class="form-control" name="website" id="website" value="{{ old('website') }}">
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h4>Vendor Secondary Detail</h4>
                        </div>

                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="other-detail-tab" data-toggle="tab" href="#other_detail" role="tab" aria-controls="other-detal" aria-selected="true">Other Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Address</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-person-tab" data-toggle="tab" href="#contact_person" role="tab" aria-controls="contact-person" aria-selected="false">Contact Person</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-person-tab" data-toggle="tab" href="#custom_field" role="tab" aria-controls="contact-person" aria-selected="false">Custom Fields</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-person-tab" data-toggle="tab" href="#reporting_tag" role="tab" aria-controls="contact-person" aria-selected="false">Reporting Tags</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="remarks-tab" data-toggle="tab" href="#remarks" role="tab" aria-controls="remarks" aria-selected="false">Remarks</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="other_detail" role="tabpanel" aria-labelledby="other-detail-tab">

                                    <div class="form-row">
                                        <label class="form-group col-md-3">Currency</label>
                                        <div class="form-group col-md-9">
                                            <select id="currency" name="currency" class="form-control select2" style="width: 100%">
                                                <option value="">Select option</option>

                                                <option value="">
                                                    PKR
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label class="form-group col-md-3">Opening Balance</label>
                                        <div class="form-group col-md-9">
                                            <select id="tax" name="tax" class="form-control select2" style="width: 100%">
                                                <option value="">Select option</option>

                                                <option value=""> 200
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label class=" form-group col-md-3">Payment Terms</label>
                                        <div class="form-group col-md-9">
                                            <Select class="form-control">
                                                <option value="" selected disabled>Due on Receipt</option>
                                                <option value="">Net 30</option>
                                                <option value="">Due end of the month</option>
                                                <option value="">Due end of the next month</option>
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <label class=" form-group col-md-3">Enable Portal?</label>
                                        <div class="form-group col-md-9">
                                            <input type="checkbox" name="" id="enPortal"><label for="enPortal">
                                                <p style="font-size: 14px; margin-top:10px; margin-left:10px">Allow portal access for this vendor</p>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label class="form-group col-md-3">Facebook</label>
                                        <div class="form-group col-md-9">
                                            <input type="type" class="form-control" name="facebook_link" id="facebook">
                                            <span class="text-muted font-xs">http://www.facebook.com/<strong id="facebooklabel"></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label class=" form-group col-md-3">Twitter</label>
                                        <div class="form-group col-md-9">
                                            <input type="type" class="form-control" name="twitter_link" id="twitter">
                                            <span class="text-muted font-xs">http://www.twitter.com/<strong id="twitterlabel"></strong>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-group">Billing Address</label>
                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Attention</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="b_attention" id="b_attention" value="{{ old('b_attention') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class="form-group col-md-3">Country</label>
                                                <div class="form-group col-md-9">
                                                    <select id="b_country" name="b_country" class="form-control select2" style="width: 100%">
                                                        <option value="">Select option</option>

                                                        <option value="">
                                                            Pakistan
                                                        </option>
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
                                                    <input type="text" class="form-control" name="b_city" id="b_city" value="{{ old('b_city') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">State</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="b_state" id="b_state" value="{{ old('b_state') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Zip code</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="b_zipcode" id="b_zipcode" value="{{ old('b_zipcode') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Mobile</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="b_mobile" id="b_mobile" value="{{ old('b_mobile') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Fax</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="b_fax" id="b_fax" value="{{ old('b_fax') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-group">Shipping Address</label>
                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Attention</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="shipping_attention" id="shipping_attention" value="{{ old('shipping_attention') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class="form-group col-md-3">Country</label>
                                                <div class="form-group col-md-9">
                                                    <select id="shipping_country" name="shipping_country" class="form-control select2" style="width: 100%">
                                                        <option value="">Select option</option>

                                                        <option value="">
                                                            Pakistan
                                                        </option>

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
                                                    <input type="text" class="form-control" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">State</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="shipping_state" id="shipping_state" value="{{ old('shipping_state') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Zip code</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="shipping_zipcode" id="shipping_zipcode" value="{{ old('shipping_zipcode') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Mobile</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="shipping_mobile" id="shipping_mobile" value="{{ old('shipping_mobile') }}">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <label class=" form-group col-md-3">Fax</label>
                                                <div class="form-group col-md-9">
                                                    <input type="text" class="form-control" name="shipping_fax" id="shipping_fax" value="{{ old('shipping_fax') }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact_person" role="tabpanel" aria-labelledby="contact-person-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Salutation</th>
                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Last Last</th>
                                                    <th scope="col">Email Address</th>
                                                    <th scope="col">Work Phone</th>
                                                    <th scope="col">Mobile</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="div_contact_person">
                                                    <td>
                                                        <select id="contact_salutation" name="contact_salutation[]" class="form-control" name="contact_salutation">
                                                            <option></option>

                                                            <option value="">Mr.</option>
                                                            <option value="">Ms.</option>

                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="contact_first_name[]" id="contact_first_name" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="contact_last_name[]" id="contact_last_name" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="contact_email[]" id="contact_email" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="contact_mobile[]" id="contact_mobile" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="contact_phone_no[]" id="contact_phone_no" value="">
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
                                <div class="tab-pane fade" id="custom_field" role="tabpanel" aria-labelledby="remarks-tab">
                                    <p class="p-4">Start adding custom fields for your contacts by going to Settings Preferences Customers and Vendors. You can also refine the address format of your customers from there.</p>
                                </div>
                                <div class="tab-pane fade" id="reporting_tag" role="tabpanel" aria-labelledby="remarks-tab">
                                    <p class="p-4">You've not created any Reporting Tags. Start creating reporting tags by going to More Settings Reporting Tags</p>
                                </div>
                                <div class="tab-pane fade" id="remarks" role="tabpanel" aria-labelledby="remarks-tab">
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

@endsection