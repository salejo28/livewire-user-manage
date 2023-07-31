<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Request;

class Auth extends Component
{


    public $name;
    public $email;
    public $password;

    public $showRegisterForm = false;

    public $loginForm = array(
        [
            "label" => "Email",
            "model" => "email",
            "name" => "email",
            "placeholder" => "john.doe@email.com",
            "type" => "email"
        ],
        [
            "label" => "Password",
            "model" => "password",
            "name" => "password",
            "placeholder" => "••••••••",
            "type" => "password"
        ]
    );
    public $registerForm = array(
        [
            "label" => "Name",
            "model" => "name",
            "name" => "name",
            "placeholder" => "John Doe",
            "type" => "text"
        ],
        [
            "label" => "Email",
            "model" => "email",
            "name" => "email",
            "placeholder" => "john.doe@email.com",
            "type" => "email"
        ],
        [
            "label" => "Password",
            "model" => "password",
            "name" => "password",
            "placeholder" => "••••••••",
            "type" => "password"
        ]
    );

    public $listeners = ['logout' => 'logout'];

    public function render()
    {
        return view('livewire.auth');
    }

    public function login()
    {
        $validatedCredentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $request = Request::create('/api/v1/auth/login', 'POST', [
            'email' => $validatedCredentials['email'],
            'password' => $validatedCredentials['password']
        ], [], [], ['Content-Type' => 'application/json']);
        $res = app()->handle($request);
        $data = json_decode($res->getContent(), true);
        if ($data['status'] === "failed") {
            if (array_key_exists('message', $data) && $data['message']) {
                session()->flash('error', $data['message']);
                return;
            }

            $errors = $data['errors'];

            if (array_key_exists('email', $errors) && $errors['email']) {
                $this->addError('email', $errors['email'][0]);
            }
            if (array_key_exists('password', $errors) && $errors['password']) {
                $this->addError('password', $errors['password'][0]);
            }
            return;
        }
        Cache::put('token', $data['authorization']['token']);
        Cache::put('user', json_encode($data['user']));
        redirect('http://localhost:8000/home');
    }

    public function register()
    {
        $validatedForm = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $request = Request::create('/api/v1/auth/register', 'POST', $validatedForm, [], [], ['Content-Type' => 'application/json']);
        $res = app()->handle($request);
        $data = json_decode($res->getContent(), true);
        if ($data['status'] === "failed") {
            if (array_key_exists('message', $data) && $data['message']) {
                session()->flash('error', $data['message']);
                return;
            }

            $errors = $data['errors'];
            if (array_key_exists('name', $errors) && $errors['name']) {
                $this->addError('name', $errors['name'][0]);
            }
            if (array_key_exists('email', $errors) && $errors['email']) {
                $this->addError('email', $errors['email'][0]);
            }
            if (array_key_exists('password', $errors) && $errors['password']) {
                $this->addError('password', $errors['password'][0]);
            }
            return;
        }
        Cache::put('token', $data['authorization']['token']);
        Cache::put('user', json_encode($data['user']));
        redirect('http://localhost:8000/home');
    }

    public function toggleForm()
    {
        $this->reset('name');
        $this->reset('email');
        $this->reset('password');
        $this->showRegisterForm = !$this->showRegisterForm;
    }
}
