<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\False_;

class Website extends Model
{
    protected $table = 'websites';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'domain',
        'description',
    ];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function createAWebsite($request,$subscription_id)
    {
        $website = new Website();
        $website->domain = $request['domain'];
        $website->description = $request['description'];
        $website->save();
        return $website ?? false;
    }

    public static function getWebsiteIdByDomain($domain)
    {
        $website = Website::query()->where('domain',$domain)->first();
        return $website->id ?? false;
    }

    public static function getWebsiteByDomain($domain)
    {
        $website = Website::query()->where('domain',$domain)->first();
        return $website ?? false;
    }
}
