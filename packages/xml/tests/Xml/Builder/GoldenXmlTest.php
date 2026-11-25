<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use Greenter\Builder\BuilderInterface;
use Greenter\Data\Generator\BoletaStore;
use Greenter\Data\Generator\Despatch2022Store;
use Greenter\Data\Generator\DespatchStore;
use Greenter\Data\Generator\InvoiceDiscountStore;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\Generator\InvoiceIcbperStore;
use Greenter\Data\Generator\InvoiceIvapStore;
use Greenter\Data\Generator\InvoicePagoCreditoStore;
use Greenter\Data\Generator\InvoiceStore;
use Greenter\Data\Generator\NoteStore;
use Greenter\Data\Generator\PerceptionStore;
use Greenter\Data\Generator\RetentionStore;
use Greenter\Data\Generator\ReversionStore;
use Greenter\Data\Generator\SummaryIcbperStore;
use Greenter\Data\Generator\SummaryStore;
use Greenter\Data\Generator\VoidedStore;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Despatch\Autorizacion;
use Greenter\Model\Despatch\Contenedor;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\BaseSale;
use Greenter\Model\Sale\Contrato;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\MedioPago;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\TramoTransporte;
use Greenter\Model\Sale\TransporteCarga;
use Greenter\Model\Sale\VehiculoTransporte;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Xml\Builder\DespatchBuilder;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Builder\PerceptionBuilder;
use Greenter\Xml\Builder\RetentionBuilder;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\VoidedBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Compara el XML generado contra archivos de referencia (golden files).
 *
 * Protege las plantillas Twig contra cambios no intencionales en la salida.
 * Para regenerar los archivos de referencia tras un cambio intencional:
 *
 *   GREENTER_UPDATE_GOLDEN=1 vendor/bin/phpunit --filter GoldenXmlTest
 */
class GoldenXmlTest extends TestCase
{
    use SharedBuilderTrait;

    private const BUILDERS = [
        Invoice::class => InvoiceBuilder::class,
        Note::class => NoteBuilder::class,
        Summary::class => SummaryBuilder::class,
        Voided::class => VoidedBuilder::class,
        Reversion::class => VoidedBuilder::class,
        Despatch::class => DespatchBuilder::class,
        Perception::class => PerceptionBuilder::class,
        Retention::class => RetentionBuilder::class,
    ];

    /**
     * @dataProvider documentProvider
     */
    public function testXmlMatchesGoldenFile(string $storeClass, ?callable $customize): void
    {
        $document = $this->createDocument($storeClass);
        if ($customize) {
            $customize($document);
        }

        $xml = $this->normalize($this->getBuilder($document)->build($document));
        $file = $this->getGoldenPath($this->dataName());

        if (getenv('GREENTER_UPDATE_GOLDEN')) {
            file_put_contents($file, $xml);
        }

        $this->assertFileExists($file, 'Ejecutar con GREENTER_UPDATE_GOLDEN=1 para generar el archivo de referencia.');
        $this->assertSame(file_get_contents($file), $xml);
    }

