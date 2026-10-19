<?php

namespace Tests\Feature;

use App\Livewire\Admin\ExperienceManager;
use App\Livewire\ContactForm;
use App\Mail\ContactMessage;
use App\Models\Experience;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render(): void
    {
        foreach (['/', '/nosotros', '/servicios', '/noticias', '/ad50', '/black'] as $uri) {
            $this->get($uri)->assertOk()->assertSee('AD Consulting');
        }

        $this->get('/adblack')->assertRedirect('/black');
    }

    public function test_initial_experiences_are_imported(): void
    {
        $this->assertSame(28, Experience::count());
        $this->get('/noticias')->assertSee('La vida laboral después de los 50');
    }

    public function test_contact_form_sends_email(): void
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name', 'company', 'email', 'phone']);

        Livewire::test(ContactForm::class)
            ->set('name', 'Ana')->set('company', 'ACME')->set('email', 'ana@example.com')->set('phone', '+56 9 1234 5678')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('status', 'sent');

        Mail::assertSent(ContactMessage::class, fn ($mail) => $mail->hasTo(config('site.contact_email')));
    }

    public function test_admin_requires_password(): void
    {
        config(['site.admin_password' => 'secreto']);

        Livewire::test(ExperienceManager::class)
            ->set('password', 'incorrecta')->call('login')
            ->assertSee('La contraseña no es válida.')
            ->call('delete', 'original-0')
            ->assertForbidden();

        $this->assertDatabaseHas('experiences', ['id' => 'original-0']);
    }

    public function test_admin_can_manage_experiences(): void
    {
        config(['site.admin_password' => 'secreto']);

        $component = Livewire::test(ExperienceManager::class)
            ->set('password', 'secreto')->call('login')
            ->set('title', 'Nueva experiencia')
            ->set('summary', 'Resumen')
            ->set('url', 'https://example.com/nota')
            ->set('date', '2026-10-01')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSee('Experiencia creada.');

        $experience = Experience::where('url', 'https://example.com/nota')->firstOrFail();

        $component->call('edit', $experience->id)
            ->set('published', false)
            ->call('save')
            ->assertSee('Experiencia actualizada.');

        $this->assertFalse($experience->fresh()->published);
        $this->get('/noticias')->assertDontSee('Nueva experiencia');

        $component->call('delete', $experience->id);
        $this->assertModelMissing($experience);
    }
}
