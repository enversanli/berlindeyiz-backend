<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\Service\StoreServiceAction;
use App\Http\Actions\Service\UpdateServiceAction;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ServiceTypeResource;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Models\Service;
use App\Models\Type;
use App\Models\User;
use App\Support\Enum\UserRolesEnum;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
  /** @var User */
  protected $user;
  /** @var ResponseHelper */
  protected $responseHelper;
  /** @var StoreServiceAction */
  protected $storeServiceAction;
  /** @var UpdateServiceAction */
  protected $updateServiceAction;

  public function __construct(
    ResponseHelper      $responseHelper,
    StoreServiceAction  $storeServiceAction,
    UpdateServiceAction $updateServiceAction
  )
  {

    $this->responseHelper = $responseHelper;
    $this->storeServiceAction = $storeServiceAction;
    $this->updateServiceAction = $updateServiceAction;

    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      return $next($request);
    });
  }

  public function index(Request $request)
  {
    $services = Service::with(['city', 'category', 'user', 'type'])
      ->orderBy('created_at', 'DESC')
      ->when($this->user->role == UserRolesEnum::ORGANIZER, function ($q) {
        return $q->where('user_id', $this->user->id);
      })
      ->paginate(10);

    return view('admin.services.index')->with('services', $services);
  }

  public function show(Service $service)
  {

    return view('admin.services.detail')->with([
      'service' => $service,
      'cities' => City::get(),
      'districts' => District::get(),
      'categories' => Category::all()
    ]);
  }

  public function create()
  {
    return view('admin.services.create')->with([
      'cities' => City::with('districts')->get(),
      'districts' => District::get(),
      'categories' => Category::all()
    ]);
  }

  public function store(ServiceStoreRequest $request)
  {

    $storedService = $this->storeServiceAction->execute($request, $this->user);

    if (!$storedService->status) {
      return redirect()->back()->with(ResponseMessage::errorToView($storedService->message));
    }

    return redirect()->route('service.create')->with(ResponseMessage::successToView());
  }

  public function update(ServiceUpdateRequest $request, Service $service)
  {
    if ($this->user->role != UserRolesEnum::ADMIN && !$service->approved && $request->input('approved')) {
      return redirect()->back()->with(ResponseMessage::errorToView('Onaylama yetkiniz bulunmuyor. Lütfen yönetici ile görüşün.'));
    }
    $updatedService = $this->updateServiceAction->execute($request, $service);

    if (!$updatedService->status) {
      return redirect()->back()->with(ResponseMessage::errorToView($updatedService->message));
    }

    return redirect()->route('service.show', $service->id)->with(ResponseMessage::successToView());
  }

  public function destroy($id)
  {
    if ($this->user->role != UserRolesEnum::ADMIN) {
      return redirect()->back()->with(ResponseMessage::errorToView('Yetkiniz bulunmuyor. Lütfen yönetici ile görüşün.'));
    }
    try {
      $service = Service::findOrFail($id);
      $service->delete();
      return redirect()->route('service.index')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

    } catch (\Exception $exception) {
      return redirect()->route('service.index')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
    }
  }

  public function types()
  {
    $serviceTypes = Type::all();

    return ServiceTypeResource::collection($serviceTypes);
  }

  public function categories($typeId)
  {
    $serviceCategories = Category::where('type_id', $typeId)->get();

    return CategoryResource::collection($serviceCategories);
  }

}
