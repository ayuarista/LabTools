<?php

use App\Models\File;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public string $name, $email, $nis, $kelas, $jurusan;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->nis = Auth::user()->profile->nis;
        $this->kelas = Auth::user()->profile->kelas;
        $this->jurusan = Auth::user()->profile->jurusan;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
        ]);


        $student = User::query()->where('id', Auth::id())->first();

        $student->profile()->update([
            'kelas' => $validated['kelas'],
            'jurusan' => $validated['jurusan'],
        ]);

        $student->update(['name' => $validated['name']]);
        session()->flash('status', 'Profil siswa berhasil disimpan.');
        $this->reset();
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Profil</h2>

    <form wire:submit="save" class="space-y-6" enctype="multipart/form-data">
        <flux:input label="Nama" wire:model="name" required/>

        <flux:input label="NIS" wire:model="nis" disabled/>

        <flux:input label="Kelas" wire:model="kelas" required/>

        <flux:input label="Jurusan" wire:model="jurusan" required/>

        <flux:button type="submit" variant="primary" accept="image/*">Simpan</flux:button>

        @if (session('status'))
            <div class="text-green-600 mt-2">{{ session('status') }}</div>
        @endif
    </form>
</section>

