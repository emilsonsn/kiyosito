<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\CoinHistory;
use App\Models\Phase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserCoinController extends Controller
{
    public function index()
    {
        $pageTitle = 'Coin History';
        $histories = CoinHistory::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(getPaginate());
        return view(activeTemplate() . 'user.coin.index', compact('pageTitle', 'histories'));
    }

    public function buy()
    {
        $now = now();
        Log::info('[UserCoinController@buy] Current time: ' . $now);
        
        $phase = Phase::where('start_date', '<=', now())
                      ->where('end_date', '>=', now())
                      ->first();

        if (!$phase) {
            
            $notify[] = ['warning', '🎉 ICO 3rd Phase Completed!'];
            return to_route('user.home')->withNotify($notify);
        }
    
        // return view(activeTemplate() . 'user.coin.react_buy');
        return view(activeTemplate() . 'user.coin.react_buy', [ 'pageTitle' => '']);
    }


    public function buyResponse(Request $response)
    {
        Log::info('[BUY] buyResponse called');

        $quantity = $response->coin_quantity;
        $tx_hash  = $response->tx_hash;

        Log::info('[BUY] $quantity = ' .$quantity);
        Log::info('[BUY] $tx_hash = '.$tx_hash);

        $phase = Phase::whereDate('start_date', '<=', now())
                      ->whereDate('end_date', '>=', now())
                      ->first();
    
        // $amount = $quantity * $phase->price;
        $amount = (float) ($quantity * $phase->price);
        Log::info('[BUY] quantity=' . $quantity . ', phase_price=' . $phase->price);

        $user = auth()->user();
        $general = gs();
    
        // Atualização dos saldos
        // $user->balance      -= $amount;
        // $user->coin_balance += $quantity;
        $user->balance      = (float) $user->balance - $amount;
        $user->coin_balance = (float) $user->coin_balance + $quantity;
        
        
        Log::info('[BUY] Calculated amount: ' . $amount . ', Balance: ' . $user->balance);

        $user->save();
    
        $phase->coin_token -= $quantity;
        $phase->sold       += $quantity;
        $phase->save();
    
        // Transaction sem mass assignment
        $transaction = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $amount;
        $transaction->charge       = 0;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        // $transaction->trx          = getTrx();
        $transaction->trx          = $tx_hash;
        $transaction->remark       = 'coin';
        $transaction->details      = 'Purchased ' . $general->coin_text;
        $transaction->save();
    
        // CoinHistory sem mass assignment
        $history = new CoinHistory();
        $history->user_id           = $user->id;
        $history->type              = '+';
        $history->stage             = $phase->stage;
        $history->coin_rate         = $phase->price;
        $history->coin_quantity     = $quantity;
        $history->amount            = $amount;
        $history->coin_post_balance = $user->coin_balance;
        $history->details           = 'Purchased ' . $general->coin_text;
        $history->is_coin_purchase  = Status::YES;
        $history->save();
    
        // Envio de notificação
        notify($user, 'BUY_CONFIRMATION', [
            'amount'            => showAmount($amount, currencyFormat:false),
            'trx_id'            => $transaction->trx,
            'stage'             => $phase->stage,
            'rate'              => showAmount($phase->price, currencyFormat:false),
            'coin_quantity'     => $quantity,
            'coin_post_balance' => $user->coin_balance,
            'currency'          => $general->cur_text,
            'coin_text'         => $general->coin_text,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => "$quantity {$general->coin_text} purchased successfully",
        ]);
    }


    public function buyConfirm(Request $request)
    {
        $request->validate([
            'coin_quantity' => 'required|numeric|gt:0',
        ]);
        $quantity = $request->coin_quantity;
        $phase = Phase::whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first();
        if (!$phase) {
            $notify[] = ['error', 'Sorry! Now service is unavailable'];
            return to_route('user.home')->withNotify($notify);
        }

        if ($phase->coin_token < $request->coin_quantity) {
            $notify[] = ['error', 'Sorry! We haven\'t sufficient coin right now'];
            return back()->withNotify($notify);
        }

        $amount = $quantity * $phase->price;
        $user   = auth()->user();

        if ($user->balance < $amount) {
            $notify[] = ['error', 'Sorry! You haven\'t sufficient balance to buy coin'];
            return to_route('user.deposit.index')->withNotify($notify);
        }

        $general             = gs();
        $user->balance      -= $amount;
        $user->coin_balance += $quantity;
        $user->save();

        $phase->coin_token -= $quantity;
        $phase->sold       += $quantity;
        $phase->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $amount;
        $transaction->charge       = 0;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'coin';
        $transaction->details      = 'Purchased ' . $general->coin_text;
        $transaction->save();

        $history = new CoinHistory();
        $history->user_id           = $user->id;
        $history->type              = '+';
        $history->stage             = $phase->stage;
        $history->coin_rate         = $phase->price;
        $history->coin_quantity     = $quantity;
        $history->amount            = $amount;
        $history->coin_post_balance = $user->coin_balance;
        $history->details           = 'Purchased ' . $general->coin_text;
        $history->is_coin_purchase  = Status::YES;
        $history->save();

         // Give Referral Commission if Enabled
         if ($general->referral_commission == Status::YES) {
            levelCommission($user->id, $amount);
        }

        notify($user, 'BUY_CONFIRMATION', [
            'amount'            => showAmount($amount, currencyFormat:false),
            'trx_id'            => $transaction->trx,
            'stage'             => $phase->stage,
            'rate'              => showAmount($phase->price, currencyFormat:false),
            'coin_quantity'     => $quantity,
            'coin_post_balance' => $user->coin_balance,
            'currency'          => $general->cur_text,
            'coin_text'         => $general->coin_text,
        ]);

        $notify[] = ['success', $quantity . ' ' . $general->coin_text . ' ' . 'successfully purchased'];
        return to_route('user.coin.index')->withNotify($notify);
    }
}
