<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use function PHPUnit\Framework\countOf;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'full_name_owner',
        'email',
    ];
    public function websites()
    {
        return $this->belongsToMany(Website::class);
    }

    public static function createASubscription($request,$website_id)
    {
        $subscription = new Subscription();
        $subscription->full_name_owner = $request['full_name_owner'];
        $subscription->email = $request['email'];
        $subscription->save();
        $subscription->websites()->attach($website_id);
        return $subscription ?? false;
    }

    public function sendMailNotificationNewPostAllSubscription($website,$post)
    {
        $subscriptionId = $this->getAllSubscriptionByWebsiteId($website->id);
        if(count($subscriptionId) == 0) {
            return true;
        }
        $subscriptions = $this->getAllSubsciptionByIds($subscriptionId);
        $url_post = $website->slug.'/'.$post->slug;
        foreach ($subscriptions as $subscription) {
            $this->sendMailASubsciption($subscription['full_name_owner'],$subscription['email'],$post->title,$url_post);
        }
    }

    private function sendMailASubsciption($full_name_owner,$email,$post_title,$url_post)
    {
        $emailTemplate = new EmailNewPost([
            'full_name_owner' => $full_name_owner,
            'title' => $post_title,
            'domain_url' => $url_post
        ]);

        Queue::pushOn(
            'new_post_notification_email',
            new MailJob($emailTemplate, $email)
        );
    }

    private function getAllSubsciptionByIds($subscription_ids)
    {
        $subscriptions = self::query()->select('*')->whereIn('id',$subscription_ids)->get()->toArray();
        return $subscriptions ?? [];
    }
    
    private function getAllSubscriptionByWebsiteId($website_id)
    {
        if(empty($website_id)){
            return [];
        }
        $subscriptionIds = DB::table('subscription_website')
            ->where('website_id', $website_id)
            ->get()->pluck('subscription_id')->toArray();
        return $subscriptionIds;
    }
}
