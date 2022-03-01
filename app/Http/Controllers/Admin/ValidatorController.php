<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\Validator;
use Illuminate\Http\Request;

class ValidatorController extends Controller
{

    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index()
    {
        $validators = Validator::paginate(10);

        return view('admin.validators.index')->with('validators', $validators);
    }

    public function create()
    {
        return view('admin.validators.create');
    }

    public function show($id)
    {
        $validator = Validator::findOrFail($id);

        return view('admin.validators.detail')->with('validator', $validator);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|min:3|max:255|string',
            'text' => 'required|min:3|string'
        ]);
        try {
            $validator = Validator::create([
                'title' => $request->title,
                'text' => $request->text
            ]);

            return redirect()->route('validator.create')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.created')])));
        } catch (\Exception $exception) {
            return redirect()->route('validator.create')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3|max:255|string',
            'text' => 'required|min:3|string'
        ]);
        try {
            $validator = Validator::findOrFail($id);

            $validator->update([
                'title' => $request->title,
                'text' => $request->text,
            ]);

            return redirect()->route('validator.show', $id)->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));

        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->route('validator.show', $id)->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }

    public function destroy($id)
    {
        try {
            $validator = Validator::findOrFail($id);

            $validator->delete();
            return redirect()->route('validator.list')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.deleted')])));

        } catch (\Exception $exception) {
            return redirect()->route('validator.create')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }

    }
}
