<!-- Large ITEM modal -->
<div id="itemModel" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="itemModelForm">
                <div class="modal-body">
                    <div id="itemerror"></div>

                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Type</label>
                            <div class="form-row mt-2">
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="is_service_service" name="is_service"
                                            class="custom-control-input" value='1'
                                            {{ old('is_service') == '1' ? 'checked' : '' }} checked>
                                        <label class="custom-control-label" for="is_service_service">Service</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="is_service_good" name="is_service"
                                            class="custom-control-input" value='0'
                                            {{ old('is_service') == '0' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_service_good">Goods</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="unit_id">Unit</label>
                            <select id="unit_id" name="unit_id" class="form-control select2"
                                style="width:364px !important;">
                                <option value="">Choose...</option>
                                @foreach ($unit as $row)
                                    <option value="{{ $row->id }}"
                                        @if (old('unit_id') == $row->id) selected @endif>{{ $row->unit }}
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
                                <input type="number" class="form-control" id="selling_price" name="selling_price"
                                    value="{{ old('selling_price') }}" required>
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
                                style="width:364px !important;" required>
                                <option value="">Choose...</option>
                                @foreach ($account as $row)
                                    <option value="{{ $row->id }}"
                                        @if (old('account_type_id') == $row->id) selected @endif>
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
                            <select id="tax_id" name="tax_id" class="form-control select2"
                                style="width:364px !important;" required>
                                <option value="">Choose...</option>
                                @foreach ($tax as $row)
                                    <option value="{{ $row->id }}"
                                        @if (old('tax_id') == $row->id) selected @endif>
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
                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary mr-1" type="button" onclick="submitItem()">Submit</button>
                        <button class="btn btn-secondary" onclick="closeItem()">Close</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
<script>
    function closeItem() {
        $("#itemModel").modal('hide');
    }

    function submitItem() {
        var myForm = $('form#itemModelForm')
        if (!myForm[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            // $myForm.find(':submit').click();
            myForm[0].reportValidity();
            return false;
        }
        let token = "{{ csrf_token() }}";
        let url = "{{ url('/quote/item/insert/ajax') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: $('#itemModelForm').serialize(),
            beforeSend: function() {
                $(".loader").show();
            },
            complete: function() {
                $(".loader").hide();
            },
            success: function(response) {
                var typeOfResponse = response.type;
                if (!typeOfResponse) {
                    if (response.validator_error) {
                        let errors = response.errors;
                        $.each(response.errors, function(key, value) {
                            $('#itemerror').append('<div class="alert alert-danger">' +
                                value + '</div>');
                        });
                    } else {
                        let msg = response.msg;
                        iziToast.error({
                            title: 'Error!<br>',
                            message: msg,
                            position: 'topRight'
                        });
                    }
                } else {
                    let data = response.data;
                    $('.item_id').select2({
                        data: data
                    });
                    iziToast.success({
                        title: 'Success',
                        message: "Item is added successfully",
                        position: 'topRight'
                    });

                    $('#itemModelForm')[0].reset();
                    $('#itemModel').modal('hide');
                }
            }
        });
    }
</script>
