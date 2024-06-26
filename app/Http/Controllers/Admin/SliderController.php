<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'DESC')->get();

        return view('admin.sliders.index')->with('sliders', $sliders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'slider' => 'required|max:10000|mimes:jpg,jpeg,png,webp'
        ]);

        try {
            $path = $request->slider->storeAs('public/sliders', 'slider-' . Str::uuid() . '.' . $request->slider->extension());
            //$path = $request->file('slider')->store('sliders');

            Slider::create([
                'image' => env('APP_URL'). '/storage/' .explode('public/', $path)[1],
                'title' => $request->title,
                'description' => $request->description
            ]);

            return redirect()->route('slider.index')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));

        } catch (\Exception $exception) {
            return redirect()->route('slider.index')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));

        }
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        try {
            $slider->delete();

            return redirect()->route('slider.index')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        } catch (\Exception $exception) {
            return redirect()->route('slider.index')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));

        }

    }
}
