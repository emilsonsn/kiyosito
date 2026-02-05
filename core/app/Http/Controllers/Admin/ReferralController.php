<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle       = 'Manage Referrals';
        $referrals       = Referral::get();
        return view('admin.referral.index', compact('pageTitle', 'referrals'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'percent'  => 'required',
            'percent*' => 'required|numeric',
        ]);
        Referral::where('status', Status::ENABLE)->delete();
        for ($i = 0; $i < count($request->percent); $i++) {
            $referral          = new Referral();
            $referral->level   = $i + 1;
            $referral->percent = $request->percent[$i];
            $referral->status  = 1;
            $referral->save();
        }
        $notify[] = ['success', 'Referral commission setting updated successfully'];
        return back()->withNotify($notify);
    }

 

}