    public function documentProvider(): array
    {
        $ubl20 = function (BaseSale $doc) {
            $doc->setUblVersion('2.0');
        };
        $ubl21 = function (BaseSale $doc) {
            $doc->setUblVersion('2.1');
        };
        $debitNote20 = function (Note $note) use ($ubl20) {
            $note->setTipoDoc('08')->setCodMotivo('01');
            $ubl20($note);
        };
        $debitNote21 = function (Note $note) use ($ubl21) {
            $note->setTipoDoc('08')->setCodMotivo('01');
            $ubl21($note);
        };

        $contrato = function (BaseSale $doc) {
            $doc->setContrato((new Contrato())
                    ->setTipo('1')
                    ->setNumero('CCE-2026-014')
                    ->setDescripcion('CONSORCIO VIAL DEL SUR')
                    ->setPorcentaje(35.5))
                ->setParticipantes([(new Client())->setTipoDoc('6')->setNumDoc('20601234567')->setRznSocial('CONSTRUCTORA ANDINA S.A.C.')]);
        };
        $invoiceFeatures = function (Invoice $inv) use ($ubl21, $contrato) {
            $ubl21($inv);
            $contrato($inv);
            $inv->setIncoterm('FOB')
                ->setDireccionDestino((new Address())
                    ->setUbigueo('230101')->setUrbanizacion('ZOFRATACNA')->setProvincia('TACNA')
                    ->setDepartamento('TACNA')->setDistrito('TACNA')
                    ->setDireccion('CARRETERA PANAMERICANA SUR KM 1308')->setCodigoPais('PE'))
                ->setAgenteVentas((new Client())->setTipoDoc('6')->setNumDoc('20100123456'))
                ->setMedioPago((new MedioPago())->setCodigo('006')->setAutorizacion('VISA-482913'));
            $inv->getDetails()[0]->setTransporteCarga((new TransporteCarga())
                ->setOrigen((new Address())->setUbigueo('150101')->setDireccion('AV. ARGENTINA 2450, LIMA'))
                ->setDestino((new Address())->setUbigueo('040101')->setDireccion('CALLE MERCADERES 120, AREQUIPA'))
                ->setDetalleViaje('LIMA - AREQUIPA, CARGA GENERAL')
                ->setValorReferencial(1200.0)
                ->setValorCargaEfectiva(1000.0)
                ->setValorCargaUtil(1100.0)
                ->setTramos([(new TramoTransporte())
                    ->setId('1')
                    ->setUbigeoOrigen('150101')
                    ->setUbigeoDestino('040101')
                    ->setDescripcion('LIMA - AREQUIPA POR LA PANAMERICANA SUR')
                    ->setValorCargaEfectiva(950.0)
                    ->setValorCargaNominal(1050.0)
                    ->setVehiculos([(new VehiculoTransporte())
                        ->setConfiguracion('T3S3')
                        ->setCargaUtil(30.0)
                        ->setCargaEfectiva(28.5)
                        ->setValorReferencialTm(40.0)
                        ->setRetornoVacio(false)])]));
        };
        $debitNoteFeatures = function (Note $note) use ($debitNote21, $contrato) {
            $debitNote21($note);
            $contrato($note);
            $note->setDetraccion((new Detraction())
                ->setCodBienDetraccion('014')
                ->setCodMedioPago('001')
                ->setCtaBanco('0004-3342343243')
                ->setPercent(4.00)
                ->setMount(37.76));
        };
        $despatchFeatures = function (Despatch $despatch) {
            $envio = $despatch->getEnvio();
            $envio->setAutorizacion((new Autorizacion())->setNumero('AUT-REM-2026-01')->setCodEmisor('06'))
                ->setContenedores([
                    (new Contenedor())->setNumero('MSKU1234567')->setPrecinto('PE45879'),
                    (new Contenedor())->setNumero('TGHU7654321'),
                ]);
            $envio->getTransportista()->setAutorizacion((new Autorizacion())->setNumero('AUT-TRA-77')->setCodEmisor('10'));
            $envio->getPartida()->setLatitud(-12.04637)->setLongitud(-77.04279412);
            $envio->getLlegada()->setLatitud(-16.409047)->setLongitud(-71.537451);
            $despatch->getDetails()[0]->setCodProdGS1('7750182000014');
        };

        return [
            'invoice20' => [InvoiceStore::class, $ubl20],
            'invoice21' => [InvoiceStore::class, $ubl21],
            'invoice20-full' => [InvoiceFullStore::class, $ubl20],
            'invoice21-full' => [InvoiceFullStore::class, $ubl21],
            'invoice21-discount' => [InvoiceDiscountStore::class, null],
            'invoice21-icbper' => [InvoiceIcbperStore::class, null],
            'invoice21-ivap' => [InvoiceIvapStore::class, null],
            'invoice21-credito' => [InvoicePagoCreditoStore::class, null],
            'boleta21' => [BoletaStore::class, null],
            'notacr20' => [NoteStore::class, $ubl20],
            'notacr21' => [NoteStore::class, $ubl21],
            'notadb20' => [NoteStore::class, $debitNote20],
            'notadb21' => [NoteStore::class, $debitNote21],
            'invoice21-features' => [InvoiceFullStore::class, $invoiceFeatures],
            'notacr21-contrato' => [NoteStore::class, function (Note $note) use ($ubl21, $contrato) {
                $ubl21($note);
                $contrato($note);
            }],
            'notadb21-features' => [NoteStore::class, $debitNoteFeatures],
            'despatch2022-features' => [Despatch2022Store::class, $despatchFeatures],
            'summary' => [SummaryStore::class, null],
            'summary-icbper' => [SummaryIcbperStore::class, null],
            'voided' => [VoidedStore::class, null],
            'reversion' => [ReversionStore::class, null],
            'despatch' => [DespatchStore::class, null],
            'despatch2022' => [Despatch2022Store::class, null],
            'perception' => [PerceptionStore::class, null],
            'retention' => [RetentionStore::class, null],
        ];
    }

    private function getBuilder(DocumentInterface $document): BuilderInterface
    {
        $builderClass = self::BUILDERS[get_class($document)];

        return new $builderClass([
            'cache' => false,
            'strict_variables' => true,
            'autoescape' => 'html', // por defecto en See y Api
        ]);
    }

    /**
     * Los generadores de datos usan la fecha actual, se reemplazan por valores fijos.
     */
    private function normalize(?string $xml): string
    {
        $patterns = [
            '/\b\d{4}-\d{2}-\d{2}\b/' => 'YYYY-MM-DD',
            '/\b\d{2}:\d{2}:\d{2}\b/' => 'HH:MM:SS',
            '/\b(R[ACR])-\d{8}-/' => '$1-YYYYMMDD-',
        ];

        return preg_replace(array_keys($patterns), array_values($patterns), (string)$xml);
    }

    private function getGoldenPath(string $name): string
    {
        return __DIR__.'/../../Resources/golden/'.$name.'.xml';
    }
}
