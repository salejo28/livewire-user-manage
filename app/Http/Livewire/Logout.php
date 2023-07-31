<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Request;

class Logout extends Component
{

    public function mount() {
        $this->logout();
    }

    public function render()
    {
        return view('livewire.logout');
    }

    public function logout() {
        $token = Cache::get('token');
        $request = Request::create('/api/v1/users', 'POST', [], [], [], ['Content-Type' => 'application/json']);
        $request->headers->set('Authorization', 'Bearer ' . $token);
        app()->handle($request);
        Cache::put('token', null);
        Cache::put('user', null);
        redirect('http://localhost:8000/');
    }
}
