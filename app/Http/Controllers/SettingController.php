<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function listTax()
    {
        return view('user.tax.list', ['tax' => Tax::where('business_id', Auth::user()->business->id)->get()]);
    }

    public function addTax()
    {
        return view('user.tax.add');
    }

    public function insertTax(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'rate' => 'required',
        ]);
        $response = Tax::insert([
            'business_id' => Auth::user()->business->id,
            'name' => $request->name,
            'rate' => $request->rate,
            'is_compound' => (!empty($request->iscompound)) ? $request->iscompound : 0,
        ]);
        if ($response) {
            return redirect()->route('tax.add')->with('success', 'Data is saved successfully');
        } else {
            return redirect()->route('tax.add')->with('error', 'Something wwnt wrong');
        }

    }

    public function editTax($id)
    {
        return view('user.tax.edit', ['tax' => Tax::findorFail($id)]);
    }

    public function updateTax(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'rate' => 'required',
        ]);
        $tax = Tax::find($id);
        $tax->business_id = Auth::user()->business->id;
        $tax->name = $request->name;
        $tax->rate = $request->rate;
        $tax->is_compound = (!empty($request->iscompound)) ? $request->iscompound : 0;
        $response = $tax->save();
        if ($response) {
            return redirect()->route('tax.edit', $id)->with('success', 'Data is saved successfully');
        } else {
            return redirect()->route('tax.edit', $id)->with('error', 'Something wwnt wrong');
        }

    }

    public function deleteTax($id)
    {
        if (Tax::destroy($id)) {
            $output = ['type' => 1, 'msg' => 'Data is deleted'];
        } else {
            $output = ['type' => 0, 'msg' => 'Something went wrong'];
        }
        return response()->json($output);
    }
}
