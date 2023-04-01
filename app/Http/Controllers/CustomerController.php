<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerContactPerson;
use App\Models\CustomerOtherDetail;
use App\Models\Salutation;
use App\Models\Tax;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::select('*', 'customers.id AS customersid')
            ->join('businesses', 'businesses.id', '=', 'customers.business_id')
            ->where('customers.business_id', Auth::user()->business->id)
            ->get();
        return view('user.customer.list', ['customer' => $customer]);
    }

    public function add()
    {
        // dd(Auth::guard('web')->user()->business()->currency_id);
        $salutation = Salutation::all();
        $country = Country::all();
        $currency = Currency::all();
        $tax = Tax::where('business_id', Auth::user()->business->id)->get();
        return view('user.customer.add', [
            'salutation' => $salutation,
            'country' => $country,
            'currency' => $currency,
            'tax' => $tax,
        ]);
    }

    public function insert(Request $request)
    {
        $this->validate($request, [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'display_name' => 'required',
        ]);
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

        if ($request->contact_email[0] != null) {
            $customerContactAddressData = [];
            for ($i = 0; $i < count($request->contact_email); $i++) {
                $customerContactAddressData[$i] = [
                    'customer_id' => $customer->id,
                    'salutation_id' => $request->contact_salutation[$i],
                    'first_name' => $request->contact_first_name[$i],
                    'last_name' => $request->contact_last_name[$i],
                    'email' => $request->contact_email[$i],
                    'contact_phone' => $request->contact_phone_no[$i],
                    'contact_mobile' => $request->contact_mobile[$i],
                    'skype' => $request->contact_skype[$i],
                    'designation' => $request->contact_designation[$i],
                    'department' => $request->contact_department[$i],
                ];

            }
            $contactPerson = CustomerContactPerson::insert($customerContactAddressData);
        }

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

        if ($customer && $customerDetail && $billingaddress && $shippingaddress || $contactPerson) {
            DB::commit();
            return redirect()->route('customer.add')->with('success', 'Data is saved successfully');
        } else {
            DB::rollback();
            return redirect()->route('customer.add')->with('error', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        if (Customer::destroy($id)) {
            $output = ['type' => 1, 'msg' => 'Data is deleted'];
        } else {
            $output = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        return response()->json($output);
    }

    public function contactDelete($id)
    {
        if (CustomerContactPerson::destroy($id)) {
            $output = ['type' => 1, 'msg' => 'Data is deleted'];
        } else {
            $output = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        return response()->json($output);
    }

    public function edit($id)
    {
        $salutation = Salutation::all();
        $country = Country::all();
        $currency = Currency::all();
        $tax = Tax::where('business_id', Auth::user()->business->id)->get();

        $customer = Customer::findorFail($id);
        $customerotherdetail = CustomerOtherDetail::where('customer_id', $id)->first();
        $customeraddress = CustomerAddress::where('customer_id', $id)->get();
        $customercontactperson = CustomerContactPerson::where('customer_id', $id)->get();

        return view('user.customer.edit', [
            'salutation' => $salutation,
            'country' => $country,
            'currency' => $currency,
            'tax' => $tax,
            'customer' => $customer,
            'customerotherdetail' => $customerotherdetail,
            'customercontactperson' => $customercontactperson,
            'customeraddress' => $customeraddress,
        ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'display_name' => 'required',
        ]);
        DB::beginTransaction();
        // customer detail
        $customer = Customer::findorFail($id)->update([
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

        //customer other detail
        $customerDetail = CustomerOtherDetail::findorFail($request->customerotherdetailid)->update([
            'currency_id' => $request->currency,
            'tax_id' => $request->tax,
            'opening_balance' => $request->opening_balance,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
        ]);

        //customer contact address
        if ($request->contact_email[0] != null) {
            $customerContactAddressData = [];
            for ($i = 0; $i < count($request->contact_email); $i++) {
                $customerContactAddressData[$i] = [
                    'customer_id' => $id,
                    'salutation_id' => $request->contact_salutation[$i],
                    'first_name' => $request->contact_first_name[$i],
                    'last_name' => $request->contact_last_name[$i],
                    'email' => $request->contact_email[$i],
                    'contact_phone' => $request->contact_phone_no[$i],
                    'contact_mobile' => $request->contact_mobile[$i],
                    'skype' => $request->contact_skype[$i],
                    'designation' => $request->contact_designation[$i],
                    'department' => $request->contact_department[$i],
                ];
            }
            CustomerContactPerson::where('customer_id', $id)->delete();
            $contactPerson = CustomerContactPerson::insert($customerContactAddressData);
        }

        //customer contact address billing address
        $billingaddress = CustomerAddress::findorFail($request->customeraddressbilling)->update([
            'attention' => $request->b_attention,
            'country_id' => $request->b_country,
            'address' => $request->b_address,
            'city' => $request->b_city,
            'state' => $request->b_state,
            'zip' => $request->b_zipcode,
            'mobile' => $request->b_mobile,
            'fax' => $request->b_fax,
        ]);

        //customer contact address shipping address
        $shippingaddress = CustomerAddress::findorFail($request->customeraddressshipping)->update([

            'attention' => $request->shipping_attention,
            'country_id' => $request->shipping_country,
            'address' => $request->shipping_address,
            'city' => $request->shipping_city,
            'state' => $request->shipping_state,
            'zip' => $request->shipping_zipcode,
            'mobile' => $request->shipping_mobile,
            'fax' => $request->shipping_fax,
        ]);

        if ($customer && $customerDetail && $billingaddress && $shippingaddress || $contactPerson) {
            DB::commit();
            return redirect()->route('customer.edit', $id)->with('success', 'Data is updated successfully');
        } else {
            DB::rollback();
            return redirect()->route('customer.edit', $id)->with('error', 'Something went wrong');
        }

    }
}
