<?php

namespace App\Http\Livewire\Backend\Assistent;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User as ModelsUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class User extends Component
{
    use WithPagination;
    use PasswordValidationRules;

    public $paginate= 10;
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $search = '';
    public $UsersAdd = false;
    public $UserEdit = false;
    public $passUpdate = false;
    public $firstname;
    public $lastname;
    public $interest;
    public $country;
    public $username;
    public $email;
    public $affiliation;
    public $password;
    public $password_confirmation;
    public $userRoles;
    public $userId;
    public $passwordNew;

    public function render()
    {
        $users = ModelsUser::query()->search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->paginate);
        $roles = Role::pluck('name','id')->all();
        $editRoles = Role::pluck('name','id')->all();
        return view('livewire.backend.admin.user', compact('users', 'roles', 'editRoles'))
        ->extends('layouts.Be')
            ->section('content');
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if($this->sortDirection == 'asc'){
            $this->sortDirection = 'desc';
        } else{
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }

    private function ResetFill()
    {
        $this->username = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->interest = '';
        $this->country = '';
        $this->email = '';
        $this->affiliation = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->userRoles = '';
    }

    public function createUser()
    {
        $this->ResetFill();
        $this->UsersAdd = true;
    }

    public function storeUser()
    {
       if(!empty($this->userId)){
        $validate = $this->validate([
            'username' => ['required', 'string', 'min:6',  'unique:users,username,'.$this->userId],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->userId],
            'password' => [ $this->passwordRules(), Password::min(8) ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
            'interest' => ['required', 'string', 'max:255'],
            'affiliation' => ['required'],
            'country' => ['required', 'string', 'max:255'],
        ]);

        $validate = Arr::except($validate,array('password'));    

        $user = ModelsUser::updateOrCreate(['id' => $this->userId],
        $validate);

        DB::table('model_has_roles')->where('model_id',$this->userId)->delete();

        $roles = $this->userRoles ? $this->userRoles : [];

        $user->assignRole($roles);

        $this->UserEdit = false;

       }else{
        $this->validate([
            'username' => ['required', 'string', 'min:6',  'unique:users,username,'.$this->userId],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->userId],
            'password' => [ $this->passwordRules(), Password::min(8) ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
            'interest' => ['required', 'string', 'max:255'],
            'affiliation' => ['required'],
            'country' => ['required', 'string', 'max:255'],
        ]);

        $user = ModelsUser::create([
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'interest' => $this->interest,
            'affiliation' => $this->affiliation,
            'country' => $this->country,
        ]);

        $roles = $this->userRoles ? $this->userRoles : [];

        $user->assignRole($roles);

        
       }

        $this->alert('success', $this->userId ? 'User Updated Successfully' : 'User Created Successfully', [
            'position' =>  'center', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Close', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  false, 
            'cancelButtonColor' => '#EF4444'
        ]);

        $this->UsersAdd = false;

    }

    public function editUser($id)
    {
        $user = ModelsUser::findOrFail($id);
        $this->userId = $id;
        $this->username = $user->username;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->interest = $user->interest;
        $this->country = $user->country;
        $this->email= $user->email;
        $this->password = $user->password;
        $this->affiliation = $user->affiliation;
        $this->userRoles = $user->roles()->pluck('name', 'id')->all();
        $this->UserEdit = true;
    }

    public function deleteUser($id)
    {
        ModelsUser::findOrFail($id)->delete();

        $this->alert('success', 'User Deleted Successfully', [
            'position' =>  'center', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Close', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  false, 
            'cancelButtonColor' => '#EF4444'
        ]);
    }

    public function editPassword()
    {
        $this->UserEdit = false;
        $this->passUpdate = true;
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => [ $this->passwordRules(), Password::min(8) ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()],
        ]);
    
        ModelsUser::findOrFail($this->userId)->forceFill([
            'password' => Hash::make($this->passwordNew),
        ])->save();

            $this->alert('success', 'Password Updated Successfully', [
                'position' =>  'center', 
                'timer' =>  3000,  
                'toast' =>  true, 
                'text' =>  '', 
                'confirmButtonText' =>  'Ok', 
                'cancelButtonText' =>  'Close', 
                'showCancelButton' =>  true, 
                'showConfirmButton' =>  false, 
                'cancelButtonColor' => '#EF4444'
            ]);

            $this->ResetFill();
            $this->passUpdate = false;
    }
}
