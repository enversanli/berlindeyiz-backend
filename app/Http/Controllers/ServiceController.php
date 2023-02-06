<?php

namespace App\Http\Controllers;

use App\Http\Actions\Service\GetCityServicesAction;
use App\Http\Actions\Service\GetLastAddedServicesAction;
use App\Http\Actions\Service\SearchServicesAction;
use App\Http\Resources\ServiceQuestionResource;
use App\Http\Resources\ServiceResource;
use App\Jobs\ServiceVisitJob;
use App\Models\Service;
use App\Models\ServiceQuestion;
use App\Models\Type;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\Enum\ServiceType;
use App\Support\ResponseMessage;
use Carbon\Carbon;
use Facades\App\Http\Helper\SchemaGenerator;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

  protected SearchServicesAction $searchServicesAction;
  protected GetCityServicesAction $getCityServicesAction;
  protected GetLastAddedServicesAction $getLastAddedServicesAction;

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

  public function __invoke(Request $request)
  {
    $type = ServiceType::ACTIVITY->value;

    if (isset($request->segments()[0]) && in_array($request->segments()[0], ServiceType::values())) {
      $type = $request->segments()[0];
    }

    if ($request->has('type') && $request->input('type') != '') {
      $type = $request->input('type');
    }

    $seo = $this->getSeoValues();

    $siteDescription = $seo['descriptions'][$type];
    $siteKeyword = $seo['keyWords'][$type];
    $siteTitle = $seo['titles'][$type];

    return view('web.services.index')->with([
      'type' => $type,
      'siteTitle' => $siteTitle,
      'siteKeyword' => $siteKeyword,
      'siteDescription' => $siteDescription
    ]);
  }

  public function index(Request $request)
  {
    $perPage = $request->input('per_page', 10);
    $category = $request->input('category');
    $city = $request->input('sehir');
    $type = $request->input('type');

    $serviceType = $type ? $this->getType($type) : Type::where('slug', ServiceType::ACTIVITY)->first();

    $services = Service::with(['city', 'category', 'business'])
      ->where('approved', 1);

    if ($category && $category != '') {
      $services->whereHas('category', function ($query) use ($category) {
        return $query->where('slug', $category);
      });
    }

    if ($serviceType && !$category) {
      $services->where('type_id', $serviceType->id);
    }


    if ($city && $city != '') {
      $services->whereHas('city', function ($query) use ($city) {
        return $query->where('slug', $city);
      });
    }

    if ($request->has('status') && $request->input('status') == 'priced') {
      $services->where('is_priced', 1);
    }

    if ($request->has('status') && $request->input('status') == 'free') {
      $services->where('is_priced', 0);
    }

    if ($request->has('date') && in_array($request->input('date'),['bu-hafta', 'bu-ay', 'gelecek-hafta', 'gelecek-ay'])) {
      $dates = $this->dateFilter($request->input('date'));
      $services->where('date_from', '>=', $dates['start_date'])
        ->where('date_from', '<=', $dates['end_date']);
    }

    $services = $services
      ->where('date_from', '<', now()->addMonths(2)->format('Y-m-d'))
      //->orderBy('date_from', 'DESC')
      ->orderByRaw("FIELD(status , 'SPONSORED', 'ACTIVE', 'CANCELED', 'OUT_OF_DATE') ASC")
      ->orderBy('is_repeating', 'ASC') // Tekrar edenleri arkaya
      ->orderBy('remaining_day', 'ASC')
      //->where('type_id', $serviceType->id)
      ->paginate($perPage);

    return ServiceResource::collection($services);
  }

  public function show($slug)
  {
    $service = Service::where('slug', $slug)
      ->with(['questions', 'city', 'category', 'type'])
      ->firstOrFail();

    ServiceVisitJob::dispatchNow($service);

    $schema = SchemaGenerator::generate($service);

    return view('web.services.detail')->with(['service' => $service, 'schema' => json_encode($schema)]);
  }

  public function search($word)
  {
    $services = Service::where('title', 'like', '%' . $word . '%')
      ->where('approved', true)
      ->take(5)->get();

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

  private function getType(string $typeSlug)
  {
    $types = [
      'etkinlik', 'doktorlar', 'avukatlar'
    ];

    $slug = ServiceType::ACTIVITY;

    if (in_array($typeSlug, $types)) {
      $slug = $typeSlug;
    }

    return Type::where('slug', $slug)->first();
  }

  private function getSeoValues(): array
  {
    return [
      'keyWords' => [
        'etkinlikler' => "berlin etkinlik, berlin etkinlikleri, berlin etkinlik takvimi, berlin türk etkinlikleri, berlindeyiz, berlinde etkinlik, almanya gezilecek yerler, berlin 2023 etkinlikleri",
        'doktorlar' => "berlin doktorları, berlin türk doktorları, berlin göz doktorları, berlin cilt doktorları, berlin cilt doktoru, berlin göz doktoru, berlin diş doktoru, berlin türk doktor, belin türk doktorlar listesi, berlindeki türk doktorlar",
        'avukatlar' => "berlin avukatları, berlin türk avukatları, berlin avukat, berlin türk avukat berlin'deki türk avukatlar, berlin türk boşanma avukatları, berlin avukat wedding, berlin türk avukatlar listesi"
      ],
      'descriptions' => [
        'etkinlikler' => "Berlindeyiz, başta Berlin olmak üzere Almanya'nın tüm şehirlerindeki müzik, kültür, sanat, edebiyat, gezi gibi etkinlikleri kolayca bulmanızı sağlar.",
        'doktorlar' => "Berlindeyiz, Berlin'de aradığınız tüm doktorları bulmanızı sağlar. Berlin'de ki Türk doktorlar, göz doktorları, cilt doktorları, diş doktorları ve tüm doktorların listesine kolayca ulaşın.",
        'avukatlar' => "Berlindeyiz, Berlin'de aradığınız tüm avukatları kolayca bulmanızı sağlar. Berlin'de ki Türk avukatlar, boşanma avukatları, alman avukatları ve tüm avukatların listesine kolayca ulaşın."
      ],
      'titles' => [
        'etkinlikler' => "Berlin başta olmak üzere Almanya'daki tüm etkinlikleri kolayca bulun",
        'doktorlar' => "Berlin başta olmak üzere Almanya'daki tüm doktorları kolayca bulun",
        'avukatlar' => "Berlin başta olmak üzere Almanya'daki tüm avukatları kolayca bulun"
      ]
    ];
  }

  private function dateFilter(string $date)
  {
    $now = Carbon::now();

    return match ($date) {
      'bu-hafta' => [
        'start_date' => $now->startOfWeek()->format('Y-m-d'),
        'end_date' => $now->endOfWeek()->format('Y-m-d')
      ],
      'gelecek-hafta' => [
        'start_date' => $now->addDays(7)->startOfWeek()->format('Y-m-d'),
        'end_date' => $now->endOfWeek()->format('Y-m-d')
      ],
      'bu-ay' => [
        'start_date' => $now->startOfMonth()->format('Y-m-d'),
        'end_date' => $now->endOfMonth()->format('Y-m-d')
      ],
      'gelecek-ay' => [
        'start_date' => $now->addMonth()->startOfMonth()->format('Y-m-d'),
        'end_date' => $now->endOfMonth()->format('Y-m-d')
      ],
      default => ['start_date' => null, 'end_date' => null],
    };
  }
}
