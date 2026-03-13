<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'owner_id'    => 2,
                'title'       => 'Pallabi 4, Mirpur 11, Dhaka',
                'description' => 'A spacious private room in Mirpur area with all amenities.',
                'location'    => 'Mirpur 11, Dhaka',
                'rent_price'  => 17000,
                'bedrooms'    => 3,
                'bathrooms'   => 2,
                'type'        => 'house',
                'is_available'=> true,
            ],
            [
                'owner_id'    => 2,
                'title'       => '28/45 Shenpara, Mirpur-1',
                'description' => 'Modern office room in Mirpur-1 area, great for small teams.',
                'location'    => 'Mirpur-1, Dhaka',
                'rent_price'  => 25000,
                'bedrooms'    => 2,
                'bathrooms'   => 1,
                'type'        => 'apartment',
                'is_available'=> true,
            ],
            [
                'owner_id'    => 2,
                'title'       => '15/5 Sector 10, Uttara',
                'description' => 'Beautiful private room in Uttara with modern furnishings.',
                'location'    => 'Uttara, Dhaka',
                'rent_price'  => 30000,
                'bedrooms'    => 4,
                'bathrooms'   => 3,
                'type'        => 'apartment',
                'is_available'=> true,
            ],
            [
                'owner_id'    => 2,
                'title'       => '15/3 Banani 18, Dhaka',
                'description' => 'Commercial space in prime Banani location.',
                'location'    => 'Banani, Dhaka',
                'rent_price'  => 20000,
                'bedrooms'    => 2,
                'bathrooms'   => 2,
                'type'        => 'room',
                'is_available'=> true,
            ],
            [
                'owner_id'    => 2,
                'title'       => 'Bashundhara 8, Dhaka',
                'description' => 'Private room in Bashundhara residential area.',
                'location'    => 'Bashundhara, Dhaka',
                'rent_price'  => 25000,
                'bedrooms'    => 3,
                'bathrooms'   => 3,
                'type'        => 'house',
                'is_available'=> true,
            ],
            [
                'owner_id'    => 2,
                'title'       => 'Dhanmondi 27, Dhaka',
                'description' => 'Cozy apartment in the heart of Dhanmondi.',
                'location'    => 'Dhanmondi, Dhaka',
                'rent_price'  => 35000,
                'bedrooms'    => 3,
                'bathrooms'   => 2,
                'type'        => 'apartment',
                'is_available'=> true,
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }
    }
}