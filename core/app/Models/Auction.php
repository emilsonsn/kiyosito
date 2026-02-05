<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'auction_owner');
    }

    public function buyer()
    {
        return $this->hasOne(User::class, 'id', 'auction_buyer');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';

            if ($this->status == Status::AUCTION_RUNNING) {
                $html = '<span class="badge badge--warning">' . trans('RUNNING') . '</span>';
            } elseif ($this->status == Status::AUCTION_RETURNED) {
                $html = '<span class="badge badge--danger">' . trans('RETURNED') . '</span>';
            } elseif ($this->status == Status::AUCTION_COMPLETED) {
                $html = '<span class="badge badge--success">' . trans('COMPLETED') . '</span>';
            }

            return $html;
        });
    }
}
