<?php

namespace Tests\Feature;

use App\Models\Funcionario;
use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class FuncionarioFeatureTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $pAdmin = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $p1 = Permission::firstOrCreate(['name' => 'admin.funcionario.index', 'guard_name' => 'admin']);
        $p2 = Permission::firstOrCreate(['name' => 'admin.funcionario.create', 'guard_name' => 'admin']);
        $p3 = Permission::firstOrCreate(['name' => 'admin.funcionario.edit', 'guard_name' => 'admin']);
        $p4 = Permission::firstOrCreate(['name' => 'admin.funcionario.delete', 'guard_name' => 'admin']);

        $this->admin = factory(AdminUser::class)->create();
        $this->admin->givePermissionTo([$pAdmin, $p1, $p2, $p3, $p4]);
    }

    /** @test */
    public function unauthenticated_users_cannot_access_funcionarios()
    {
        $response = $this->get('/admin/funcionarios');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function authenticated_admin_can_store_funcionario()
    {
        $funcNro = '666' . rand(1000, 9999);
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/funcionarios', [
            'FuncNro' => $funcNro,
            'FuncNom' => 'Carlos Gomez',
            'FUsuCod' => 'cgomez',
        ]);

        $response->assertRedirect('admin/funcionarios');
    }
}
