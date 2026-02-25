<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Constants\BizCode;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        Category::factory()->count(12)->create();

        $params = [
            'page' => 1,
            'size' => 10,
        ];

        $this->getJson(route('categories.index', $params))
            ->assertJsonPath('message', BizCode::SUCCESS->getMessage())
            ->assertJsonPath('data.count', 12);

        $params = [
            'page' => 2,
            'size' => 10,
        ];

        $this->getJson(route('categories.index', $params))
            ->assertJsonPath('message', BizCode::SUCCESS->getMessage())
            ->assertJsonCount(2, 'data.list');
    }

    public function testStore()
    {
        $params = [
            'name' => '测试',
            'order' => 0,
        ];

        $this->postJson(route('categories.store'), $params)
            ->assertJsonPath('message', BizCode::SUCCESS->getMessage());

        $this->assertDatabaseCount(Category::class, 1);
    }

    public function testShow()
    {
        $category = Category::factory()->create();

        $this->getJson(route('categories.show', $category))
            ->assertJsonPath('message', BizCode::SUCCESS->getMessage())
            ->assertJsonPath('data.id', $category->id);
    }

    public function testUpdate()
    {
        $category = Category::factory()->create();

        $params = [
            'name' => 'test',
        ];

        $this->putJson(route('categories.update', $category), $params);

        $category->refresh();

        $this->assertEquals($params['name'], $category->name);
    }

    public function testDestroy()
    {
        $category = Category::factory()->create();

        $this->deleteJson(route('categories.destroy', $category))
            ->assertJsonPath('message', BizCode::SUCCESS->getMessage());

        $this->assertDatabaseCount(Category::class, 0);
    }
}
