<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\CoinHistory;
use App\Models\Phase;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserAuctionController extends Controller
{
    // list //offering auctions
    public function offering()
    {
        $pageTitle = 'Offering Auctions';
        $phase     = $this->checkRunningPhase();
        $auctions  = Auction::where('auction_owner', '!=', auth()->user()->id)->with('user')
            ->where('status', Status::AUCTION_RUNNING)->orderBy('id', 'DESC')->paginate(getPaginate());
        return view(activeTemplate() . 'user.auction.index', compact('pageTitle', 'phase', 'auctions'));
    }

    public function buy($id)
    {
        $buyer = auth()->user();
        $buyPermission = Auction::where('auction_owner', '!=', $buyer->id)->where('id', $id)->where('status', Status::AUCTION_RUNNING)->firstOrFail();
        $phase =  $this->checkRunningPhase();
        $owner = User::findOrFail($buyPermission->auction_owner);
        $percentAmount = ($buyPermission->expected_profit * $phase->price) / 100;
        $finalPrice    = $phase->price + $percentAmount;
        $amount        = $buyPermission->quantity * $finalPrice;

        if ($buyer->balance < $amount) {
            $notify[] = ['error', 'You don\'t have sufficient balance to buy this auction'];
            return to_route('user.deposit.index')->withNotify($notify);
        }

        $general = gs();
        $owner->balance += $amount;
        $owner->save();

        $buyer->balance -= $amount;
        $buyer->coin_balance += $buyPermission->quantity;
        $buyer->save();

        $buyPermission->auction_buyer     = $buyer->id;
        $buyPermission->status            = Status::AUCTION_COMPLETED;
        $buyPermission->auction_completed = now();
        $buyPermission->amount            = $amount;
        $buyPermission->save();

        $history                    = new CoinHistory();
        $history->user_id           = $buyer->id;
        $history->type              = '+';
        $history->coin_rate         = $phase->price;
        $history->coin_quantity     = $buyPermission->quantity;
        $history->amount            = $amount;
        $history->coin_post_balance = $buyer->coin_balance;
        $history->details           = 'Buy ' . getAmount($buyPermission->quantity) . ' ' . $general->coin_text . ' from auction';
        $history->save();

        $trx = getTrx();

        //Transaction for Owner
        $transaction = new Transaction();
        $transaction->user_id      = $owner->id;
        $transaction->amount       = $amount;
        $transaction->charge       = 0;
        $transaction->post_balance = $owner->balance;
        $transaction->trx_type     = '+';
        $transaction->trx          = $trx;
        $transaction->remark       = 'auction';
        $transaction->details      = 'Get ' . $amount . ' ' . $general->cur_text . ' from the sold auction';
        $transaction->save();

        //Transaction for Buyer
        $transaction = new Transaction();
        $transaction->user_id      = $buyer->id;
        $transaction->amount       = $amount;
        $transaction->charge       = 0;
        $transaction->post_balance = $buyer->balance;
        $transaction->trx_type     = '-';
        $transaction->trx          = $trx;
        $transaction->remark       = 'auction';
        $transaction->details      = 'Paid ' . $amount . ' ' . $general->cur_text . ' for the buy auction';
        $transaction->save();

        notify($owner, 'PURCHASED_AUCTION', [
            'amount'    => $amount,
            'trx_id'    => $trx,
            'quantity'  => getAmount($buyPermission->quantity),
            'percent'   => getAmount($buyPermission->expected_profit),
            'buyer'     => $buyer->fullname,
            'purchased' => $buyPermission->auction_completed,
            'currency'  => $general->cur_text,
            'coin_text' => $general->coin_text,
        ]);

        $notify[] = ['success', 'You have purchased auction successfully'];
        return to_route('user.auction.purchase.history')->withNotify($notify);
    }


    public function create()
    {

        if (auth()->user()->coin_balance <= 0) {
            $notify[] = ['error', 'Sorry! You haven\'t sufficient coin to create auction'];
            return back()->withNotify($notify);
        }

        $pageTitle         = 'Create Your Auction';
        $phase             = $this->checkRunningPhase();
        $actionableCoinSum = getAmount(auth()->user()->coin_balance);
        return view(activeTemplate() . 'user.auction.create', compact('pageTitle', 'phase', 'actionableCoinSum'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'coin_quantity' => 'required|integer|gt:0',
            'percent'       => 'required|numeric|max:100',
        ]);

        $user        = auth()->user();
        $userBalance = $user->coin_balance;

        if ($userBalance < $request->coin_quantity) {
            $notify[] = ['error', 'Sorry! You haven\'t sufficient coin to create auction'];
            return back()->withNotify($notify);
        }

        $phase =  $this->checkRunningPhase();

        $percentAmount = ($request->percent * $phase->price) / 100;
        $finalPrice    = $phase->price + $percentAmount;
        $amount        = $request->coin_quantity * $finalPrice;

        $auction = new Auction();
        $auction->quantity        = $request->coin_quantity;
        $auction->amount          = $amount;
        $auction->expected_profit = $request->percent;
        $auction->auction_owner   = $user->id;
        $auction->status          = Status::AUCTION_RUNNING;
        $auction->save();

        $user->coin_balance -= $request->coin_quantity;
        $user->save();

        $history = new CoinHistory();
        $history->user_id           = $user->id;
        $history->type              = '-';
        $history->stage             = $phase->stage;
        $history->coin_rate         = $phase->price;
        $history->coin_quantity     = $request->coin_quantity;
        $history->amount            = $amount;
        $history->coin_post_balance = $user->coin_balance;
        $history->details           = 'Created Auction';
        $history->save();

        $notify[] = ['success', 'Your auction created successfully'];
        return to_route('user.auction.my.offers')->withNotify($notify);
    }

    public function myAuctionOffers()
    {
        $pageTitle = 'My Auction Offers';
        $auctions = Auction::where('auction_owner', auth()->user()->id)->with('user')->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.auction.my_auction', compact('pageTitle', 'auctions'));
    }

    public function returned($id)
    {
        $user            = auth()->user();
        $auction         = Auction::where('id', $id)->where('auction_owner', $user->id)->where('status', Status::AUCTION_RUNNING)->firstOrFail();

        $auction->status = Status::AUCTION_RETURNED;
        $auction->save();

        $user->coin_balance += $auction->quantity;
        $user->save();

        $general = gs();

        $history = new CoinHistory();
        $history->user_id           = $user->id;
        $history->type              = '+';
        $history->stage             = '';
        $history->coin_rate         = '';
        $history->coin_quantity     = $auction->quantity;
        $history->amount            = $auction->amount;
        $history->coin_post_balance = $user->coin_balance;
        $history->details           = 'Returned ' . getAmount($auction->quantity) . ' ' . $general->coin_text;
        $history->save();

        $notify[] = ['success', 'Your auction has returned successfully'];
        return back()->withNotify($notify);
    }


    public function purchasedHistory()
    {
        $auctions  = Auction::where('auction_buyer', auth()->user()->id)->orderBy('id', 'DESC')->paginate(getPaginate());
        $pageTitle = 'Purchased Auction History';
        return view(activeTemplate() . 'user.auction.purchase_history', compact('pageTitle', 'auctions'));
    }

    protected function checkRunningPhase()
    {
        $phase  = Phase::whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first();
        if (!$phase) {
            throw ValidationException::withMessages(['error' => 'Sorry! There is no running phase']);
        }

        return  $phase;
    }
}
