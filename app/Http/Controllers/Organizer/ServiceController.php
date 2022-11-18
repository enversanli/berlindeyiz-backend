<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Actions\Service\StoreServiceAction;
use App\Http\Actions\Service\UpdateServiceAction;
use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Models\Service;
use App\Models\Type;
use App\Models\User;
use App\Support\Enum\ServiceStatusEnum;
use App\Support\ResponseMessage;
use App\Support\ReturnData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function index()
    {
        $services = Service::orderBy('created_at', 'DESC')
            ->where('user_id', auth()->user()->id)
            ->with(['city', 'category'])
            ->paginate(10);

        return view('organizer.services.index')->with('services', $services);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('organizer.services.detail')->with([
            'service' => ServiceResource::make($service),
            'cities' => City::get(),
            'districts' => District::get(),
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return view('organizer.services.create')->with([
            'cities' => City::with('districts')->get(),
            'districts' => District::get(),
            'categories' => Category::all()
        ]);
    }

    public function store(ServiceStoreRequest $request)
    {

        $storedService = $this->storeServiceAction->execute($request, $this->user);

        if (!$storedService->status){
            return redirect()->back()->with(ResponseMessage::errorToView($storedService->message));
        }

        return redirect()->route('service.create')->with(ResponseMessage::successToView());
    }

    public function update(ServiceUpdateRequest $request, $id)
    {
        $service = Service::where('id', $id)->where('user_id', $this->user->id)->firstOrFail();

        $updatedService = $this->updateServiceAction->execute($request, $service);

        if (!$updatedService->status){
            return redirect()->back()->with(ResponseMessage::errorToView($updatedService->message));
        }

        return redirect()->route('service.show', $service->id)->with(ResponseMessage::successToView());
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
            return redirect()->route('service.index')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        } catch (\Exception $exception) {
            return redirect()->route('service.index')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }
}
