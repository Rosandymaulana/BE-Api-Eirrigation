<?php

namespace App\Exports;

use App\Models\Map\BangunanIrigasi;
use Maatwebsite\Excel\Concerns\FromCollection;

class BangunanIrigasiExport implements FromCollection
{
    public function collection()
    {
        return BangunanIrigasi::all();
    }
}
