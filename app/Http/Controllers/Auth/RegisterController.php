<?php

namespace App\Http\Controllers\Auth;

use App\Http\Actions\Auth\RegisterAction;
use App\Http\Actions\Business\StoreBusinessAction;
use App\Http\Controllers\Controller;
use App\Http\Helper\MailDataGenerator;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendEmailJob;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Support\DTOs\MailDataDTO;
use App\Support\Enum\UserRolesEnum;
use App\Support\ResponseMessage;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /** @var RegisterAction */
    protected $registerAction;
    /** @var StoreBusinessAction */
    protected $storeBusinessAction;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        RegisterAction $registerAction,
        StoreBusinessAction $storeBusinessAction
    )
    {
        $this->registerAction = $registerAction;
        $this->storeBusinessAction = $storeBusinessAction;

        $this->middleware('guest');
    }

    /**
     * @return \App\Models\User
     */
    protected function register(RegisterRequest $request)
    {
        $user = $this->registerAction->execute($request);

        if (!$user->status){
            return ResponseMessage::custumized($user->message);
        }

        if ($user->data->role == UserRolesEnum::ORGANIZER){
            $this->storeBusinessAction->execute($user->data);
        }

        $mailData = new MailDataDTO();
        $mailData->email = $user->data->email;
        $mailData->subject = __('auth.registered_mail');
        $mailData->view = 'mails.auth.register';
        $mailData->data = $user->data;

        SendEmailJob::dispatch($mailData);

        return redirect()->route('login')->with('message', __('auth.registered_successfully'));
    }

    public function showRegistrationForm(){
        return view('auth.register');
    }
}
