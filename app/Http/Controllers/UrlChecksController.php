<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UrlChecksController extends Controller
{
    public function doCheck($id)
    {
        DB::table('url_checks')->insert([
            'url_id' => $id,
                'created_at' => Carbon::now(),
                ]);
        flash('Страница успешно проверена');
        return redirect(route('urls.show', ['url' => $id]));
    }
}
