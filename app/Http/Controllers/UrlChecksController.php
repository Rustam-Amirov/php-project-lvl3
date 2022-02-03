<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class UrlChecksController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function doCheck($id)
    {
        $url = DB::table('urls')->select('name')->where('id', '=', $id)->first();
        if (!isset($url->name)) {
            flash('Сайт не найден');
            return redirect(route('urls.show', ['url' => $id]));
        }
        $response = Http::get($url->name);
        $document = new Document($response->body());
        $h1 = optional($document->first('h1'))->text();
        $title = optional($document->first('title'))->text();
        $content = optional($document->first('meta[name=description][content]'), function ($meta) {
            return $meta->getAttribute('content');
        });
        DB::table('url_checks')->insert([
            'url_id' => $id,
                'created_at' => Carbon::now(),
                'status_code' => $response->status(),
                'h1' => $h1,
                'title' => $title,
                'description' => $content
                ]);
        flash('Страница успешно проверена');
        return redirect(route('urls.show', ['url' => $id]));
    }
}
