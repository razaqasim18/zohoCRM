<!-- Large modal -->
<div id="salepersonModel" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Sale Person</h5>
                <button type="button" class="close" onclick="closeSalePerson()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="salepersonerror"></div>
                <form id="salepersonModelForm">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name">Name</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" value=""
                                required="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name">Email</label>
                            <span class="text-danger">*</span>
                            <input type="email" class="form-control" name="email" id="email" value=""
                                required="">
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary mr-1" type="button" onclick="submitSalePerson()">Submit</button>
                        <button class="btn btn-secondary" onclick="closeSalePerson()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function closeSalePerson() {
        $("#salepersonModel").modal('hide');
        $("#salepersonModelForm")[0].reset()
    }

    function submitSalePerson() {
        var myForm = $('form#salepersonModelForm')
        if (!myForm[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            // $myForm.find(':submit').click();
            myForm[0].reportValidity();
            return false;
        }
        let token = "{{ csrf_token() }}";
        let url = "{{ url('/quote/saleperson/insert/ajax') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: $('#salepersonModelForm').serialize(),
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
                            $('#salepersonerror').append('<div class="alert alert-danger">' +
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
                    $('#sales_person_id').select2({
                        data: data
                    });
                    iziToast.success({
                        title: 'Success',
                        message: "Customer is added successfully",
                        position: 'topRight'
                    });
                    $('#salepersonModelForm')[0].reset();
                    $('#salepersonModel').modal('hide');
                }
            }
        });
    }
</script>
