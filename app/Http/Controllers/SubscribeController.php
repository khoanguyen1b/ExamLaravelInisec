<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\False_;

class SubscribeController extends Controller
{
    public function subscribeAWebsite(Request $request)
    {
        try{
            DB::beginTransaction();
            $validation = $this->__requestSubscribeWebsiteValidation($request->all());
            if ($validation) {
                return $validation;
            }
            $website_id = Website::getWebsiteIdByDomain($request->all()['domain']);
            if(!$website_id) {
                return response()->json([
                    'message' => 'Cannot find website'
                ], 404);
            }
            $subscription = new Subscription();
            $subscription = $subscription->checkSubscribeByEmail($request->all()['email']);
            if($subscription) {
                $subscription->websites()->sync([$website_id],false);
            }else{
                Subscription::subscribe($request->all(),$website_id);
            }
            DB::commit();
            return response()->json([
                'message' => 'Subscription Success !'
            ], 200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

    private function __requestSubscribeWebsiteValidation($request)
    {
        $validator = Validator::make($request, [
            'full_name_owner' => 'required',
            'email' => 'required|email',
            'domain' => 'required|max:50|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()
            ], 400);
        }
        return false;
    }
}
