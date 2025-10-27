<?php

namespace App\Livewire;

use Livewire\Component;

class SlideoverForm extends Component
{
    public $name;
    public $email;
    public $recordId;

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        // cek apakah data berhasil masuk



        // Contoh: simpan ke DB
        // \App\Models\User::create([
        //     'name' => $this->name,
        //     'email' => $this->email,
        // ]);


        $this->dispatchBrowserEvent('notify', ['message' => 'Data berhasil disimpan!']);
        $this->reset(['name', 'email']);
    }

    public function render()
    {
        return view('livewire.slideover-form');
    }
}
