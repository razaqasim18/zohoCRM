<?php

namespace App\Http\Controllers;

use App\Models\SalesPerson;
use Auth;
use Illuminate\Http\Request;

class SalePersonController extends Controller
{
    public function index()
    {
        $saleperson = SalesPerson::all();
        return view('user.salesperson.list', ['saleperson' => $saleperson]);
    }
    public function add()
    {
        return view('user.salesperson.add');
    }
    public function insert(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:sales_people',
        ]);
        $saleperson = new SalesPerson;
        $saleperson->business_id = Auth::guard('web')->user()->business->id;
        $saleperson->name = $request->name;
        $saleperson->email = $request->email;

        if ($saleperson->save()) {
            return redirect()->route('sale.person.add')->with('success', 'Data is saved successfully');
        } else {
            return redirect()->route('sale.person.add')->with('error', 'Something went wrong');
        }
    }
    public function edit($id)
    {
        $saleperson = SalesPerson::findorFail($id);
        return view('user.salesperson.edit', ['saleperson' => $saleperson]);
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $saleperson = SalesPerson::findorFail($id);
        $saleperson->business_id = Auth::guard('web')->user()->business->id;
        $saleperson->name = $request->name;
        $saleperson->email = $request->email;

        if ($saleperson->save()) {
            return redirect()->route('sale.person.edit', $id)->with('success', 'Data is updated successfully');
        } else {
            return redirect()->route('sale.person.add', $id)->with('error', 'Something went wrong');
        }
    }
    public function delete($id)
    {
        if (SalesPerson::destroy($id)) {
            $output = ['type' => 1, 'msg' => 'Data is deleted'];
        } else {
            $output = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        return response()->json($output);
    }
}
