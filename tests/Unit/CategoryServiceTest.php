<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $repository = new CategoryRepository();
        $this->service = new CategoryService($repository);
    }

    /** @test */
    public function it_can_create_a_category_via_service()
    {
        $data = ['name' => 'Redes y Conectividad'];

        $category = $this->service->createCategory($data);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Redes y Conectividad', $category->name);
        $this->assertDatabaseHas('categories', ['name' => 'Redes y Conectividad']);
    }

    /** @test */
    public function it_can_update_a_category_via_service()
    {
        $category = factory(Category::class)->create(['name' => 'Hardware Viejo']);

        $updated = $this->service->updateCategory($category, ['name' => 'Hardware Nuevo']);

        $this->assertEquals('Hardware Nuevo', $updated->name);
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Hardware Nuevo']);
    }

    /** @test */
    public function it_can_delete_a_category_via_service()
    {
        $category = factory(Category::class)->create(['name' => 'Software a Borrar']);

        $result = $this->service->deleteCategory($category);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
