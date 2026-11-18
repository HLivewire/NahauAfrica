<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Gives the sample authors their pictures and the sample stories their images,
// for databases where the demo content was loaded before these pictures existed.
return new class extends Migration
{
    public function up(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('nahau_authors')) {
            return;
        }
        $dir = 'uploads/images/nahau/';
        $has = fn (string $f) => is_file(public_path($dir.$f));

        // Sample fiction writer: male portrait, so the sample name is changed to match.
        DB::table('nahau_authors')->where('slug', 'amina-mwakyusa')->update([
            'name' => 'Juma Mwakyusa', 'slug' => 'juma-mwakyusa', 'bio' => 'Juma writes short fiction about city life, buses and the people who keep Dar moving.',
        ]);
        foreach (['juma-mwakyusa' => 'author_1.jpg', 'baraka-ndege' => 'author_2.jpg'] as $slug => $file) {
            if ($has($file)) {
                DB::table('nahau_authors')->where('slug', $slug)->whereNull('photo')->update(['photo' => 'public/'.$dir.$file]);
            }
        }

        $stories = ['Two Weddings and a Funeral' => 'story_1.jpg', 'Ten Years at the Kariakoo Stall' => 'story_2.jpg', 'I Quit Banking to Farm Avocados' => 'story_3.jpg'];
        foreach ($stories as $title => $file) {
            if ($has($file)) {
                DB::table('news')->where('title', $title)->where('image', 'like', '%newsimages%')->update(['image' => json_encode(['public/'.$dir.$file])]);
            }
        }
    }

    public function down(): void {}
};
