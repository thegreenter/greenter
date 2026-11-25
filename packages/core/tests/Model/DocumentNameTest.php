<?php

declare(strict_types=1);

namespace Tests\Greenter\Model;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\Receipt;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use PHPUnit\Framework\TestCase;

/**
 * El nombre del documento se usa como nombre del archivo XML/ZIP enviado a SUNAT.
 */
class DocumentNameTest extends TestCase
{
    private const RUC = '20123456789';

    /**
     * @dataProvider documentProvider
     */
    public function testGetName(DocumentInterface $document, string $expected): void
    {
        $this->assertSame($expected, $document->getName());
    }

    public function documentProvider(): array
    {
        $company = (new Company())->setRuc(self::RUC);
        $date = new DateTime('2024-03-15 10:00:00', new DateTimeZone('America/Lima'));

        return [
            'factura' => [
                (new Invoice())->setCompany($company)->setTipoDoc('01')->setSerie('F001')->setCorrelativo('123'),
                '20123456789-01-F001-123',
            ],
            'nota de crédito' => [
                (new Note())->setCompany($company)->setTipoDoc('07')->setSerie('FC01')->setCorrelativo('1'),
                '20123456789-07-FC01-1',
            ],
            'guía de remisión' => [
                (new Despatch())->setCompany($company)->setTipoDoc('09')->setSerie('T001')->setCorrelativo('22'),
                '20123456789-09-T001-22',
            ],
            'percepción' => [
                (new Perception())->setCompany($company)->setSerie('P001')->setCorrelativo('5'),
                '20123456789-40-P001-5',
            ],
            'retención' => [
                (new Retention())->setCompany($company)->setSerie('R001')->setCorrelativo('7'),
                '20123456789-20-R001-7',
            ],
            'resumen diario' => [
                (new Summary())->setCompany($company)->setFecResumen($date)->setCorrelativo('001'),
                '20123456789-RC-20240315-001',
            ],
            'comunicación de baja' => [
                (new Voided())->setCompany($company)->setFecComunicacion($date)->setCorrelativo('002'),
                '20123456789-RA-20240315-002',
            ],
            'reversión' => [
                (new Reversion())->setCompany($company)->setFecComunicacion($date)->setCorrelativo('003'),
                '20123456789-RR-20240315-003',
            ],
            'recibo por honorarios' => [
                (new Receipt())->setPerson($company)->setCorrelativo('99'),
                'RHE2012345678999',
            ],
        ];
    }

    /**
     * La fecha del identificador (RC/RA/RR) se expresa en hora de Perú.
     */
    public function testXmlIdUsesPeruTimezone(): void
    {
        // 2024-03-16 02:00 UTC = 2024-03-15 21:00 en Lima
        $utc = new DateTime('2024-03-16 02:00:00', new DateTimeZone('UTC'));

        $summary = (new Summary())->setFecResumen($utc)->setCorrelativo('1');
        $voided = (new Voided())->setFecComunicacion(DateTimeImmutable::createFromMutable($utc))->setCorrelativo('1');

        $this->assertSame('RC-20240315-1', $summary->getXmlId());
        $this->assertSame('RA-20240315-1', $voided->getXmlId());
        $this->assertSame('UTC', $utc->getTimezone()->getName(), 'No debe modificar la fecha original');
    }
}
