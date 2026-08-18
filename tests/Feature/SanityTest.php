<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * El ambiente de ejecucion debe ser estrictamente 'testing'.
     */
    public function test_application_environment_is_testing()
    {
        $this->assertEquals('testing', app()->environment());
    }

    /**
     * La base de datos por defecto en tests debe ser PostgreSQL en local (asistencia_testing).
     */
    public function test_database_connection_is_postgresql_testing()
    {
        $this->assertEquals('pgsql', config('database.default'));
        $this->assertEquals('asistencia_testing', config('database.connections.pgsql.database'));
    }

    /**
     * El endpoint de login administrativo debe responder correctamente en PostgreSQL.
     */
    public function test_admin_login_page_is_accessible()
    {
        $response = $this->get('/admin/login');
        
        // Verifica que la pagina de login este accesible (HTTP 200 OK)
        $response->assertStatus(200);
    }
}
