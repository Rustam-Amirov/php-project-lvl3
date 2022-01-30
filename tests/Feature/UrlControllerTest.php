<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Url;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        Url::factory()->create();
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
        $urlName = $scheme . '://' . $host;
        $url = DB::table('urls')->where('name', $urlName)->first();

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
