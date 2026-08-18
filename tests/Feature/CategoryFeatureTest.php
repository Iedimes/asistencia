<?php

namespace Tests\Feature;

use App\Models\Category;
use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $pAdmin = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $p1 = Permission::firstOrCreate(['name' => 'admin.category.index', 'guard_name' => 'admin']);
        $p2 = Permission::firstOrCreate(['name' => 'admin.category.create', 'guard_name' => 'admin']);
        $p3 = Permission::firstOrCreate(['name' => 'admin.category.edit', 'guard_name' => 'admin']);
        $p4 = Permission::firstOrCreate(['name' => 'admin.category.delete', 'guard_name' => 'admin']);

        $this->admin = factory(AdminUser::class)->create();
        $this->admin->givePermissionTo([$pAdmin, $p1, $p2, $p3, $p4]);
    }

    /** @test */
    public function unauthenticated_users_cannot_access_categories()
    {
        $response = $this->get('/admin/categories');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function authenticated_admin_can_store_category()
    {
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/categories', [
            'name' => 'Soporte Hardware',
        ]);

        $response->assertRedirect('admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Soporte Hardware']);
    }

    /** @test */
    public function store_category_validation_requires_name()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->from('/admin/categories/create')
            ->post('/admin/categories', [
                'name' => '',
            ]);

        $response->assertSessionHasErrors(['name']);
        $response->assertRedirect('/admin/categories/create');
    }
}
