<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\MarketAuthenticationService;
use App\Services\MeliService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


        /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $marketAuthenticationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MarketAuthenticationService $marketAuthenticationService, MeliService $meliService)
    {
        $this->middleware('guest')->except('logout');

        $this->marketAuthenticationService = $marketAuthenticationService;

        parent::__construct($meliService);
    }
    

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $authorizationUrl = $this->marketAuthenticationService->resolveAuthorizationUrl();

        return view('auth.login')->with([
            'authorizationUrl' => $authorizationUrl,
        ]);
    }


    public function authorization(Request $request)
    {
        if($request->has('code')) {

            $tokenData = $this->marketAuthenticationService->getCodeToken($request->code);

            $userData = $this->meliService->getUserInformation();

            $user = $this->registerOrUpdateUser($userData, $tokenData);

            $this->loginUser($user);

            return redirect()->intended('home');
        }

        return redirect()->route('login')->withErrors(['You canceled the authorization process']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try {
            $tokenData = $this->marketAuthenticationService->getPasswordToken($request->email, $request->password);
    
            $userData = $this->meliService->getUserInformation();
    
            $user = $this->registerOrUpdateUser($userData, $tokenData);
    
            $this->loginUser($user, $request->has('remember'));
    
            return redirect()->intended('home');

        }catch (ClientException $e) {
            $message = $e->getResponse()->getBody();
            if(Str::contains($message, 'invalid_credentials')) {
                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);
        
                return $this->sendFailedLoginResponse($request);
            }
            
            throw $e;
        }

    }

    public function loginLocal(Request $request)
    {
        // Validar los campos de inicio de sesión
        $this->validateLogin($request);
    
        // Buscar al usuario por su dirección de correo electrónico (suponiendo que se use el correo electrónico para la autenticación)
        $user = User::where('email', $request->input('email'))->first();
    
        if (!$user) {
            // El usuario no existe, puedes agregar un mensaje de error y redirigir al formulario de inicio de sesión
            return redirect()->route('login')->withErrors(['email' => 'Correo electrónico no registrado.']);
        }
    
        // Verificar la contraseña
        if (!\Hash::check($request->input('password'), $user->password)) {
            // La contraseña no coincide, puedes agregar un mensaje de error y redirigir al formulario de inicio de sesión
            return redirect()->route('login')->withErrors(['password' => 'Contraseña incorrecta.']);
        }
    
        // Iniciar sesión para el usuario autenticado
        $this->loginUser($user);
    
        // Redirigir al usuario a la página de inicio
        return redirect()->intended('home');
    }

    /**
     * Creates or updates a user from the API
     *@param \stdClass $userData
     *@param \stdClass $tokenData
     *@return \App\Models\User
     */

    public function registerOrUpdateUser($userData, $tokenData)
    {

        return User::updateOrCreate(
            [
                'meli_id' => $userData->id,
            ],
            [
                'meli_id' => $userData->id,
                'email' => $userData->email,
                'name' => $userData->nickname,
                'grant_type' => $tokenData->grant_type,           
                'access_token' => $tokenData->access_token,
                'refresh_token' => $tokenData->refresh_token,
                'token_expires_at' => $tokenData->token_expires_at,
            ]
        );
    }

      /**
     * Authenticates a user on the Client
     *@param \App\Models\User $user
     *@param boolean $remember
     *@return void
     */

     public function loginUser(User $user, $remember = true)
     {
        Auth::login($user, $remember);

        session()->regenerate();
     }

}
