<div>
    <label for="sales_person_id">Sale Person</label>
    <select id="sales_person_id" name="sales_person_id" class="form-control select2" style="width: 100%">
        <option value="">Select option</option>
        @foreach ($salesperson as $row)
            <option value="{{ $row->id }}" @if ($selectedid && $selectedid == $row->id) selected @endif>
                {{ $row->name }}
            </option>
        @endforeach
    </select>
</div>
