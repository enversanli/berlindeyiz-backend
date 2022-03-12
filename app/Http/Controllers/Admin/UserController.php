<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\City\GetCityListAction;
use App\Http\Actions\User\GetUserDetailAction;
use App\Http\Actions\User\GetUserListAction;
use App\Http\Actions\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Support\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /** @var User */
    protected $user;
    /** @var GetCityListAction */
    protected $getCityListAction;
    /** @var UpdateUserAction */
    protected $updateUserAction;
    /** @var GetUserListAction */
    protected $getUserListAction;
    /** @var GetUserDetailAction */
    protected $getUserDetailAction;


    public function __construct(
        UpdateUserAction    $updateUserAction,
        GetUserListAction   $getUserListAction,
        GetUserDetailAction $getUserDetailAction,
        GetCityListAction   $getCityListAction
    )
    {
        $this->updateUserAction = $updateUserAction;
        $this->getUserListAction = $getUserListAction;
        $this->getCityListAction = $getCityListAction;
        $this->getUserDetailAction = $getUserDetailAction;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $users = $this->getUserListAction->get($request);

        if (!$users->status) {
            return redirect()->back()->with(ResponseMessage::errorToView($users->message));
        }


        return view('admin.users.index')->with(ResponseMessage::successToView(null, null, $users));
    }

    public function show(User $user)
    {
        $user = $this->getUserDetailAction->get($user);

        if (!$user->status) {
            return redirect()->back()->with(ResponseMessage::errorToView($user->message));
        }

        $cities = $this->getCityListAction->list();

        return view('admin.users.show')->with(['user' => $user->data, 'cities' => $cities->data]);

    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $updatedUser = $this->updateUserAction->execute($request, $user);
        if (!$updatedUser->status){
            return redirect()->back()->with(ResponseMessage::errorToView($user->message));
        }

        return redirect()->route('admin.user.show', $user->id);
    }

    public function destroy($id)
    {

    }

}
