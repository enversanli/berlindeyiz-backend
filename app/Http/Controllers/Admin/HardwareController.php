<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\Service;
use App\Models\ServiceSystemRequirement;
use Illuminate\Http\Request;

class HardwareController extends Controller
{

    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function update(Request $request, $serviceId)
    {
        $request->validate([
            'storage' => 'nullable|string|min:1|max:255',
            'cpu' => 'nullable|string|min:1|max:255',
            'network' => 'nullable|string|min:1|max:255',
            'ram' => 'nullable|string|min:1|max:255',
        ]);
        $service = Service::findOrFail($serviceId);
        try {

            $data = [
                'storage' => $request->storage,
                'cpu' => $request->cpu,
                'network' => $request->network,
                'ram' => $request->ram,
            ];
            if ($service->systemRequirement()->exists()) {
                $service->systemRequirement()->update($data);
            } else {
                $data['service_id'] = $service->id;
                $service->systemRequirement()->create($data);
            }

            return redirect()->route('service.guide', $service->id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));
        } catch (\Exception $exception) {
            return redirect()->route('service.guide', $service->id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));

        }
    }
}
