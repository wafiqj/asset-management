<?php

namespace App\Services;

use App\Models\Asset;

class AssetIdGeneratorService
{
    public function generate(): string
    {
        $year = now()->year;
        $prefix = "AST-{$year}-";

        $lastAsset = Asset::where('asset_id', 'like', "{$prefix}%")
            ->orderBy('asset_id', 'desc')
            ->first();

        if ($lastAsset) {
            $lastNumber = (int) substr($lastAsset->asset_id, -5);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}
