<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Newscategory;
use App\Models\Newscomment;
use App\Traits\ApiResponse;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsCommentsController extends Controller
{
    use ResponseMessage, ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newsComments($id):JsonResponse
    {
        $newscomments = Newscomment::where('news_id',$id)->paginate($this->perPage());
        return $this->successResponse($newscomments,$this->load_success['message']);
    }

    public function store(Request $request) :JsonResponse
    {
        $validated = $request->validate([
            'news_id' => 'required|integer|exists:news,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'comment' => 'required|string|max:2000'
        ]);
        try {
            $newscomments = new Newscomment();
            $newscomments->news_id = $validated['news_id'];
            $newscomments->name = strip_tags($validated['name']);
            $newscomments->email = $validated['email'];
            $newscomments->comment = strip_tags($validated['comment']);
            $newscomments->save();
            if ($newscomments)
                return $this->successResponse($newscomments, $this->create_success_message['message']);
            else
                return $this->successResponse('', $this->create_fail_message['message']);
        }catch(\Throwable $exception){
            Log::error($exception->getMessage());
            return $this->errorResponse($this->create_fail_message['message']);
        }
    }
}
