<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 23/01/2019
 * Time: 17:42.
 */

namespace Tests\Greenter\Ws\Builder;

use Greenter\Ws\Builder\SoapBuilder;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Ws\Services\WsdlProvider;
use PHPUnit\Framework\TestCase;

class SoapBuilderTest extends TestCase
{
    /**
     * @var SoapBuilder
     */
    private $builder;

    protected function setUp(): void
    {
        $this->builder = new SoapBuilder();
        $this->builder
            ->setUrl(SunatEndpoints::FE_BETA)
            ->setUser('20123456789MODDATOS')
            ->setPassword('moddatos');
    }

    /**
     * @throws \Exception
     */
    public function testCreateSoapClient()
    {
        $client = $this->builder->build();

        $this->assertInstanceOf(SoapClient::class, $client);
    }

    /**
     * @throws \SoapFault
     */
    public function testCreateConsultClient()
    {
        $this->expectException(\SoapFault::class);
        $this->builder
            ->setUrl(SunatEndpoints::FE_CONSULTA_CDR)
            ->setWsdl(WsdlProvider::getConsultPath())
            ->setWsdlParams([]);

        $client = $this->builder->build();

        $this->assertInstanceOf(SoapClient::class, $client);
        $client->call('getStatusCdr', []);
    }
}
