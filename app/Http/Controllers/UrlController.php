<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url_checks = DB::table('url_checks')
                        ->selectRaw('url_id, max(created_at) as created_at')
                        ->groupBy('url_id');

        $urls = DB::table('urls')->leftJoinSub($url_checks, 'dates', 'dates.url_id', '=', 'urls.id')
                    ->leftJoin('url_checks', function ($join) {
                        $join->on('url_checks.url_id', '=', 'urls.id')
                        ->on('dates.created_at', '=', 'url_checks.created_at');
                    })->select(['urls.id', 'dates.created_at', 'name', 'status_code'])
                    ->orderBy('urls.id')
                    ->paginate(15);
        return view('urls.index', ['urls' => $urls]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['url.name' => 'required|url|max:255']);
        if ($validator->fails()) {
            flash('Некорректный URL')->error();
            $validator->validate();
        }
        $scheme = parse_url($validator->validated()['url']['name'], PHP_URL_SCHEME);
        $host = parse_url($validator->validated()['url']['name'], PHP_URL_HOST);
        $urlName = $scheme . '://' . $host;

        $isExistUrl = DB::table('urls')->where('name', $urlName)->exists();
        if (!$isExistUrl) {
            $now = Carbon::now();
            DB::table('urls')->insert(
                ['name' => $urlName, 'created_at' => $now]
            );
            flash('Страница успешно добавлена');
        } else {
            flash('Страница уже существует');
        }
        $url = DB::table('urls')->where('name', $urlName)->first();
        if (!isset($url->id)) {
            return abort(404);
        }
        return redirect()->route('urls.show', ['url' => $url->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = DB::table('urls')->find($id);
        $checks = DB::table('url_checks')->where('url_id', $id)->orderBy('id', 'desc')->get();
        return view('urls.show', ['url' => $url, 'checks' => $checks]);
    }
}
