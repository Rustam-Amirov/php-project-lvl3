<?php

namespace App\Http\Controllers;

use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlChecksController extends Controller
{
    public function doCheck($id)
    {
        $url = DB::table('urls')->select('name')->where('id', '=', $id)->first();
        $response = Http::get($url->name);
        DB::table('url_checks')->insert([
            'url_id' => $id,
                'created_at' => Carbon::now(),
                'status_code' => $response->status()
                ]);
        flash('Страница успешно проверена');
        return redirect(route('urls.show', ['url' => $id]));
    }
}
