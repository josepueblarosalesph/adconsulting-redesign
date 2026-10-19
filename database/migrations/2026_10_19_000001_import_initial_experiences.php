<?php

use App\Support\SiteContent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Importa una sola vez las Experiencias que venían incluidas en el sitio anterior.
 * Después se administran desde /admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $rows = array_map(fn (array $item) => [
            'id' => $item['id'],
            'title' => $item['title'],
            'source' => $item['source'],
            'summary' => $item['summary'],
            'url' => $item['url'],
            'image_url' => $item['image_url'],
            'published_at' => $item['date'],
            'published' => $item['published'],
            'created_at' => $now,
            'updated_at' => $now,
        ], SiteContent::staticExperiences());

        DB::table('experiences')->insertOrIgnore($rows);
    }

    public function down(): void
    {
        DB::table('experiences')->where('id', 'like', 'original-%')->delete();
    }
};
