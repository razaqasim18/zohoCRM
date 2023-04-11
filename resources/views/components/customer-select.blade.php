<div>
    <label for="customer_id">Customer</label> <span class="text-danger">*</span>
    <select id="customer_id" name="customer_id" class="form-control select2" style="width: 100%" required>
        <option value="">Select option</option>
        @foreach ($customer as $row)
            <option value="{{ $row->id }}" @if ($selectedid && $selectedid == $row->id) selected @endif>
                {{ $row->display_name }}
            </option>
        @endforeach
    </select>
</div>
