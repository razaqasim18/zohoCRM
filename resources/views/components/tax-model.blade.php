<!-- Large modal -->
<div id="taxModel" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Tax</h5>
                <button type="button" class="close" onclick="closetaxModel()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="taxerror"></div>
                <form id="taxModelForm">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Tax Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <br /><span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="rate">Tax Rate</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="rate" value="{{ old('rate') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            @error('rate')
                                <br /><span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="iscompound"
                                        id="iscompound" value="1">
                                    <label class="custom-control-label" for="iscompound">This tax is a compound
                                        tax.</label>
                                    @error('iscompound')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary mr-1" type="button" onclick="submitTax()">Submit</button>
                        <button class="btn btn-secondary" onclick="closetaxModel()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function closetaxModel() {
        $("#taxModel").modal('hide');
        $("#taxModelForm")[0].reset()
    }

    function submitTax() {
        var myForm = $('form#taxModelForm')
        if (!myForm[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            // $myForm.find(':submit').click();
            myForm[0].reportValidity();
            return false;
        }
        let token = "{{ csrf_token() }}";
        let url = "{{ url('/quote/tax/insert/ajax') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: $('#taxModelForm').serialize(),
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
                            $('#taxerror').append('<div class="alert alert-danger">' +
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
                    $('.tax').select2({
                        placeholder: "Select",
                        data: data
                    });
                    iziToast.success({
                        title: 'Success',
                        message: "Tax is added successfully",
                        position: 'topRight'
                    });
                    closetaxModel();
                    $('html, body').animate({
                        scrollTop: $("#subject").offset().top
                    }, 1000);
                }
            }
        });
    }
</script>
