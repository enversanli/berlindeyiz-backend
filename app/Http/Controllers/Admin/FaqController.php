<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\ServiceQuestion;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index(){
        $questions = ServiceQuestion::whereNull('service_id')->paginate(10);
        return view('admin.faq.index')->with('questions', $questions);
    }

    public function show($questionId){
        $question = ServiceQuestion::whereNull('service_id')->where('id', $questionId)->firstOrFail();

        return view('admin.faq.detail')->with(['question' => $question]);
    }

    public function create(){
        return view('admin.faq.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string',
            'text' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {

            $question = ServiceQuestion::create([
                'title' => $request->title,
                'text' => $request->text ?? null
            ]);

            return redirect()->route('faq.create', $question->id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));

        }catch (\Exception $exception){
            return redirect()->route('faq.create', $question->id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function update(Request $request, $questionId){

        $request->validate([
            'title' => 'required|string',
            'text' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {
            $question = ServiceQuestion::findOrFail($questionId);
            $question->update([
                'title' => $request->title,
                'text' => $request->text ?? null
            ]);

            return redirect()->route('faq.show', $question->id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));

        }catch (\Exception $exception){
            return redirect()->route('faq.show',$question->id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function destroy($questionId){
        try {
            $question = ServiceQuestion::findOrFail($questionId);

            $question->delete();
            return redirect()->route('faq')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        }catch (\Exception $exception){
            return redirect()->route('faq')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }

    }
}
