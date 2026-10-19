<?php

namespace App\Livewire;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class ContactForm extends Component
{
    #[Validate('required|string|max:150', as: 'nombre')]
    public string $name = '';

    #[Validate('required|string|max:150', as: 'empresa')]
    public string $company = '';

    #[Validate('required|email|max:150', as: 'email')]
    public string $email = '';

    #[Validate('required|string|max:150', as: 'celular')]
    public string $phone = '';

    /** Campo trampa para bots: las personas no lo ven ni lo completan. */
    public string $website = '';

    public ?string $status = null;

    public function submit(): void
    {
        $data = $this->validate();

        if ($this->website !== '') {
            $this->succeed();

            return;
        }

        $key = 'contact-form:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->status = 'throttled';

            return;
        }
        RateLimiter::hit($key, 600);

        try {
            Mail::to(config('site.contact_email'))->send(new ContactMessage(...$data));
        } catch (Throwable $e) {
            Log::error('No fue posible enviar el formulario de contacto', ['exception' => $e]);
            $this->status = 'error';

            return;
        }

        $this->succeed();
    }

    private function succeed(): void
    {
        $this->reset('name', 'company', 'email', 'phone', 'website');
        $this->status = 'sent';
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'fields' => [
                ['name', 'Nombre', 'text', 'name'],
                ['company', 'Empresa', 'text', 'organization'],
                ['email', 'Email', 'email', 'email'],
                ['phone', 'Celular', 'tel', 'tel'],
            ],
        ]);
    }
}
