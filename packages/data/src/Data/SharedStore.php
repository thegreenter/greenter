<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 21:45
 */

declare(strict_types=1);

namespace Greenter\Data;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;

class SharedStore
{
    public function getCompany(): Company
    {
        return (new Company())
            ->setRuc('20123456789')
            ->setNombreComercial('GREENTER')
            ->setRazonSocial('GREENTER S.A.C.')
            ->setAddress((new Address())
                ->setUbigueo('150101')
                ->setDistrito('LIMA')
                ->setProvincia('LIMA')
                ->setDepartamento('LIMA')
                ->setUrbanizacion('CASUARINAS')
                ->setCodLocal('0000')
                ->setDireccion('AV NEW DEÁL 123'))
            ->setEmail('admin@greenter.com')
            ->setTelephone('01-234455');
    }

    public function getClientPerson(): Client
    {
        $client = new Client();
        $client->setTipoDoc('1')
            ->setNumDoc('48285071')
            ->setRznSocial('NIPAO GUVI')
            ->setAddress((new Address())
                ->setDireccion('Calle fusión 453, SAN MIGUEL - LIMA - PERU'));

        return $client;
    }

    public function getClient(): Client
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1 S.A.C.')
            ->setAddress((new Address())
                ->setDireccion('JR. NIQUEL MZA. F LOTE. 3 URB.  INDUSTRIAL INFAÑTAS - LIMA - LIMA -PERU'))
            ->setEmail('client@corp.com')
            ->setTelephone('01-445566');

        return $client;
    }

    public function getSeller(): Client
    {
        $client = new Client();
        $client->setTipoDoc('1')
            ->setNumDoc('44556677')
            ->setRznSocial('VENDEDOR 1')
            ->setAddress((new Address())
                ->setDireccion('AV INFINITE - LIMA - LIMA - PERU'));

        return $client;
    }
}