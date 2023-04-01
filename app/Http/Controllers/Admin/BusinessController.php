<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $customers = User::select('*', 'users.id AS userid')->join('businesses', 'businesses.user_id', '=', 'users.id')->where('is_business_admin', '1')->get();
        return view('admin.business.business_admin_list', ['customers' => $customers]);
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $text = ($status) ? 'User is blocked successfully' : 'User is un-blocked successfully';
        $user = User::findorFail($id);
        $response = $user->update(['is_blocked' => $status]);
        if ($response) {
            responseGenerate(1, $text);
        } else {
            responseGenerate(0, 'Someng went wrong');
        }
    }
}
