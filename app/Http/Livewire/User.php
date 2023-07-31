<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Request;


class User extends Component
{
    public $search = '';
    public $page = '1';
    public $users = [];
    public $links = [];
    public $update = false;
    public $lastPage;

    public $uid;
    public $name;
    public $email;
    public $password;

    public $token;
    public $user_session;

    public $show = false;
    public $updateUserForm = array(
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
        ]
    );
    public $addUserForm = array(
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

    public $listeners = ['users_table' => '$refresh', 'hideModal' => 'toggleShowModal', 'hideAlert' => 'handleHideDelete', 'setToken' => 'setToken', 'logout' => 'logout'];

    public function mount() {
        $this->token = Cache::get('token');
        $this->user_session = Cache::get('user');
    }

    public function render()
    {
        if (!empty($this->search)) {
            $this->page = '1';
        }
        $request = Request::create('/api/v1/users?search=' . $this->search . '&page=' . $this->page, 'GET');
        $request->headers->set('Authorization', 'Bearer ' . $this->token);
        $res = app()->handle($request);
        $data = json_decode($res->getContent(), true);

        if (array_key_exists('status', $data) && $data['status'] === 'failed') {
            redirect('http://localhost:8000/');
            return view('livewire.user');
        }

        $this->users = $data['data'];
        array_pop($data['links']);
        array_shift($data['links']);
        $this->lastPage = end($data['links'])['label'];
        $this->links = $data['links'];
        return view('livewire.user')->layoutData(['user_session' => $this->user_session]);
    }

    public function next($page) {
        $this->page = $page;
    }

    private function handleErrors($data) {
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
    }

    public function toggleShowModal()
    {
        $this->reset('uid');
        $this->reset('name');
        $this->reset('email');
        $this->reset('password');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('show', ['show' => !$this->show]);
        $this->show = !$this->show;
        if (!$this->show) {
            $this->update = false;
        }
    }

    public function handleUpdate($uid, $name, $email)
    {
        $this->uid = $uid;
        $this->name = $name;
        $this->email = $email;
        $this->update = true;
        $this->emit('show', ['show' => !$this->show]);
        $this->show = !$this->show;
    }

    public function handleDelete($uid) {
        $this->uid = $uid;
        $this->emit('show-alert-delete', ['show' => true]);
    }

    public function handleHideDelete() {
        $this->emit('show-alert-delete', ['show' => false]);
    }

    public function addNew()
    {
        $validatedForm = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $request = Request::create('/api/v1/users', 'POST', $validatedForm, [], [], ['Content-Type' => 'application/json']);
        $request->headers->set('Authorization', 'Bearer ' . $this->token);
        $res = app()->handle($request);
        $data = json_decode($res->getContent(), true);
        if ($data['status'] === "failed") {
            $this->handleErrors($data);
            return;
        }
        $this->toggleShowModal();
        $this->emit('users_table');
    }

    public function updateUser()
    {
        $validatedForm = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $request = Request::create('/api/v1/users/' . $this->uid, 'PUT', $validatedForm, [], [], ['Content-Type' => 'application/json']);
        $request->headers->set('Authorization', 'Bearer ' . $this->token);
        $res = app()->handle($request);
        $data = json_decode($res->getContent(), true);
        if ($data['status'] === "failed") {
            $this->handleErrors($data);
            return;
        }

        $this->toggleShowModal();
        $this->emit('users_table');
    }

    public function delete() 
    {
        $request = Request::create('/api/v1/users/' . $this->uid, 'DELETE');
        $request->headers->set('Authorization', 'Bearer ' . $this->token);
        $res = app()->handle($request);
        $data = json_decode($res->getContent(), true);
        if ($data['status'] === "failed") {
            $this->handleErrors($data);
            return;
        }

        $this->emit('hideAlert');
        $this->emit('users_table');
    }
}
