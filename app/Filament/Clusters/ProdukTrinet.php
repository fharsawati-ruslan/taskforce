<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class ProdukTrinet extends Cluster
{
    // Group utama
    protected static ?string $navigationGroup = 'Sales';

    // Nama yang tampil di sidebar
    protected static ?string $navigationLabel = 'Produk Trinet';

    // Icon modern
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    // Urutan setelah Pipeline
    protected static ?int $navigationSort = 2;
}