<?php

namespace Kanekescom\Simgtk\Models;

class RancanganBezettingPegawai extends Pegawai
{
    public function getTable()
    {
        return config('simgtk.table_prefix') . 'rancangan_bezetting_pegawai';
    }
}
