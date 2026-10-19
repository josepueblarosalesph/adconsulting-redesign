<?php

namespace App\Livewire\Admin;

use App\Models\Experience;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Layout('layouts::admin')]
#[Title('Administración de Experiencias | AD Consulting')]
class ExperienceManager extends Component
{
    use WithFileUploads {
        _startUpload as private startUploadUnchecked;
    }

    private const SESSION_KEY = 'admin_authenticated';

    public string $password = '';

    public ?string $editingId = null;

    public string $title = '';

    public string $source = 'AD Consulting';

    public string $summary = '';

    public string $url = '';

    public string $date = '';

    public bool $published = true;

    public ?string $imageUrl = null;

    /** @var TemporaryUploadedFile|null */
    public $image = null;

    public string $notice = '';

    public function mount(): void
    {
        $this->date = today()->toDateString();
    }

    public function login(): void
    {
        $key = 'admin-login:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->notice = 'Demasiados intentos. Espera '.RateLimiter::availableIn($key).' segundos.';

            return;
        }

        $expected = (string) config('site.admin_password');

        if ($expected === '' || ! hash_equals($expected, $this->password)) {
            RateLimiter::hit($key, 60);
            $this->notice = $expected === '' ? 'Configura ADMIN_PASSWORD para habilitar el panel.' : 'La contraseña no es válida.';

            return;
        }

        RateLimiter::clear($key);
        session()->regenerate();
        session()->put(self::SESSION_KEY, true);
        $this->reset('password', 'notice');
    }

    public function logout(): void
    {
        session()->forget(self::SESSION_KEY);
        session()->regenerate();
        $this->redirect(route('admin'));
    }

    public function save(): void
    {
        $this->authorizeAdmin();

        $data = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'source' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:2000'],
            'url' => ['required', 'url', 'max:500', Rule::unique('experiences', 'url')->ignore($this->editingId)],
            'date' => ['required', 'date_format:Y-m-d'],
            'published' => ['boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
        ], [], ['title' => 'título', 'source' => 'fuente', 'summary' => 'resumen', 'url' => 'enlace', 'date' => 'fecha', 'image' => 'imagen']);

        if ($this->image) {
            $disk = config('site.uploads_disk');
            $this->imageUrl = Storage::disk($disk)->url($this->image->store('experiencias', $disk));
        }

        $attributes = [
            'title' => trim($data['title']),
            'source' => trim($data['source']),
            'summary' => trim($data['summary']),
            'url' => trim($data['url']),
            'published_at' => $data['date'],
            'published' => $data['published'],
            'image_url' => $this->imageUrl,
        ];

        if ($this->editingId) {
            Experience::findOrFail($this->editingId)->update($attributes);
            $message = 'Experiencia actualizada.';
        } else {
            Experience::create($attributes);
            $message = 'Experiencia creada.';
        }

        $this->resetForm();
        $this->notice = $message;
    }

    public function edit(string $id): void
    {
        $this->authorizeAdmin();

        $experience = Experience::findOrFail($id);

        $this->resetValidation();
        $this->editingId = $experience->id;
        $this->title = $experience->title;
        $this->source = $experience->source;
        $this->summary = $experience->summary;
        $this->url = $experience->url;
        $this->date = $experience->published_at->toDateString();
        $this->published = $experience->published;
        $this->imageUrl = $experience->image_url;
        $this->image = null;
        $this->notice = 'Editando experiencia.';

        $this->js("window.scrollTo({top: 0, behavior: 'smooth'})");
    }

    /** Solo una sesión de administración puede iniciar subidas de archivos. */
    public function _startUpload($name, $fileInfo, $isMultiple)
    {
        $this->authorizeAdmin();

        return $this->startUploadUnchecked($name, $fileInfo, $isMultiple);
    }

    public function updatedImage(): void
    {
        $this->validateOnly('image', ['image' => ['nullable', 'image', 'max:4096']], [], ['image' => 'imagen']);
    }

    public function removeImage(): void
    {
        $this->authorizeAdmin();
        $this->image = null;
        $this->imageUrl = null;
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->notice = '';
    }

    public function delete(string $id): void
    {
        $this->authorizeAdmin();

        Experience::whereKey($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }
        $this->notice = 'Experiencia eliminada.';
    }

    public function render()
    {
        $authenticated = $this->isAdmin();

        return view('livewire.admin.experience-manager', [
            'authenticated' => $authenticated,
            'experiences' => $authenticated ? Experience::query()->latestFirst()->get() : collect(),
        ]);
    }

    private function isAdmin(): bool
    {
        return session(self::SESSION_KEY) === true;
    }

    private function authorizeAdmin(): void
    {
        abort_unless($this->isAdmin(), 403, 'Sesión no autorizada.');
    }

    private function resetForm(): void
    {
        $this->reset('editingId', 'title', 'summary', 'url', 'imageUrl', 'image', 'published', 'source');
        $this->date = today()->toDateString();
        $this->resetValidation();
    }
}
