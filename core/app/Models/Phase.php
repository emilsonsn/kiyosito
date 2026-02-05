<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $fillable = [
        'stage', 'start_date', 'end_date', 'total_coin', 'price', 'unsold', 'sold', 'status',
        'softcap_price', 'softcap_label', 'softcap_label_2', 'hardcap_price', 'hardcap_label', 'hardcap_label_2'
    ];

    protected $appends = ['unsold'];

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';

            if ($this->start_date <= now() && $this->end_date >= now()) {
                $html = '<span class="badge badge--success">' . trans('RUNNING') . '</span>';
            } elseif ($this->start_date < now() && $this->end_date < now()) {
                $html = '<span class="badge badge--danger">' . trans('COMPLETED') . '</span>';
            } elseif ($this->end_date > now() && $this->start_date > now()) {
                $html = '<span class="badge badge--warning">' . trans('UPCOMING') . '</span>';
            }

            return $html;
        });
    }

    public function getUnsoldAttribute()
    {
        return ($this->total_coin - $this->sold);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())->where('end_date', '>', now());
    }
}