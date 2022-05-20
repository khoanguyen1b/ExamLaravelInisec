<?php

namespace App\Http\Controllers;

use App\Models\EmailNewPost;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(Request $request)
    {
        try{
            $validation = $this->__requestPostValidation($request->all());
            if ($validation) {
                return $validation;
            }
            $website = Website::getWebsiteByDomain($request->all()['domain']);
            if(!$website) {
                return response()->json([
                    'message' => 'Cannot find website'
                ], 404);
            }
            $post = Post::createAPost($request->all(),$website->id);
            $subscription = new Subscription();
            $subscription->sendMailNotificationNewPostAllSubscription($website,$post);
            return response()->json([
                'message' => 'Create A Post Successfully!',
                'data' => $post
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function __requestPostValidation($request)
    {
        $validator = Validator::make($request, [
            'slug' => 'required',
            'domain' => 'required',
            'title' => 'required|max:100|min:2',
            'content' => 'required|max:50|min:2',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()
            ], 400);
        }
        return false;
    }
}
