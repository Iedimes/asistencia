<?php

namespace Tests\Feature;

use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProfileFeatureTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $pAdmin = Permission::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);

        $this->admin = factory(AdminUser::class)->create([
            'first_name' => 'Juan',
            'last_name' => 'Perez',
            'email' => 'juan@example.com',
        ]);
        $this->admin->givePermissionTo([$pAdmin]);
    }

    /** @test */
    public function authenticated_admin_can_access_edit_profile()
    {
        $response = $this->actingAs($this->admin, 'admin')->get('/admin/profile');

        $response->assertStatus(200);
        $response->assertViewHas('adminUser');
        $response->assertViewHas('locales');
    }

    /** @test */
    public function authenticated_admin_can_update_profile()
    {
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/profile', [
            'first_name' => 'Carlos',
            'last_name' => 'Gonzalez',
            'email' => 'carlos@example.com',
            'language' => 'es',
        ]);

        $response->assertRedirect('admin/profile');
        $this->assertDatabaseHas('admin_users', [
            'id' => $this->admin->id,
            'first_name' => 'Carlos',
            'last_name' => 'Gonzalez',
            'email' => 'carlos@example.com',
        ]);
    }

    /** @test */
    public function authenticated_admin_can_access_edit_password()
    {
        $response = $this->actingAs($this->admin, 'admin')->get('/admin/password');

        $response->assertStatus(200);
        $response->assertViewHas('adminUser');
    }

    /** @test */
    public function authenticated_admin_can_update_password()
    {
        $response = $this->actingAs($this->admin, 'admin')->post('/admin/password', [
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('admin/password');
    }

    /** @test */
    public function authenticated_admin_redirects_from_admin_root_to_helps()
    {
        $response = $this->actingAs($this->admin, 'admin')->get('/admin');

        $response->assertRedirect('admin/helps');
    }
}
