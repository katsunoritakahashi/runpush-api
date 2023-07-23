<?php

namespace App\Models;

use App\Facades\FacadeS3Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'family_id',
        'name',
        'email',
        'password',
        'email',
        'position_id',
        'device_token',
        'icon_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    const VIP_IDS = [9, 10, 13];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'family_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position', 'position_id', 'id');
    }

    public function rewards()
    {
        return $this->hasMany('App\Models\Reward', 'user_id');
    }

    public function pointHistories()
    {
        return $this->hasMany('App\Models\PointHistory', 'user_id');
    }

    public function notices()
    {
        return $this->hasMany('App\Models\Notice', 'user_id');
    }

    public function stampLogs()
    {
        return $this->hasMany('App\Models\StampLog', 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\SubscriptionReceipt', 'purchase_user_id');
    }

    public function createFile($file, $userId): void
    {
        $filePath = 'users/' . $userId;
        $path = FacadeS3Helper::uploadFilePublic($filePath, $file);
        User::find($userId)->update(['icon_url' => $path]);
    }

    public function getUserIconUrlAttribute()
    {
        if ($this->icon_url) {
            return $this->icon_url;
        }
        $positions = config('const.user_icon_urls');
        return $positions[$this->position_id];
    }

    public function isPremium()
    {
        $subscriptionReceipt = SubscriptionReceipt::where('family_id', $this->family_id)
            ->whereDate('latest_purchase_at', '<=', Carbon::today())
            ->whereDate('expiration_at', '>=', Carbon::today());

        return $subscriptionReceipt->count() > 0 || in_array($this->family_id, self::VIP_IDS);
    }

    public function scopePremiumPlanUser($query)
    {
        return $query
            ->whereIn('family_id', self::VIP_IDS)
            ->orWhere(function ($query) {
                $query->whereHas('family', function ($query) {
                    $query->whereHas('validSubscriptions');
                });
            });
    }

    public function scopeBasicPlanUser($query)
    {
        return $query
            ->whereNotIn('family_id', self::VIP_IDS)
            ->whereNot(function ($query) {
                $query->whereHas('family', function ($query) {
                    $query->whereHas('validSubscriptions');
                });
            });
    }
}
