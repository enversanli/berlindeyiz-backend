<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Resources\ServiceGuideResource;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\ServiceGuide;
use Illuminate\Http\Request;

class ServiceGuideController extends Controller
{
    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }
    public function index()
    {
        $guides = ServiceGuide::paginate(10);

        return view('admin.guides.index')->with('guides', $guides);
    }

    public function show($serviceId)
    {
        $service = Service::where('id', $serviceId)->with('guide')->firstOrFail();
        $route = route('service-guide.store', $service->id);
        if ($service->guide()->exists()){
            $route = route('service-guide.update', [$service->id , $service->guide->id]);
        }
        return view('admin.services.guide')->with('service', $service)->with('guideRoute', $route);
    }

    public function store(Request $request, $serviceId)
    {

        $request->validate([
            'title' => 'nullable|string',
            'text' => 'required|string',
            'note' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'get_in_url' => 'nullable|string|max:255',
        ]);

        try {
            $service = Service::findOrFail($serviceId);
            $serviceGuide = ServiceGuide::create([
                'service_id' => $service->id,
                'title' => $request->title,
                'text' => $request->text,
                'note' => $request->note ?? null,
                'youtube_url' => $request->youtube_url ?? null,
                'get_in_url' => $request->youtube_url ?? null
            ]);


            return redirect()->route('service.guide', $service->id)->with('service', $service)->with('guideRoute', route('service-guide.update', [$service->id, $serviceGuide->id]))
                ->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));
        } catch (\Exception $exception) {
            return redirect()->route('service.guide', $service->id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));

        }
    }

    public function update(Request $request, $serviceId, $id)
    {
        $request->validate([
            'title' => 'nullable|string',
            'text' => 'required|string',
            'note' => 'nullable|string',
            'youtube_url' => 'nullable|string|max:255',
            'get_in_url' => 'nullable|string|max:255',
        ]);

        try {
            $service = Service::findOrFail($serviceId);
            $serviceGuide = ServiceGuide::findOrFail($id);
            $serviceGuide->update([
                'title' => $request->title,
                'text' => $request->text,
                'note' => $request->note ?? null,
                'youtube_url' => $request->youtube_url,
                'get_in_url' => $request->get_in_url
            ]);

            return redirect()->route('service.guide', $service->id)
                ->with('service', $service)
                ->with('guideRoute', route('service-guide.update', [$service->id, $serviceGuide->id]))
                ->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));

        } catch (\Exception $exception) {
            return redirect()->back()->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));

        }
    }

    public function destroy($id){
        try {
            $serviceGuide = ServiceGuide::findOrFail($id);
            $serviceGuide->delete();

        }catch (\Exception $exception){

        }

    }

    public function social(Request $request, $serviceId, $guideId){
        $request->validate([
            'telegram' => 'nullable|string|min:3',
            'twitter' => 'nullable|string|min:3',
            'facebook' => 'nullable|string|min:3',
            'website' => 'nullable|string|min:3',
        ]);

        $guide = ServiceGuide::findOrFail($guideId);

        $guide->update([
            'telegram' => $request->telegram,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'website' => $request->website,
        ]);
        $service = Service::find($guide->service_id);

        return redirect()->back()->with('service', $service)
            ->with('guideRoute', route('service-guide.update', [$service->id, $guide->id]))
            ->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));

    }
}
