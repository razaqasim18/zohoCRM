<!-- Large modal -->
<div id="customerModel" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="customerForm">
                    @csrf
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
                                        <label class="custom-control-label" for="individual_type">Individual</label>
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
                                    <option value="{{ $row->id }}" @if (old('salutation') == $row->id)  @endif>
                                        {{ $row->salutation }}
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
                            <input type="text" class="form-control" name="customer_mobile" id="customer_mobile"
                                value="{{ old('customer_mobile') }}">
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
                            <input type="text" class="form-control" name="customer_phone" id="customer_phone"
                                value="{{ old('customer_phone') }}">
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

                    <div class="text-right">
                        <button class="btn btn-primary mr-1" type="button"
                            onclick="submitCustomer()">Submit</button>
                        <button class="btn btn-secondary" onclick="closeCustomerModel()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function closeCustomerModel() {
        $("#customerModel").modal('hide');
    }

    function submitCustomer() {
        var myForm = $('form#customerForm')
        if (!myForm[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            // $myForm.find(':submit').click();
            myForm[0].reportValidity();
            return false;
        }
        console.log($('#customerForm').serialize());
        let token = "{{ csrf_token() }}";
        let url = "{{ url('/quote/customer/insert/ajax') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: $('#customerForm').serialize(),
            beforeSend: function() {
                $(".loader").show();
            },
            complete: function() {
                $(".loader").hide();
            },
            success: function(response) {
                var typeOfResponse = response.type;
                if (!typeOfResponse) {
                    let msg = response.msg;
                    iziToast.error({
                        title: 'Error!<br>',
                        message: msg,
                        position: 'topRight'
                    });
                } else {
                    let data = response.data;
                    $('#customer_id').select2({
                        data: data
                    });
                    iziToast.success({
                        title: 'Success',
                        message: "Customer is added successfully",
                        position: 'topRight'
                    });
                    $('#customerForm')[0].reset();
                    $('#customerModel').modal('hide');
                }
            }
        });
    }
</script>
