<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            [
                'name' => 'Miel',
                'slug' => 'miel',
                'description' => 'Miel naturel de Figuig, produit par les abeilles locales',
            ],
            [
                'name' => 'Huile d\'olive',
                'slug' => 'huile-olive',
                'description' => 'Huile d\'olive extra vierge de qualité supérieure',
            ],
            [
                'name' => 'Couscous',
                'slug' => 'couscous',
                'description' => 'Couscous traditionnel fait main',
            ],
            [
                'name' => 'Dattes',
                'slug' => 'dattes',
                'description' => 'Dattes fraîches et de qualité premium',
            ],
            [
                'name' => 'Henné',
                'slug' => 'henne',
                'description' => 'Henné naturel de Figuig',
            ],
            [
                'name' => 'Artisanat',
                'slug' => 'artisanat',
                'description' => 'Produits artisanaux traditionnels',
            ],
            [
                'name' => 'Épices',
                'slug' => 'epices',
                'description' => 'Épices et herbes aromatiques',
            ],
            [
                'name' => 'Produits laitiers',
                'slug' => 'produits-laitiers',
                'description' => 'Fromages et produits laitiers traditionnels',
            ],
        ];

        foreach ($sectors as $sector) {
            Sector::create($sector);
        }
    }
}
