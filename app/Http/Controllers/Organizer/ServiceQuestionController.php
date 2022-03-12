<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\Service;
use App\Models\ServiceQuestion;
use Illuminate\Http\Request;

class ServiceQuestionController extends Controller
{
    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index($serviceId){
        $service = Service::findOrFail($serviceId);

        $questions = $service->questions()->paginate(10);

        return view('organizer.services.questions.index')->with(['questions' => $questions, 'service' => $service]);
    }

    public function show($serviceId, $questionId){
        $service = Service::findOrFail($serviceId);
        $question = $service->questions()->findOrFail($questionId);

        return view('organizer.services.questions.detail')->with(['service' => $service, 'question' => $question]);
    }

    public function create($serviceId){
        $service = Service::findOrFail($serviceId);
        return view('organizer.services.questions.create')->with('service', $service);
    }

    public function store(Request $request, $serviceId){
        $request->validate([
            'title' => 'required|string',
            'text' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {
            $service = Service::findOrFail($serviceId);
            $question = ServiceQuestion::create([
                'service_id' =>$service->id,
                'title' => $request->title,
                'text' => $request->text ?? null
            ]);

            return redirect()->route('service-question.create', $service->id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));

        }catch (\Exception $exception){
            return redirect()->route('service-question.create', $service->id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function update(Request $request, $serviceId, $questionId){

        $request->validate([
            'title' => 'required|string',
            'text' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {
            $service = Service::findOrFail($serviceId);
            $question = ServiceQuestion::findOrFail($questionId);
            $question->update([
                'service_id' =>$service->id,
                'title' => $request->title,
                'text' => $request->text ?? null
            ]);

            return redirect()->route('service-question.show', [$service->id, $question->id])->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));

        }catch (\Exception $exception){
            return redirect()->route('service-question.show', [$service->id, $question->id])->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function destroy($serviceId, $questionId){
        try {
            $service = Service::findOrFail($serviceId);
            $question = $service->questions()->findOrFail($questionId);

            $question->delete();
            return redirect()->route('service.questions', $service->id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        }catch (\Exception $exception){
            return redirect()->route('service.questions',$service->id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }

    }
}
