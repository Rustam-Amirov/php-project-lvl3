<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Url;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlChecksControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    private $url;

    protected function setUp(): void
    {
        parent::setUp();
        $this->url = Url::factory()->create()->toArray();
    }

    public function testDoCheck()
    {
        $id = $this->url['id'];
        Http::fake([$this->url['name'] => Http::response('testing', 200)]);
        $response = $this->post(route('url_check', ['id' => $id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('urls.show', ['url' => $id]));
        $this->assertDatabaseHas('url_checks', ['url_id' => $id]);
    }
}
