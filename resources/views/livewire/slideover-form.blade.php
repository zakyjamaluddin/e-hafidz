

@livewire('slideover-form', ['recordId' => $recordId])

<form wire:submit.prevent="submit">
    <input type="text" placeholder="Ahihihi">
    <x-filament::input label="Nama" wire:model="name"/>
    <x-filament::input label="Email" wire:model="email" type="email" />
    <input type="text" wire:model="name">

    <x-filament::button type="submit">Submit</x-filament::button>
</form>
