<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\DetailHelp;
use App\Models\Help;
use App\Models\State;
use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ReporteFeatureTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $admin;
    private AdminUser $systemUser;

    protected function setUp(): void
    {
        parent::setUp();

        $pAdmin = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $p1 = Permission::firstOrCreate(['name' => 'admin.reporte.index', 'guard_name' => 'admin']);
        $p2 = Permission::firstOrCreate(['name' => 'admin.reporte.create', 'guard_name' => 'admin']);
        $p3 = Permission::firstOrCreate(['name' => 'admin.reporte.edit', 'guard_name' => 'admin']);
        $p4 = Permission::firstOrCreate(['name' => 'admin.reporte.show', 'guard_name' => 'admin']);

        // Crear usuario ID 1 (N/A / Sistema sin asignar)
        $this->systemUser = AdminUser::firstOrCreate(
            ['id' => 1],
            [
                'first_name' => 'N/A',
                'last_name'  => '',
                'email'      => 'administrator@brackets.sk',
                'password'   => bcrypt('password'),
                'activated'  => true,
                'forbidden'  => false,
                'language'   => 'en',
            ]
        );

        // Crear técnico de prueba (ID > 1)
        $this->admin = factory(AdminUser::class)->create();
        $this->admin->givePermissionTo([$pAdmin, $p1, $p2, $p3, $p4]);
    }

    /** @test */
    public function unauthenticated_users_cannot_access_reportes_create()
    {
        $response = $this->get('/admin/reportes/create');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function authenticated_admin_can_access_reportes_create()
    {
        $response = $this->actingAs($this->admin, 'admin')->get('/admin/reportes/create');
        $response->assertStatus(200);
        $response->assertSee('GENERACIÓN DE REPORTES DE ASISTENCIA');
    }

    /** @test */
    public function authenticated_admin_can_query_report_resultados_excluding_unassigned_na()
    {
        $help = Help::create([
            'ci' => '1234567',
            'name' => 'Funcionario Test',
            'user' => 'admin_test',
            'dependency' => 'TIC',
            'fone' => '0981123456',
            'problem' => 'Problema de prueba para reporte',
        ]);

        $state = State::firstOrCreate(['name' => 'EN PROCESO']);
        $category = Category::firstOrCreate(['name' => 'SOFTWARE']);

        // Registro del técnico real
        DetailHelp::create([
            'help_id' => $help->id,
            'user_id' => $this->admin->id,
            'state_id' => $state->id,
            'category_id' => $category->id,
            'solution' => 'Solución realizada por técnico asignado',
            'date' => now()->toDateString(),
        ]);

        // Registro sin asignar (user_id = 1 / N/A)
        DetailHelp::create([
            'help_id' => $help->id,
            'user_id' => 1,
            'state_id' => $state->id,
            'category_id' => $category->id,
            'solution' => 'Registro inicial sin asignar N/A',
            'date' => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get('/admin/reportes/resultados?' . http_build_query([
            'inicio' => now()->startOfDay()->toDateTimeString(),
            'fin' => now()->endOfDay()->toDateTimeString(),
            'user_id' => 0,
            'state_id' => 0,
        ]));

        $response->assertStatus(200);
        $response->assertSee('RESULTADOS DE ASISTENCIAS TÉCNICAS');
        $response->assertSee('Solución realizada por técnico asignado');
        $response->assertDontSee('Registro inicial sin asignar N/A');
    }

    /** @test */
    public function authenticated_admin_can_download_report_pdf()
    {
        $help = Help::create([
            'ci' => '7654321',
            'name' => 'Funcionario PDF Test',
            'user' => 'admin_test',
            'dependency' => 'TIC',
            'fone' => '0981123456',
            'problem' => 'Problema PDF test',
        ]);

        $state = State::firstOrCreate(['name' => 'FINALIZADO']);
        $category = Category::firstOrCreate(['name' => 'HARDWARE']);

        DetailHelp::create([
            'help_id' => $help->id,
            'user_id' => $this->admin->id,
            'state_id' => $state->id,
            'category_id' => $category->id,
            'solution' => 'Solución PDF test',
            'date' => now()->toDateString(),
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get('/admin/reportes/imprimir?' . http_build_query([
            'inicio' => now()->startOfDay()->toDateTimeString(),
            'fin' => now()->endOfDay()->toDateTimeString(),
            'user_id' => 0,
            'state_id' => 0,
        ]));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
