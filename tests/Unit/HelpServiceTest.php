<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Funcionario;
use App\Models\Help;
use App\Models\State;
use App\Repositories\HelpRepository;
use App\Services\HelpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpServiceTest extends TestCase
{
    use RefreshDatabase;

    private HelpService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $repository = new HelpRepository();
        $this->service = new HelpService($repository);
    }

    /** @test */
    public function it_can_register_ticket_via_service()
    {
        $data = [
            'ci' => '1234567',
            'name' => 'Maria Lopez',
            'user' => 'mlopez',
            'dependency' => 'Informatica',
            'fone' => '0981123456',
            'problem' => 'PC no enciende',
        ];

        $help = $this->service->registerTicket($data);

        $this->assertInstanceOf(Help::class, $help);
        $this->assertEquals('1234567', $help->ci);
        $this->assertDatabaseHas('helps', ['ci' => '1234567', 'problem' => 'PC no enciende']);
    }

    /** @test */
    public function it_can_lookup_person_by_cedula_when_found_in_rrhh()
    {
        $funcNro = '444' . rand(1000, 9999);
        factory(Funcionario::class)->create([
            'FuncNro' => $funcNro,
            'FuncNom' => 'Pedro Gimenez',
            'FUsuCod' => 'pgimenez',
            'FuncEst' => 'A',
        ]);

        $result = $this->service->lookupPersonByCedula($funcNro);

        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('cedula', $result);
        $this->assertEquals('Pedro Gimenez', $result['cedula']['FuncNom']);
    }

    /** @test */
    public function it_returns_error_when_cedula_not_found()
    {
        $nonExistentCi = '9999999999';
        $result = $this->service->lookupPersonByCedula($nonExistentCi);

        $this->assertTrue($result['error']);
        $this->assertStringContainsString('no se encuentra', strtolower($result['message']));
    }
}
