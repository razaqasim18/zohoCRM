@extends('layouts.auth')
@section('title')
    Registration
@endsection
@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Registration</h4>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('register.final') }}">
                                @csrf
                                <input id="name" type="hidden" class="form-control" name="name"
                                    value="{{ $name }}" autocomplete="name" autofocus>
                                <input id="mobile" type="hidden" class="form-control" name="mobile"
                                    value="{{ $mobile }}" autocomplete="mobile" autofocus>
                                <input id="email" type="hidden" class="form-control" name="email"
                                    value="{{ $email }}" autocomplete="email" autofocus>
                                <input id="password" type="hidden" class="form-control" name="password"
                                    value="{{ $password }}" autocomplete="password" autofocus>
                                <input id="country" type="hidden" class="form-control" name="country"
                                    value="{{ $select_country }}" autocomplete="country" autofocus>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="companyname">Company Name</label>
                                        <span class="text-danger">*</span>
                                        <input id="companyname" type="text"
                                            class="form-control @error('companyname') is-invalid @enderror"
                                            name="companyname" value="{{ $companyname }}" required
                                            autocomplete="companyname" autofocus>
                                        @error('companyname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Country</label>
                                        <span class="text-danger">*</span>
                                        <select id="country_id" name="country_id" class="form-control select2" required
                                            disabled>
                                            <option value="">Select option</option>
                                            @foreach ($country as $row)
                                                <option value={{ $row->id }}
                                                    {{ $select_country == $row->id ? 'selected' : '' }}
                                                    {{ old('country') == $row->id ? 'selected' : '' }}>{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Currency</label>
                                        <span class="text-danger">*</span>
                                        <select id="currency" name="currency" class="form-control select2" disabled>
                                            <option value="">Select option</option>
                                            @foreach ($country as $row)
                                                <option value={{ $row->id }}
                                                    {{ $select_country == $row->id ? 'selected' : '' }}>
                                                    {{ $row->currency . ' - ' . $row->currency_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('currency')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>State</label>
                                        <span class="text-danger">*</span>
                                        <select id="state" name="state" class="form-control select2" required>
                                            <option value="">Select option</option>
                                            @foreach ($state as $row)
                                                <option value="{{ $row->id }}"> {{ $row->name }} </option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="city">City</label>
                                        <input id="city" type="text"
                                            class="form-control @error('city') is-invalid @enderror" name="city"
                                            value="{{ old('city') }}" autocomplete="city" autofocus>
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="street1">Street 1</label>
                                        <input id="street1" type="text"
                                            class="form-control @error('street1') is-invalid @enderror" name="street1"
                                            autocomplete="street1">
                                        @error('street1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="street2">Street 2</label>
                                        <input id="street2" type="text"
                                            class="form-control @error('street2') is-invalid @enderror" name="street2"
                                            autocomplete="street2">
                                        @error('street2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="zipcode">Zipcode</label>
                                        <input id="zipcode" type="text"
                                            class="form-control @error('zipcode') is-invalid @enderror" name="zipcode"
                                            autocomplete="zipcode">
                                        @error('zipcode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <div class="custom-control">
                                            <input type="checkbox" id="is_vat" name="is_vat"
                                                class="custom-control-input" value='1'
                                                {{ old('is_vat') == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_vat">Is this business registered
                                                for VAT?</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row vat_option" id="vat_option" style="display: none">
                                    <div class="form-group col-4">
                                        <label for="tax_registration_number_label">Tax Registration Number
                                            Label</label>
                                        <input id="tax_registration_number_label" type="text"
                                            class="form-control @error('tax_registration_number_label') is-invalid @enderror"
                                            name="tax_registration_number_label"
                                            autocomplete="tax_registration_number_label">
                                        @error('tax_registration_number_label')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="tax_registration_number_trn">Tax Registration Number Trn</label>
                                        <span class="text-danger">*</span>
                                        <input type="text"
                                            class="form-control @error('tax_registration_number_trn') is-invalid @enderror"
                                            id="tax_registration_number_trn" name="tax_registration_number_trn"
                                            autocomplete="tax_registration_number_trn">
                                        @error('street2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="zipcode">Tax Registration Number Date</label>
                                        <span class="text-danger">*</span>
                                        <input type="date"
                                            class="form-control @error('tax_registration_number_date') is-invalid @enderror"
                                            name="tax_registration_number_date" id="tax_registration_number_date"
                                            autocomplete="tax_registration_number_date">
                                        @error('tax_registration_number_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Register
                                    </button>
                                </div>

                            </form>
                        </div>
                        <div class="mb-4 text-muted text-center">
                            Already Registered? <a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#is_vat").click(function() {
                if ($(this).prop("checked") == true) {
                    $("input#tax_registration_number_trn").prop('required', true);
                    $("input#tax_registration_number_date").prop('required', true);
                    $("#vat_option").css({
                        "display": "flex"
                    });
                } else {
                    $("input#tax_registration_number_trn").prop('required', false);
                    $("input#tax_registration_number_date").prop('required', false);
                    $("#vat_option").css({
                        "display": "none"
                    });
                }
            });
        });
    </script>
@endsection
