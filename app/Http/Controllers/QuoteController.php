<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerOtherDetail;
use App\Models\Item;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\SalesPerson;
use App\Models\Tax;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    public function index()
    {
        $quote = Quote::select('*', 'quotes.id AS quotesid')->join('customers', 'customers.id', '=', 'quotes.customer_id')
            ->where('quotes.business_id', Auth::user()->business->id)
            ->orderBy('quotes.id', 'DESC')->get();
        return view('user.quote.list', ['quote' => $quote]);
    }

    public function add()
    {
        // $customer = Customer::where('business_id', Auth::user()->business->id)->get();
        // $salesperson = SalesPerson::where('business_id', Auth::user()->business->id)->get();
        $item = Item::where('business_id', Auth::user()->business->id)->get();
        $tax = Tax::where('business_id', Auth::user()->business->id)->get();

        return view('user.quote.add', [
            // 'customer' => $customer,
            // 'salesperson' => $salesperson,
            'item' => $item,
            'tax' => $tax,
        ]);
    }

    public function getItemDetail($id)
    {
        $item = Item::findorFail($id);
        $tax = Tax::where('business_id', Auth::user()->business->id)->get();
        $amount = $item->selling_price * 1;
        $output = '';
        // $output .= "<tr>";
        $output .= "<td><input type='hidden' id='items_id' class='items_id' name='items_id[]' value='" . $item->id . "' /><input type='text' id='item_name' class='form-control item_name' value='" . $item->name . "' readonly/></td>";
        $output .= "<td><input type='number' id='quantity' class='form-control quantity' name='quantity[]' value='1' min='1' required/></td>";
        $output .= "<td><input type='number' id='rate' class='form-control rate' name='rate[]' min='1' value='" . $item->selling_price . "' required/></td>";
        $output .= '<td><select id="tax" name="tax[]" class="form-control select2 selecttax">';
        $calculatedtax = 0;
        $taxname = '';
        $taxid = '';

        foreach ($tax as $row) {
            if ($row->id == $item->tax_id) {
                $taxid = Str::random(9);
                $rowid = "taxrow" . $taxid;
                $taxname = $row->name . " [" . $row->rate . "]";
                $calculatedtax = $amount * ($row->rate / 100);
                $taxrate = $row->rate;
            }
            $output .= "<option value='" . $row->id . "'";
            if ($row->id == $item->tax_id) {$output .= 'selected';}
            $output .= ">" . $row->name . " [" . $row->rate . "]" . "</option>";
        }
        $output .= "</select>";
        $output .= "<input type='hidden' class='form-control taxvalue'  value='" . $taxrate . "' readonly /><input type='hidden' class='form-control taxid'  value='" . $taxid . "' readonly /></td>";
        $output .= "<td><input type='text' id='amount' class='form-control inputamount' name='amount[]' value='" . $amount . "' readonly /></td>";
        $output .= '<td style="display:flex"><button type="button" class="btn btn-primary btn-sm m-1" id="addnewitem"><i class="fa fa-plus"></i></button>';
        $output .= '<button type="button" class="btn btn-danger btn-sm m-1" id="removenewitem"><i class="fa fa-minus"></i></button></td>';
        // $output .= "</tr>";
        $taxoutput = "";
        $taxoutput .= "<div class='form-row' id='" . $rowid . "'>";
        $taxoutput .= "<div class='form-group col-md-8'>";
        $taxoutput .= "<h5> " . $taxname . " </h5></div>";
        $taxoutput .= "<div class='form-group col-md-4 text-right'>";
        $taxoutput .= "<h4> " . $calculatedtax . " </h4><input type='hidden' class='form-control calculatedtax'  value='" . $calculatedtax . "' readonly /></div>";
        $response = [
            'htmloutput' => $output,
            'taxoutput' => $taxoutput,
        ];
        return response()->json($response);
        // return response()->json($item);
    }

    public function insert(Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'quote_number' => 'required',
            'quote_date' => 'required',
        ]);
        DB::beginTransaction();

        $images = null;

        // $tax = null;
        // if (!empty($request->tax_id)) {
        //     $tax = explode("|", $request->tax_id)[0];
        // }

        $quote = new Quote();
        $quote->business_id = Auth::user()->business->id;
        $quote->sales_person_id = $request->sales_person_id;
        $quote->customer_id = $request->customer_id;
        // $quote->tax_id = $tax;
        $quote->quote_number = $request->quote_number;
        $quote->reference_number = $request->reference_number;
        $quote->quote_date = $request->quote_date;
        $quote->expiry_date = $request->expiry_date;
        $quote->subject = $request->subject;
        $quote->note = $request->note;
        $quote->terms_condition = $request->terms_condition;
        $quote->image = $images;
        $quote->sub_total = $request->sub_total;
        $quote->discount = $request->discount;
        $quote->discount_is_percentage = $request->discountopt;
        $quote->shipping_charges = $request->shipping_charges;
        $quote->adjustment_name = $request->adjustment_name;
        $quote->adjustment_value = $request->adjustment_name_value;
        $quote->total_amount = $request->total_amount;
        $quoteresponse = $quote->save();

        if ($images = $request->file('image')) {
            foreach ($images as $image) {
                $quote->addMedia($image)->toMediaCollection('quotes');
            }
        }

        if ($request->items_id[0] != null) {
            for ($i = 0; $i < count($request->items_id); $i++) {
                $quoteresponse = QuoteItem::insert([
                    "quote_id" => $quote->id,
                    "item_id" => $request->items_id[$i],
                    "tax_id" => $request->tax[$i],
                    "rate" => $request->rate[$i],
                    "quantity" => $request->quantity[$i],
                    "amount" => $request->amount[$i],
                ]);
            }
        } else {
            $quoteresponse = 1;
        }

        if ($quoteresponse && $quoteresponse) {
            DB::commit();
            return redirect()->route('quote.add')->with('success', 'Data is saved successfully');
        } else {
            DB::rollback();
            return redirect()->route('quote.add')->with('error', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        $resposne = Quote::destroy($id);
        if ($resposne) {
            $output = ['type' => 1, 'msg' => 'Data is deleted'];
        } else {
            $output = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        return response()->json($output);
    }

    public function itemDelete($id)
    {
        if (QuoteItem::destroy($id)) {
            $output = ['type' => 1, 'msg' => 'Data is deleted'];
        } else {
            $output = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        return response()->json($output);
    }

    public function edit($id)
    {

        $customer = Customer::where('business_id', Auth::user()->business->id)->get();
        $salesperson = SalesPerson::where('business_id', Auth::user()->business->id)->get();
        $allitem = Item::where('business_id', Auth::user()->business->id)->get();
        $tax = Tax::where('business_id', Auth::user()->business->id)->get();
        $quote = Quote::findorFail($id);
        $itemquote = QuoteItem::select('*', 'quote_items.id AS quoteid', 'items.id AS itemsid', 'items.name AS itemsname', 'quote_items.tax_id AS taxid')->join('items', 'items.id', '=', 'quote_items.item_id')->where('quote_id', $id)->get();
        return view('user.quote.edit', [
            'customer' => $customer,
            'salesperson' => $salesperson,
            'allitem' => $allitem,
            'tax' => $tax,
            'quote' => $quote,
            'itemquote' => $itemquote,
        ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'customer_id' => 'required',
            'quote_number' => 'required',
            'quote_date' => 'required',
        ]);

        DB::beginTransaction();
        $images = null;

        // $tax = null;
        // if (!empty($request->tax_id)) {
        //     $tax = explode("|", $request->tax_id)[0];
        // }

        $quote = Quote::find($id);
        $quote->business_id = Auth::user()->business->id;
        $quote->sales_person_id = $request->sales_person_id;
        $quote->customer_id = $request->customer_id;
        // $quote->tax_id = $tax;
        $quote->quote_number = $request->quote_number;
        $quote->reference_number = $request->reference_number;
        $quote->quote_date = $request->quote_date;
        $quote->expiry_date = $request->expiry_date;
        $quote->subject = $request->subject;
        $quote->note = $request->note;
        $quote->terms_condition = $request->terms_condition;
        $quote->image = $images;
        $quote->sub_total = $request->sub_total;
        $quote->discount = $request->discount;
        $quote->discount_is_percentage = $request->discountopt;
        $quote->shipping_charges = $request->shipping_charges;
        $quote->adjustment_name = $request->adjustment_name;
        $quote->adjustment_value = $request->adjustment_name_value;
        $quote->total_amount = $request->total_amount;
        $quoteresponse = $quote->save();

        if ($images = $request->file('image')) {
            $quote->clearMediaCollection('image');
            foreach ($images as $image) {
                $quote->addMedia($image)->toMediaCollection('quotes');
            }
        }

        if ($request->items_id[0] != null) {
            QuoteItem::where('quote_id', $id)->delete();
            for ($i = 0; $i < count($request->items_id); $i++) {
                $quoteresponse = QuoteItem::insert([
                    "quote_id" => $id,
                    "item_id" => $request->items_id[$i],
                    "tax_id" => $request->tax[$i],
                    "rate" => $request->rate[$i],
                    "quantity" => $request->quantity[$i],
                    "amount" => $request->amount[$i],
                ]);
            }
        } else {
            $quoteresponse = 1;
        }

        if ($quoteresponse && $quoteresponse) {
            DB::commit();
            return redirect()->route('quote.edit', $id)->with('success', 'Data is updated successfully');
        } else {
            DB::rollback();
            return redirect()->route('quote.edit', $id)->with('error', 'Something went wrong');
        }

    }

    public function cloned($id)
    {
        $oldquote = Quote::find($id);
        $oldquoteitem = QuoteItem::where('quote_id', $id)->get();

        DB::beginTransaction();
        $quote = new Quote;
        $quote->business_id = $oldquote->business_id;
        $quote->sales_person_id = $oldquote->sales_person_id;
        $quote->customer_id = $oldquote->customer_id;
        $quote->tax_id = $oldquote->tax_id;
        $quote->quote_number = getUniqueEstimateID();
        $quote->reference_number = $oldquote->reference_number;
        $quote->quote_date = $oldquote->quote_date;
        $quote->expiry_date = $oldquote->expiry_date;
        $quote->subject = $oldquote->subject;
        $quote->note = $oldquote->note;
        $quote->terms_condition = $oldquote->terms_condition;
        $quote->image = $oldquote->image;
        $quote->sub_total = $oldquote->sub_total;
        $quote->discount = $oldquote->discount;
        $quote->discount_is_percentage = $oldquote->discount_is_percentage;
        $quote->shipping_charges = $oldquote->shipping_charges;
        $quote->adjustment_name = $oldquote->adjustment_name;
        $quote->adjustment_value = $oldquote->adjustment_value;
        $quote->total_amount = $oldquote->total_amount;
        $quoteresponse = $quote->save();

        if (count($oldquoteitem)) {
            for ($i = 0; $i < count($oldquoteitem); $i++) {
                $quoteresponse = QuoteItem::insert([
                    "quote_id" => $quote->id,
                    "item_id" => $oldquoteitem[$i]->item_id,
                    "tax_id" => $oldquoteitem[$i]->tax_id,
                    "rate" => $oldquoteitem[$i]->rate,
                    "quantity" => $oldquoteitem[$i]->quantity,
                    "amount" => $oldquoteitem[$i]->amount,
                ]);
            }
        } else {
            $quoteresponse = '1';
        }

        if ($quoteresponse && $quoteresponse) {
            DB::commit();
            return redirect()->route('quote.list')->with('success', 'Data is cloned successfully');
        } else {
            DB::rollback();
            return redirect()->route('quote.edit')->with('error', 'Something went wrong');
        }
    }

    public function insertCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:customers',
            'display_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'type' => 0,
                'validator_error' => 1,
                'errors' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        $customer = Customer::create([
            'business_id' => Auth::user()->business->id,
            'is_business' => $request->is_business,
            'salutation_id' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'display_name' => $request->display_name,
            'mobile' => $request->customer_mobile,
            'company_name' => $request->company_name,
            'phone' => $request->customer_phone,
            'designation' => $request->designation,
            'department' => $request->department,
            'skype' => $request->skype,
            'website' => $request->website,
            'remarks' => $request->remarks,
        ]);

        $customerDetail = CustomerOtherDetail::insert([
            'customer_id' => $customer->id,
            'currency_id' => $request->currency,
            'tax_id' => $request->tax,
            'opening_balance' => $request->opening_balance,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
        ]);

        //customer contact address billing address
        $billingaddress = CustomerAddress::insert([
            'customer_id' => $customer->id,
            'attention' => $request->b_attention,
            'country_id' => $request->b_country,
            'address' => $request->b_address,
            'city' => $request->b_city,
            'state' => $request->b_state,
            'zip' => $request->b_zipcode,
            'mobile' => $request->b_mobile,
            'fax' => $request->b_fax,
            'is_shipping' => 0,
        ]);

        //customer contact address shipping address
        $shippingaddress = CustomerAddress::insert([
            'customer_id' => $customer->id,
            'attention' => $request->shipping_attention,
            'country_id' => $request->shipping_country,
            'address' => $request->shipping_address,
            'city' => $request->shipping_city,
            'state' => $request->shipping_state,
            'zip' => $request->shipping_zipcode,
            'mobile' => $request->shipping_mobile,
            'fax' => $request->shipping_fax,
            'is_shipping' => 1,
        ]);

        if ($customer && $customerDetail && $billingaddress && $shippingaddress) {
            DB::commit();
            return response()->json(['type' => 1, 'data' => Customer::select('id', 'display_name AS text')->where("business_id", Auth::guard('web')->user()->business->id)->get()]);
        } else {
            DB::rollback();
            return response()->json(['type' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function insertSaleperson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:sales_people',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'type' => 0,
                'validator_error' => 1,
                'errors' => $validator->errors(),
            ]);
        }

        $saleperson = new SalesPerson;
        $saleperson->business_id = Auth::guard('web')->user()->business->id;
        $saleperson->name = $request->name;
        $saleperson->email = $request->email;

        if ($saleperson->save()) {
            return response()->json(['type' => 1, 'data' => SalesPerson::select('id', 'name AS text')->where("business_id", Auth::guard('web')->user()->business->id)->get()]);
        } else {
            return response()->json(['type' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function insertItem(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'unit_id' => 'required',
            'selling_price' => 'required',
            'model_account_type_id' => 'required',
            'model_tax_id' => 'required',
        ]);
        $item = new Item();
        $item->business_id = Auth::guard('web')->user()->business->id;
        $item->name = $request->name;
        $item->unit_id = $request->model_unit_id;
        $item->selling_price = $request->selling_price;
        $item->account_type_id = $request->model_account_type_id;
        $item->tax_id = $request->model_tax_id;
        $item->description = $request->description;
        $item->is_service = $request->is_service;

        if ($item->save()) {
            return response()->json(['type' => 1, 'data' => Item::select('id', 'name AS text')->where("business_id", Auth::guard('web')->user()->business->id)->get()]);
        } else {
            return response()->json(['type' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function insertTax(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'rate' => 'required',
        ]);
        $tax = new Tax;
        $tax->business_id = Auth::guard('web')->user()->business->id;
        $tax->name = $request->name;
        $tax->rate = $request->rate;
        $tax->is_compound = (!empty($request->iscompound)) ? $request->iscompound : 0;
        if ($tax->save()) {
            return response()->json(['type' => 1, 'data' => Tax::select(DB::raw('CONCAT(name," [",rate,"]") AS text'), 'id')->where("business_id", Auth::guard('web')->user()->business->id)->get()]);
        } else {
            return response()->json(['type' => 0, 'msg' => 'Something went wrong']);
        }

    }
}
