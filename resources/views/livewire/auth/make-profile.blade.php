<?php

use App\Models\StudentProfile;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.auth')] class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $nis = '';
    public string $kelas = '';
    public string $jurusan = '';

    public function mount(): void
    {
        if (!session()->has('user_id_pending_profile')) {
            flash()->error('Your session was expired');

            redirect()->route('auth.login');
            return;
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'nis' => 'required|string|max:50|unique:student_profiles,nis',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
        ]);

        $user = User::query()
            ->where('id', session('user_id_pending_profile'))
            ->first();

        $profile = $user->profile()->create([
            'nis' => $validated['nis'],
            'kelas' => $validated['kelas'],
            'jurusan' => $validated['jurusan'],
        ]);

        flash()->success('Profile berhasil dibuat');

        Auth::guard('web')->login($user);

        $this->redirect(route('dashboard'));
    }
};
?>

<section class="">
    <h2 class="text-xl font-bold mb-4">Lengkapi Profil Anda</h2>

    <form wire:submit="save" class="space-y-6" enctype="multipart/form-data">
        <flux:input wire:model="nis" label="NIS" required/>

        <flux:input wire:model="kelas" label="Kelas" required/>

        <flux:input wire:model="jurusan" label="Jurusan" required/>

        <flux:button type="submit" variant="primary">
            Simpan Profil
        </flux:button>

        @if (session('status'))
            <div class="text-green-600 mt-2">{{ session('status') }}</div>
        @endif
    </form>
</section>
