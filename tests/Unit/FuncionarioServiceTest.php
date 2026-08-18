<?php

namespace Tests\Unit;

use App\Models\Funcionario;
use App\Repositories\FuncionarioRepository;
use App\Services\FuncionarioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class FuncionarioServiceTest extends TestCase
{
    use RefreshDatabase;

    private FuncionarioService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $repository = new FuncionarioRepository();
        $this->service = new FuncionarioService($repository);
    }

    /** @test */
    public function it_can_search_and_paginate_funcionarios()
    {
        $request = new \App\Http\Requests\Admin\Funcionario\IndexFuncionario();

        $result = $this->service->searchAndPaginate($request);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /** @test */
    public function it_can_create_a_funcionario_via_service()
    {
        $funcNro = '777' . rand(1000, 9999);
        $data = [
            'FuncNro' => $funcNro,
            'FuncNom' => 'Juan Perez Test',
            'FUsuCod' => 'jpereztest',
        ];

        $funcionario = $this->service->createFuncionario($data);

        $this->assertInstanceOf(Funcionario::class, $funcionario);
        $this->assertEquals($funcNro, $funcionario->FuncNro);
        $this->assertEquals('Juan Perez Test', $funcionario->FuncNom);
    }

    /** @test */
    public function it_can_update_a_funcionario_via_service()
    {
        $funcNro = '888' . rand(1000, 9999);
        $funcionario = factory(Funcionario::class)->create([
            'FuncNro' => $funcNro,
            'FuncNom' => 'Nombre Viejo',
            'FUsuCod' => 'nviejo',
        ]);

        $updated = $this->service->updateFuncionario($funcionario, [
            'FuncNom' => 'Nombre Nuevo',
        ]);

        $this->assertEquals('Nombre Nuevo', $updated->FuncNom);
    }

    /** @test */
    public function it_can_delete_a_funcionario_via_service()
    {
        $funcNro = '999' . rand(1000, 9999);
        $funcionario = factory(Funcionario::class)->create([
            'FuncNro' => $funcNro,
            'FuncNom' => 'Para Eliminar',
            'FUsuCod' => 'peliminar',
        ]);

        $result = $this->service->deleteFuncionario($funcionario);

        $this->assertTrue($result);
    }
}
