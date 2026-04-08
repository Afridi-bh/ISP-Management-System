<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Customer::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name','like','%'.$this->search.'%')
                  ->orWhere('email','like','%'.$this->search.'%')
                  ->orWhere('phone','like','%'.$this->search.'%');
            });
        }

        $customers = $query->orderBy('created_at','desc')->paginate(15);

        return view('livewire.user-table', compact('customers'));
    }
}
