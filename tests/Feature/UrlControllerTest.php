<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Url;
use Illuminate\Support\Facades\DB;

class UrlControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Url::factory()->count(2)->make()->toArray();
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $factoryData = Url::factory()->make()->toArray();
        $data = ['url' => ['name' => $factoryData['name']]];
        $response = $this->post(route('urls.store'), $data);

        $scheme = parse_url($factoryData['name'], PHP_URL_SCHEME);
        $host = parse_url($factoryData['name'], PHP_URL_HOST);
        $url = $scheme . '://' . $host;
        $url = DB::table('urls')->where('name', $url)->first();

        $response->assertRedirect(route('urls.show', $url->id));
        $response->assertSessionHasNoErrors();

        $response = $this->get(route('urls.index'))->assertSeeText($url->name);
        $this->assertDatabaseHas('urls', ['name' => $url->name]);
    }

    public function testShow()
    {
        $url = DB::table('urls')->first();
        $response = $this->get(route('urls.show', $url->id));
        $response->assertOk();
    }
}
