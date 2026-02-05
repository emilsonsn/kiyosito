<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\CoinHistory;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction(Request $request, $userId = null)
    {
        $pageTitle = 'Transaction Logs';

        $remarks = Transaction::whereNotNull('remark')->distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::searchable(['trx', 'user:username'])->filter(['trx_type', 'remark'])->dateFilter()->orderBy('id', 'desc')->with('user');
        if ($userId) {
            $transactions = $transactions->where('user_id', $userId);
        }
        $transactions = $transactions->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::orderBy('id', 'desc')->searchable(['user:username'])->dateFilter()->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs', 'ip'));
    }

    public function notificationHistory(Request $request)
    {
        $pageTitle = 'Notification History';
        $logs = NotificationLog::orderBy('id', 'desc')->searchable(['user:username'])->dateFilter()->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }

    public function auctions()
    {
        $pageTitle = 'Auction History';
        $auctions  = Auction::orderBy('id', 'desc')->searchable(['user:username', 'buyer:username']);
        if (request()->status) {
            $auctions->filter(['status']);
        }
        $auctions = $auctions->dateFilter()->with('user')->paginate(getPaginate());


        return view('admin.reports.auction_history', compact('pageTitle', 'auctions'));
    }

    public function coins()
    {
        $pageTitle     = 'Coin Transaction History';
        $coinHistories = CoinHistory::with('user')->orderBy('id', 'desc')->searchable(['user:username', 'coin_rate', 'amount', 'coin_quantity'])->paginate(getPaginate());
        return view('admin.reports.coin_history', compact('pageTitle', 'coinHistories'));
    }

    public function referralUsers($id)
    {
        $referrer      = User::find($id);
        $pageTitle     = $referrer->fullname . ' ' . 'Referral History';
        $referralUsers = User::where('ref_by', $referrer->id)->orderBy('id', 'desc')->searchable(['username'])->paginate(getPaginate());
        return view('admin.reports.referral_users', compact('pageTitle', 'referralUsers'));
    }
}
