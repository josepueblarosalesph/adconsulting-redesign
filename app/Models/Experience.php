<?php

namespace App\Models;

use App\Support\SiteContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class Experience extends Model
{
    use HasUuids;

    protected $fillable = ['title', 'source', 'summary', 'url', 'image_url', 'published_at', 'published'];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('published', true);
    }

    public function scopeLatestFirst(Builder $query): void
    {
        $query->orderByDesc('published_at')->orderByDesc('created_at');
    }

    /** Fecha en formato dd-mm-aaaa, como se muestra en el sitio. */
    public function displayDate(): string
    {
        return $this->published_at->format('d-m-Y');
    }

    /**
     * Experiencias publicadas. Si la base de datos no está disponible, se usa
     * la lista incluida en el proyecto para que la página pública no falle.
     *
     * @return Collection<int, Experience>
     */
    public static function publishedOrFallback(): Collection
    {
        try {
            return static::query()->published()->latestFirst()->get();
        } catch (Throwable $e) {
            Log::error('No fue posible cargar Experiencias desde la base de datos', ['exception' => $e]);

            return collect(SiteContent::staticExperiences())
                ->sortByDesc('date')
                ->values()
                ->map(fn (array $item) => (new static)->forceFill([
                    ...collect($item)->except('date')->all(),
                    'published_at' => $item['date'],
                ]));
        }
    }
}
