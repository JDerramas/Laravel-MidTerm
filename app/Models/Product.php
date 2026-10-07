<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // List of database table columns that can be mass-assigned or saved
    protected $fillable = [
        'item_code',       // Item code identifier (e.g. ICS-POLO-M)
        'name',            // Merchandise or uniform item name
        'category',        // general, pe, department, accessory
        'dept',            // AIS, BSIS, all
        'gender',          // Male, Female, Unisex
        'price',           // Unit selling price
        'material',        // Fabric or material specification
        'description',     // Item overview and design details
        'image_path',      // Relative path to product image
        'sizes',           // Stock count per size (XS, S, M, L, XL, etc.)
        'initial_stock',   // Starting stock quantity
        'current_stock',   // Remaining stock available for purchase
        'units_sold',      // Total units claimed/sold
        'units_reserved',  // Total units currently reserved
        'is_active',       // Active visibility flag (true/false)
    ];

    // Automatic data type casting
    protected $casts = [
        'sizes' => 'array',
        'price' => 'float',
        'initial_stock' => 'integer',
        'current_stock' => 'integer',
        'units_sold' => 'integer',
        'units_reserved' => 'integer',
        'is_active' => 'boolean',
    ];
}
