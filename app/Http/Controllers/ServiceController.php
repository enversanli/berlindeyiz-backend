<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceQuestionResource;
use App\Http\Resources\ServiceResource;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use App\Models\ServiceQuestion;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {

        $services = Service::with(['city', 'category'])
        ->where('status', ServiceStatusEnum::ACTIVE);

        if ($request->kategori && $request->kategori != ''){
            $services->whereHas('category', function ($query) use ($request){
                return $query->where('slug', $request->kategori);
            });
        }

        if ($request->sehir && $request->sehir != ''){
            $services->whereHas('city', function ($query) use ($request){
                return $query->where('slug', $request->kategori);
            });
        }

        if ($request->status && $request->status == 'priced'){
            $services->where('is_priced', 1);
        }

        if ($request->status && $request->status == 'free'){
            $services->where('is_priced', 0);
        }

        $services = $services->orderBy('date_from', 'ASC')
            ->paginate(12);

        return ServiceResource::collection($services);
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->with(['guide', 'questions', 'systemRequirement'])
            ->firstOrFail();

        $videoId = null;
        if (isset($service->guide) && isset($service->guide->youtube_url)) {
            $videoId = explode('?v=', $service->guide->youtube_url);
            $videoId = isset($videoId[1]) ? $videoId[1] : $videoId;
            $service->youtubevideoId = $videoId;
        }

        //ServiceResource::make($service)
        return view('web.services.detail')->with(['service' => $service, 'youtubeImgId' => $videoId]);
    }

    public function search($word)
    {
        $services = Service::where('title', 'like', '%' . $word . '%')->where('status', ServiceStatusEnum::ACTIVE)->take(5)->get();

        return ServiceResource::collection($services);
    }

    public function guide($serviceId)
    {
        $service = Service::with('guide')->findOrFail($serviceId);
        $videoId = explode('?v=', $service->guide->youtube_url);
        $videoId = isset($videoId[1]) ? $videoId[1] : $videoId;
        $service->youtubevideoId = $videoId;
        return view('web.services.guide')->with(['service' => $service, 'youtubeImgId' => $videoId]);
    }

    public function questions($serviceId, $perPage = 10)
    {
        $questions = ServiceQuestion::where('service_id', $serviceId)->paginate($perPage);

        return ServiceQuestionResource::make($questions);
    }

    public function question($serviceId, $questionId)
    {
        $question = ServiceQuestion::where('service_id', $serviceId)->where('id', $questionId)->firstOrFail();

        return ServiceQuestionResource::make($question);
    }

    public function lastAdded($count = 10){
        $services = Service::where('status', ServiceStatusEnum::ACTIVE)
            ->orderBy('created_at', 'ASC')
            ->take($count)
            ->get();

        return ResponseMessage::success('Başarı ile listelendi.', ServiceResource::collection($services));
    }

    public function searchDetail(Request $request){
        $services = Service::with(['city', 'category']);

        if ($request->kategori && $request->kategori != ''){
            $services->whereHas('category', function ($query) use ($request){
                return $query->where('slug', $request->kategori);
            });
        }

        if ($request->sehir && $request->sehir != ''){
            $services->whereHas('city', function ($query) use ($request){
                return $query->where('slug', $request->sehir);
            });
        }

        $services = $services->orderBy('date_from', 'ASC')
            ->paginate(10);


        return ServiceResource::collection($services);
    }
}
