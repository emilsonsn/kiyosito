<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\CoinHistory;
use App\Models\Phase;
use Illuminate\Http\Request;

class ManageICOController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage ICO';
        $phases    = Phase::dateFilter()->paginate(getPaginate());
        return view('admin.ico.index', compact('pageTitle', 'phases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'end_date'   => 'required|date_format:Y-m-d|after:start_date',
            'coin_token' => 'required|numeric',
            'price'      => 'required|numeric|gt:0',
            'softcap_price' => 'required|numeric|min:0.01',
            'softcap_label' => 'required|string|max:255',
            'softcap_label_2' => 'required|string|max:255',
            'hardcap_price' => 'required|numeric|min:0.01',
            'hardcap_label' => 'required|string|max:255',
            'hardcap_label_2' => 'required|string|max:255',
        ]);

        $phase = Phase::whereDate('end_date', '>', $request->start_date)->first();
        $phaseStage = Phase::count();

        if ($phase) {
            $notify[] = ['error', 'Please change the time schedule, because ICO phase already exists!'];
            return back()->withNotify($notify);
        }

        $phase = new Phase();
        $phase->start_date = $request->start_date;
        $phase->end_date   = $request->end_date;
        $phase->total_coin = $request->coin_token;
        $phase->coin_token = $request->coin_token;
        $phase->price      = $request->price;
        $phase->softcap_price = $request->softcap_price;
        $phase->softcap_label = $request->softcap_label;
        $phase->softcap_label_2 = $request->softcap_label_2;
        $phase->hardcap_price = $request->hardcap_price;
        $phase->hardcap_label = $request->hardcap_label;
        $phase->hardcap_label_2 = $request->hardcap_label_2;
        $phase->stage      = ordinal($phaseStage + 1);
        $phase->save();

        $notify[] = ['success', 'ICO Phase created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'         => 'required|integer',
            'price'      => 'required|numeric|gt:0',
            'coin_token' => 'nullable|numeric|gt:0',
            'softcap_price' => 'nullable|numeric|min:0.01',
            'softcap_label' => 'nullable|string|max:255',
            'softcap_label_2' => 'nullable|string|max:255',
            'hardcap_price' => 'nullable|numeric|min:0.01',
            'hardcap_label' => 'nullable|string|max:255',
            'hardcap_label_2' => 'nullable|string|max:255',
        ]);

        $phase = Phase::findOrFail($request->id);

        if ($request->coin_token) {
            $phase->total_coin += $request->coin_token;
            $phase->coin_token += $request->coin_token;
        }

        $phase->price = $request->price;

        // Update Softcap fields if provided
        if ($request->has('softcap_price')) {
            $phase->softcap_price = $request->softcap_price;
        }
        if ($request->has('softcap_label')) {
            $phase->softcap_label = $request->softcap_label;
        }
        if ($request->has('softcap_label_2')) {
            $phase->softcap_label_2 = $request->softcap_label_2;
        }

        // Update Hardcap fields if provided
        if ($request->has('hardcap_price')) {
            $phase->hardcap_price = $request->hardcap_price;
        }
        if ($request->has('hardcap_label')) {
            $phase->hardcap_label = $request->hardcap_label;
        }
        if ($request->has('hardcap_label_2')) {
            $phase->hardcap_label_2 = $request->hardcap_label_2;
        }

        $phase->save();

        $notify[] = ['success', 'ICO phase updated successfully'];
        return back()->withNotify($notify);
    }

    public function detail($slug)
    {
        $general       = gs();
        $pageTitle     = $general->coin_text  .' '. keyToTitle($slug) .' '.'Stage Sale History';
        $coinHistories = CoinHistory::with('user')->orderBy('id', 'desc')->searchable(['user:username'])->where('is_coin_purchase', Status::YES)->paginate(getPaginate());
        return view('admin.ico.detail', compact('pageTitle', 'coinHistories'));
    }

    public function upcoming()
    {
        $pageTitle = 'Upcoming ICO';
        $phases    = Phase::upcoming()->dateFilter('start_date')->paginate(getPaginate());
        return view('admin.ico.index', compact('pageTitle', 'phases'));
    }
}