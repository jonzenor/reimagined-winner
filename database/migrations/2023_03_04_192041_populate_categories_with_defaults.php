<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LifeLogCategory;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('life_log_categories')->insert([
            [ 'name' => 'Challenges',           'icon' => 'fa-regular fa-user-astronaut',           'color' => 'accent'],
            [ 'name' => 'Contemplating',        'icon' => 'fa-sharp fa-regular fa-face-thinking',   'color' => 'info'],
            [ 'name' => 'Emergency',            'icon' => 'fa-regular fa-bolt-lightning',           'color' => 'error'],
            [ 'name' => 'Event',                'icon' => 'fa-regular fa-clock',                    'color' => 'primary'],
            [ 'name' => 'Family Events',        'icon' => 'fa-sharp fa-solid fa-family',            'color' => 'success'],
            [ 'name' => 'Financial',            'icon' => 'fa-duotone fa-money-bill-1-wave',        'color' => 'accent'],
            [ 'name' => 'God/Church',           'icon' => 'fa-solid fa-cross',                      'color' => 'secondary'],
            [ 'name' => 'Hobbies',              'icon' => 'fa-solid fa-chess',                      'color' => 'secondary'],
            [ 'name' => 'Info',                 'icon' => 'fa-solid fa-circle-info',                'color' => 'neutral'],
            [ 'name' => 'Life Changes',         'icon' => 'fa-duotone fa-tree-deciduous',           'color' => 'info'],
            [ 'name' => 'Search and Rescue',    'icon' => 'fa-solid fa-kit-medical',                'color' => 'warning'],
            [ 'name' => 'Travel',               'icon' => 'fa-regular fa-plane',                    'color' => 'success'],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        LifeLogCategory::where('name', 'Family Events')->delete();
        LifeLogCategory::where('name', 'Contemplating')->delete();
        LifeLogCategory::where('name', 'Emergency')->delete();
        LifeLogCategory::where('name', 'Financial')->delete();
        LifeLogCategory::where('name', 'Search and Rescue')->delete();
        LifeLogCategory::where('name', 'Life Changes')->delete();
        LifeLogCategory::where('name', 'Hobbies')->delete();
        LifeLogCategory::where('name', 'Travel')->delete();
        LifeLogCategory::where('name', 'Event')->delete();
        LifeLogCategory::where('name', 'Info')->delete();
        LifeLogCategory::where('name', 'God/Church')->delete();
        LifeLogCategory::where('name', 'Challenges')->delete();
    }
};
