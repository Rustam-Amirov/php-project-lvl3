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
        $urls = DB::table('urls')->leftjoin(
            'url_checks',
            function ($join) {
                $join->on('url_id', '=', 'urls.id')
                ->selectRaw('url_id, max(created_at) as created_at')
                ->groupBy('url_id');
            }
        )->select(['urls.id', 'url_checks.created_at', 'name'])->orderBy('urls.id')->paginate(15);
        return view('urls.index', ['urls' => $urls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
        $url = DB::table('urls')->find($id);
        $checks = DB::table('url_checks')->where('url_id', $id)->get();
        return view('urls.show', ['url' => $url, 'checks' => $checks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
