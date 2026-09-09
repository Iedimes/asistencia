<?php

namespace Tests\Feature;

use App\Models\State;
use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class StateFeatureTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $pAdmin = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $p1 = Permission::firstOrCreate(['name' => 'admin.state.index', 'guard_name' => 'admin']);
        $p2 = Permission::firstOrCreate(['name' => 'admin.state.create', 'guard_name' => 'admin']);
        $p3 = Permission::firstOrCreate(['name' => 'admin.state.edit', 'guard_name' => 'admin']);
        $p4 = Permission::firstOrCreate(['name' => 'admin.state.delete', 'guard_name' => 'admin']);

        $this->admin = factory(AdminUser::class)->create();
        $this->admin->givePermissionTo([$pAdmin, $p1, $p2, $p3, $p4]);
    }

    /** @test */
    public function unauthenticated_users_cannot_access_states()
    {
        $response = $this->get('/admin/states');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function authenticated_admin_can_store_state()
    {
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/states', [
            'name' => 'En Revision Tecnica',
        ]);

        $response->assertRedirect('admin/states');
        $this->assertDatabaseHas('states', ['name' => 'En Revision Tecnica']);
    }

    /** @test */
    public function store_state_validation_requires_name()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->from('/admin/states/create')
            ->post('/admin/states', [
                'name' => '',
            ]);

        $response->assertSessionHasErrors(['name']);
        $response->assertRedirect('/admin/states/create');
    }
}
