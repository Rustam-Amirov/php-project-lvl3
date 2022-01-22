<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Url;

class UrlControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $m = Url::factory()->count(2)->make()->toArray();
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
        //$response->assertRedirect(route('urls.show'));
        $response->assertSessionHasNoErrors();

        //$response = $this->get(route('urls.index'))->assertSeeText($factoryData['name']);
        //$this->assertDatabaseHas('urls', ['name' => $factoryData['name']]);
    }
}
