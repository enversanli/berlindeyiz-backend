<?php

namespace App\Http\Controllers;

use App\Jobs\ServiceVisitJob;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ServiceQuestion;
use App\Support\ResponseMessage;
use App\Http\Resources\ServiceResource;
use App\Support\Enum\ServiceStatusEnum;
use App\Http\Resources\ServiceQuestionResource;
use App\Http\Actions\Service\SearchServicesAction;
use App\Http\Actions\Service\GetCityServicesAction;
use App\Http\Actions\Service\GetLastAddedServicesAction;

class ServiceController extends Controller
{
    /** @var SearchServicesAction */
    protected $searchServicesAction;
    /** @var GetCityServicesAction */
    protected $getCityServicesAction;
    /** @var GetLastAddedServicesAction */
    protected $getLastAddedServicesAction;

    public function __construct(
        SearchServicesAction       $searchServicesAction,
        GetCityServicesAction      $getCityServicesAction,
        GetLastAddedServicesAction $getLastAddedServicesAction
    )
    {
        $this->searchServicesAction = $searchServicesAction;
        $this->getCityServicesAction = $getCityServicesAction;
        $this->getLastAddedServicesAction = $getLastAddedServicesAction;
    }

    public function index(Request $request)
    {

        $services = Service::with(['city', 'category', 'business'])
            ->where('approved', 1);

        if ($request->kategori && $request->kategori != '') {
            $services->whereHas('category', function ($query) use ($request) {
                return $query->where('slug', $request->kategori);
            });
        }

        if ($request->sehir && $request->sehir != '') {
            $services->whereHas('city', function ($query) use ($request) {
                return $query->where('slug', $request->kategori);
            });
        }

        if ($request->has('status') && $request->input('status') == 'priced') {
            $services->where('is_priced', 1);
        }

        if ($request->has('status') && $request->input('status') == 'free') {
            $services->where('is_priced', 0);
        }

        if ($request->has('tarih') && $request->input('tarih') == 'bu-hafta'){
          $services->where('date_from', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))
            ->where('date_from', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'));
        }


        $services = $services
          ->where('date_from', '<',now()->addMonths(2)->format('Y-m-d'))
          ->orderBy('date_from', 'DESC')
          ->orderBy('status', 'ASC')
            ->paginate(10);

        return ServiceResource::collection($services);
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->with(['questions', 'city', 'category'])
            ->firstOrFail();

        $videoId = null;
        if (isset($service->guide) && isset($service->guide->youtube_url)) {
            $videoId = explode('?v=', $service->guide->youtube_url);
            $videoId = isset($videoId[1]) ? $videoId[1] : $videoId;
            $service->youtubevideoId = $videoId;
        }

        ServiceVisitJob::dispatchNow($service);

        //ServiceResource::make($service)
        return view('web.services.detail')->with(['service' => $service, 'youtubeImgId' => $videoId]);
    }

    public function search($word)
    {
        $services = Service::where('title', 'like', '%' . $word . '%')
            ->where('approved', 1)
            ->where('status', ServiceStatusEnum::ACTIVE)->take(5)->get();

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

    public function lastAdded($count = 10)
    {
        $lastAddedServices = $this->getLastAddedServicesAction->get($count);

        if (!$lastAddedServices->status) {
            ResponseMessage::custumized($lastAddedServices->message);
        }

        return ResponseMessage::success('Başarı ile listelendi.', ServiceResource::collection($lastAddedServices->data));
    }

    public function getCityServices($citySlug, $count = 10)
    {
        $cityServices = $this->getCityServicesAction->get($citySlug, $count);

        if (!$cityServices->status) {
            ResponseMessage::custumized($cityServices->message);
        }

        return ResponseMessage::success('Başarı ile listelendi.', ServiceResource::collection($cityServices->data));
    }

    public function searchDetail(Request $request)
    {
        $searchedServices = $this->searchServicesAction->search($request);

        if (!$searchedServices->status) {
            ResponseMessage::custumized($searchedServices->message);
        }

        return ServiceResource::collection($searchedServices->data);
    }
}
