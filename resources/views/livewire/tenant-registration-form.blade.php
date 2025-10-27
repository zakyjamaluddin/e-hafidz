<div>
    <form wire:submit="register" class="bg-white p-6 rounded shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Pendaftaran Lembaga Baru</h2>

        {{ $this->form }}
        
        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700">
                Daftar & Buat Admin
            </button>
        </div>
    </form>
</div>