<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helper\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /** @var ResponseHelper */
    protected $responseHelper;

    public function __construct(ResponseHelper $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function show()
    {
        return view('admin.profile.index')->with('user', Auth::user());
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|string'
        ]);

        if (isset($request->password) && $request->password !== null) {
            $request->validate([
                'password' => 'required|confirmed|min:6',
            ]);
        }

        try {
            $admin = User::find(auth()->user()->id);

            $data = [
                'name' => $request->name
            ];

            if (isset($request->password) && $request->password !== null) {
                $data['password'] = Hash::make($request->password);
            }

            $admin->update($data);
            return redirect()->route('profile')->with('message', $this->responseHelper->success(__('response.success'), __('response.successMessage', ['param' => __('common.updated')])));

        } catch (\Exception $exception) {
            return redirect()->route('profile')->with('message', $this->responseHelper->error(__('response.error'), __('response.went_wrong')));
        }
    }
}
