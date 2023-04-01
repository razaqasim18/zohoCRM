<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\Item;
use App\Models\Tax;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $item = Item::select("*", 'items.id AS itemid')
            ->join('account_types', 'account_types.id', '=', 'items.account_type_id')
            ->leftJoin('units', 'units.id', '=', 'items.unit_id')
            ->where("business_id", Auth::guard('web')->user()->business->id)
            ->get();
        return view('user.item.list', ['item' => $item]);
    }
    public function add()
    {
        $unit = Unit::all();
        $account = AccountType::all();
        $tax = Tax::where('business_id', Auth::guard('web')->user()->business->id)->get();
        return view('user.item.add', ['unit' => $unit, "account" => $account, 'tax' => $tax]);
    }
    public function insert(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'unit_id' => 'required',
            'selling_price' => 'required',
            'account_type_id' => 'required',
            'tax_id' => 'required',
        ]);
        $item = new Item();
        $item->business_id = Auth::guard('web')->user()->business->id;
        $item->name = $request->name;
        $item->unit_id = $request->unit_id;
        $item->selling_price = $request->selling_price;
        $item->account_type_id = $request->account_type_id;
        $item->tax_id = $request->tax_id;
        $item->description = $request->description;
        $item->is_service = $request->is_service;

        if ($item->save()) {
            return redirect()->route('item.add')->with('success', 'Data is saved successfully');
        } else {
            return redirect()->route('item.add')->with('error', 'Something went wrong');
        }
    }
    public function edit($id)
    {
        $unit = Unit::all();
        $account = AccountType::all();
        $tax = Tax::where('business_id', Auth::guard('web')->user()->business->id)->get();
        $item = Item::findorFail($id);
        return view('user.item.edit', ['unit' => $unit, "account" => $account, "tax" => $tax, "item" => $item]);
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'unit_id' => 'required',
            'selling_price' => 'required',
            'account_type_id' => 'required',
            'tax_id' => 'required',
        ]);
        $item = Item::findorFail($id);
        $item->name = $request->name;
        $item->unit_id = $request->unit_id;
        $item->selling_price = $request->selling_price;
        $item->account_type_id = $request->account_type_id;
        $item->tax_id = $request->tax_id;
        $item->description = $request->description;
        $item->is_service = $request->is_service;

        if ($item->save()) {
            return redirect()->route('item.edit', $id)->with('success', 'Data is updated successfully');
        } else {
            return redirect()->route('item.add', $id)->with('error', 'Something went wrong');
        }
    }
    public function delete($id)
    {
        if (Item::destroy($id)) {
            $output = ['type' => 1, 'msg' => 'Data is deleted'];
        } else {
            $output = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        return response()->json($output);
    }
}
