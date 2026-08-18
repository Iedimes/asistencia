<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Help;
use App\Models\State;
use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class HelpFeatureTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $admin;

    protected function setUp(): void
    {
        parent::setUp();

        factory(State::class)->create();
        factory(Category::class)->create();

        $pAdmin = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $p1 = Permission::firstOrCreate(['name' => 'admin.help.index', 'guard_name' => 'admin']);
        $p2 = Permission::firstOrCreate(['name' => 'admin.help.create', 'guard_name' => 'admin']);
        $p3 = Permission::firstOrCreate(['name' => 'admin.help.edit', 'guard_name' => 'admin']);
        $p4 = Permission::firstOrCreate(['name' => 'admin.help.delete', 'guard_name' => 'admin']);

        $this->admin = factory(AdminUser::class)->create();
        $this->admin->givePermissionTo([$pAdmin, $p1, $p2, $p3, $p4]);
    }

    /** @test */
    public function unauthenticated_users_cannot_access_helps()
    {
        $response = $this->get('/admin/helps');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function authenticated_admin_can_store_help_ticket()
    {
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/helps/storeadm', [
            'ci' => 3334445,
            'name' => 'Ana Torres',
            'user' => 'atorres',
            'dependency' => 'Recursos Humanos',
            'fone' => '0981999888',
            'problem' => 'Falla en impresora de red',
            'dependency_id' => 1,
        ]);

        $response->assertRedirect('admin/helps');
        $this->assertDatabaseHas('helps', [
            'ci' => 3334445,
            'name' => 'Ana Torres',
            'problem' => 'Falla en impresora de red',
        ]);
    }

    /** @test */
    public function public_user_can_store_help_ticket_and_redirects_home()
    {
        $response = $this->post('/test/', [
            'ci' => 4445556,
            'name' => 'Marcos Rivas',
            'user' => 'mrivas',
            'dependency' => 'Informatica',
            'fone' => '0971222333',
            'problem' => 'Solicitud de acceso a correo',
            'dependency_id' => 1,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('helps', [
            'ci' => 4445556,
            'name' => 'Marcos Rivas',
        ]);
    }

    /** @test */
    public function cedula_lookup_endpoint_returns_json_response()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get('/cedula/9999999999');

        $response->assertStatus(200);
        $response->assertJson([
            'error' => true,
        ]);
    }
}
