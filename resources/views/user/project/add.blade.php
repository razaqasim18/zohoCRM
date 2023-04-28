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
                            <h4>New Project</h4>
                            <div class="card-header-action">
                                <a href="{{ route('project.list') }}" class="btn btn-primary">
                                    All Projects
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
                                    <label for="pname">Project Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="pname">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pcode">Project Code</label>
                                    <input type="text" class="form-control" id="pcode">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" name="note" id="desc" rows="3" style="height: 125px !important;"> {{ old('note') }}</textarea>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cname">Customer Name</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control select2 item_id" id="cname">
                                        <option value="" selected disabled></option>
                                        <option value=""><i class="fa fa-plus"></i>New Customer</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bmethod">Billing Method</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control select2 item_id" id="cname">
                                        <option value="" selected disabled></option>
                                        <option>Fixed cost for project</option>
                                        <option>Based on projects hours</option>
                                        <option>Based on task hours</option>
                                        <option>Based on staff hours</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cbudg">Cost Budget</label>
                                    <input type="number" name="" id="cname" placeholder="PKR" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="bmethod">Revenue Budget</label>
                                    <input type="number" name="" id="cname" placeholder="PKR" class="form-control">
                                </div>
                            </div>


                        </div>

                    </div>



                </form>

            </div>
        </div>
    </div>
</section>

<div class="card">
    <div class="card-header">
        <h4>Users
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered table-sm" id="table-1" style="width:100%;">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th>S.No</th>
                        <th>User</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td> 1 </td>
                        <td> John Doe </td>
                        <td> john@gmail.com </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Project Tasks
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="table-1" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col" width="20%">S.No</th>
                        <th scope="col" width="26%">Task Name</th>
                        <th scope="col" width="26%">Description</th>
                        <th scope="col" width="20%">Billable</th>
                        <th scope="col" width="8%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            1
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Task Name">
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Description">
                        </td>
                        <td>
                            <div class="form-group d-flex justify-content-center mt-2">
                                <input type="checkbox" name="" id="" class="">
                            </div>
                        </td>
                        <td style="text-align: center;vertical-align: middle;">
                            <button type="button" class="btn btn-primary btn-sm m1 " id="addnewitem">
                                <i class="fa fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <input type="checkbox" name="" id="wlist"> <label for="wlist" class="mb-2">Add to the watchlist on my dashboard</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/page/advance-table.js') }}"></script>

<script>
    $(document).ready(function() {
                $('#file-list').on('change', function() {
                    var files = $(this).prop('files');
                    $('#file-list').empty();
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        var $fileElement = $('<div class="file"><div class="file-name"></div><div class="remove-file">&#10006;</div></div>');
                        $fileElement.find('.file-name').text(file.name);
                        $fileElement.data('file', file);
                        $('#file-list').append($fileElement);
                    }
                });
                $(document).on('click', '.remove-file', function() {
                    var $fileElement = $(this).closest('.file');
                });
</script>

<script>
    // popup on select option
    // Get the select input element
    var select = document.getElementById("mySelect");

    // Add event listener for changes to the select input
    select.addEventListener("change", function() {
        // Get the selected option
        var selectedOption = select.value;

        // If the selected option is "option1", open the modal
        if (selectedOption === "option1") {
            $('#myModal').modal('show');
        }
    });
</script>

<script>
    function handleFileSelect(event) {
        const files = event.target.files;
        const fileList = document.getElementById("file-list");
        fileList.innerHTML = ""; // clear previous file list

        // iterate through selected files
        for (let i = 0; i < files.length; i++) {

            const file = files[i];
            if (file.size <= 5000000) { // check if file size is within limit
                // create file list item with cancel button
                const li = document.createElement("li");
                const cancelBtn = document.createElement("button");
                cancelBtn.innerText = "x";
                cancelBtn.onclick = function() {
                    fileList.removeChild(li); // remove file list item
                };
                li.innerText = file.name;
                li.appendChild(cancelBtn);
                fileList.appendChild(li);
            }
        }
    }
</script>

@endsection