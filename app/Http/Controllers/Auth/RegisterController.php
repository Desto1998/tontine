<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\AssociationService;
use App\Services\LogService;
use App\Services\MemberService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\HttpKernel\Log\format;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private LogService $logService, private AssociationService $associationService, private UserService $userService, private MemberService $memberService)
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'min:9','max:14'],
            'country' => ['required'],
            'town' => ['required','string', 'max:255'],
            'first_name' => ['required','min:3','max:255'],
            'last_name' => ['required','string', 'min:5','max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $formData
     * @return \App\Models\User
     */
    protected function create(array $formData)
    {
        $data = array();
        $data['first_name'] = $formData['first_name'];
        $data['last_name'] = $formData['last_name'];
        $data['password'] = Hash::make($formData['password']);
        $data['phone'] = $formData['phone'];
        $data['email'] = $formData['email'];
        $data['city'] = $formData['town'];
        $data['address'] = $formData['address'];

        $save = $this->associationService->store($formData);
        $user = [];
        if ($save) {
            $this->logService->save("Enregistrement", 'Association', "Enregistrement d'une association ID: $save->id le" . now()." Donne: $save", $save->id ,$save->id );
            $data['association_id'] = $save->id;
            $data['has_fund'] = 1;
            $data['fund_amount'] = 0;

            $member = $this->memberService->store($data);

            $data['member_id'] = $member->id;
            $user = $this->userService->store($data);
            $this->logService->save("Enregistrement", 'Member', "Enregistrement d'un membre ID: $member->id le" . now()." Donne: $member", $user->id, $user->id);
            $this->logService->save("Enregistrement", 'User', "Enregistrement d'un utilisateur ID: $user->id le" . now()." Donne: $user", $user->id, $user->id);

            $role = $this->userService->getRoleByTitle('President');
            $this->userService->addRole($user->id,[$role->id]);
        }
        return $user;
    }
}
