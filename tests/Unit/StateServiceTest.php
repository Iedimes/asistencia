<?php

namespace Tests\Unit;

use App\Models\State;
use App\Repositories\StateRepository;
use App\Services\StateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateServiceTest extends TestCase
{
    use RefreshDatabase;

    private StateService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $repository = new StateRepository();
        $this->service = new StateService($repository);
    }

    /** @test */
    public function it_can_create_a_state_via_service()
    {
        $data = ['name' => 'Pendiente de Repuesto'];

        $state = $this->service->createState($data);

        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals('Pendiente de Repuesto', $state->name);
        $this->assertDatabaseHas('states', ['name' => 'Pendiente de Repuesto']);
    }

    /** @test */
    public function it_can_update_a_state_via_service()
    {
        $state = factory(State::class)->create(['name' => 'Estado Inicial']);

        $updated = $this->service->updateState($state, ['name' => 'Estado Modificado']);

        $this->assertEquals('Estado Modificado', $updated->name);
        $this->assertDatabaseHas('states', ['id' => $state->id, 'name' => 'Estado Modificado']);
    }

    /** @test */
    public function it_can_delete_a_state_via_service()
    {
        $state = factory(State::class)->create(['name' => 'Estado a Borrar']);

        $result = $this->service->deleteState($state);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('states', ['id' => $state->id]);
    }
}
