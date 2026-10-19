<main class="admin-page">
    @if (! $authenticated)
        <section class="admin-login">
            <p class="eyebrow">AD CONSULTING</p>
            <h1>Administración de Experiencias</h1>
            <p>Ingresa con la contraseña configurada para publicar, editar o eliminar contenido.</p>
            <form wire:submit="login">
                <label>Contraseña<input type="password" wire:model="password" autocomplete="current-password" required></label>
                <button class="admin-primary" wire:loading.attr="disabled" wire:target="login">
                    <span wire:loading.remove wire:target="login">Ingresar</span><span wire:loading wire:target="login">Ingresando…</span>
                </button>
            </form>
            @if ($notice)
                <p class="admin-message">{{ $notice }}</p>
            @endif
        </section>
    @else
        <div class="admin-shell">
            <header class="admin-header">
                <div><p class="eyebrow">AD CONSULTING</p><h1>Experiencias</h1></div>
                <button class="admin-secondary" wire:click="logout">Cerrar sesión</button>
            </header>

            <section class="admin-editor">
                <div>
                    <p class="eyebrow">{{ $editingId ? 'EDITAR EXPERIENCIA' : 'NUEVA EXPERIENCIA' }}</p>
                    <h2>{{ $editingId ? 'Actualiza el contenido' : 'Publica una experiencia' }}</h2>
                </div>
                <form wire:submit="save" class="admin-form">
                    <label>Título<input wire:model="title" required>
                        @error('title')<small class="admin-error">{{ $message }}</small>@enderror
                    </label>
                    <label>Fuente o categoría<input wire:model="source" required>
                        @error('source')<small class="admin-error">{{ $message }}</small>@enderror
                    </label>
                    <label class="admin-full">Resumen<textarea wire:model="summary" required rows="4"></textarea>
                        @error('summary')<small class="admin-error">{{ $message }}</small>@enderror
                    </label>
                    <label>Enlace de destino<input type="url" wire:model="url" required placeholder="https://">
                        @error('url')<small class="admin-error">{{ $message }}</small>@enderror
                    </label>
                    <label>Fecha<input type="date" wire:model="date" required>
                        @error('date')<small class="admin-error">{{ $message }}</small>@enderror
                    </label>
                    <label class="admin-full">Imagen opcional
                        <input type="file" accept="image/*" wire:model="image">
                        <small wire:loading wire:target="image">Subiendo imagen…</small>
                        @error('image')<small class="admin-error">{{ $message }}</small>@enderror
                        @if ($image && ! $errors->has('image'))
                            <span class="admin-preview"><img src="{{ $image->temporaryUrl() }}" alt=""><small>Se guardará al {{ $editingId ? 'guardar los cambios' : 'crear la experiencia' }}.</small></span>
                        @elseif ($imageUrl)
                            <small>Imagen cargada: <a href="{{ $imageUrl }}" target="_blank" rel="noreferrer">ver imagen</a> · <button type="button" class="admin-delete" wire:click="removeImage">Quitar</button></small>
                        @endif
                    </label>
                    <label class="admin-check"><input type="checkbox" wire:model="published"> Publicar de inmediato</label>
                    <div class="admin-actions">
                        <button class="admin-primary" wire:loading.attr="disabled" wire:target="save,image">
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Guardar cambios' : 'Crear experiencia' }}</span><span wire:loading wire:target="save">Guardando…</span>
                        </button>
                        @if ($editingId)
                            <button type="button" class="admin-secondary" wire:click="cancel">Cancelar</button>
                        @endif
                    </div>
                </form>
                @if ($notice)
                    <p class="admin-message">{{ $notice }}</p>
                @endif
            </section>

            <section class="admin-list">
                <div><p class="eyebrow">CONTENIDO ACTUAL</p><h2>{{ $experiences->count() }} experiencias</h2></div>
                <div class="admin-rows">
                    @forelse ($experiences as $item)
                        <article class="admin-row" wire:key="admin-experience-{{ $item->id }}">
                            <div>
                                <time>{{ $item->displayDate() }}</time>
                                <h3>{{ $item->title }}</h3>
                                <p>{{ $item->source }} · {{ $item->published ? 'Publicado' : 'Borrador' }}</p>
                            </div>
                            <div class="admin-row-actions">
                                <button class="admin-secondary" wire:click="edit('{{ $item->id }}')">Editar</button>
                                <button class="admin-delete" wire:click="delete('{{ $item->id }}')" wire:confirm="¿Eliminar “{{ $item->title }}”?">Eliminar</button>
                            </div>
                        </article>
                    @empty
                        <p>Aún no hay experiencias creadas en la base de datos.</p>
                    @endforelse
                </div>
            </section>
        </div>
    @endif
</main>
