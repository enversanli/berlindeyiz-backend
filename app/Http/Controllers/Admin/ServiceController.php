<?php

namespace App\Http\Controllers\Admin;

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
use App\Support\Enum\ServiceStatusEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
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
    }

    public function index()
    {
        $services = Service::orderBy('created_at', 'DESC')
            ->where('user_id', auth()->user()->id)
            ->with(['city', 'category'])
            ->paginate(10);

        return view('admin.services.index')->with('services', $services);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

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

        $storedService = $this->storeServiceAction->execute($request);

        return redirect()->route('service.create')->with(['response' => 'envr']);
    }

    public function update(ServiceUpdateRequest $request, $id)
    {
        $service = Service::findOrFail($id);

        $updatedService = $this->updateServiceAction->execute($request, $service);

        return redirect()->route('service.show', $service->id);
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
            return redirect()->route('services')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        } catch (\Exception $exception) {
            return redirect()->route('services')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }
}
