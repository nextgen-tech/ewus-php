<?php
declare(strict_types=1);

namespace NGT\Ewus\Parsers;

use DateTimeImmutable;
use DOMElement;
use NGT\Ewus\Contracts\Parser as ParserContract;
use NGT\Ewus\Contracts\Response;
use NGT\Ewus\Enums\CheckStatus;
use NGT\Ewus\Enums\InsuranceStatus;
use NGT\Ewus\Responses\CheckResponse;
use NGT\Ewus\Support\Xml;

class CheckParser extends Parser implements ParserContract
{
    public function parse(Xml $xml): Response
    {
        $xml->registerNamespace('ewus');

        $response = new CheckResponse($this->request, $xml->getXml());
        $response->setOperationDate($this->parseOperationDate($xml));
        $response->setOperationId($this->parseOperationId($xml));
        $response->setSystemName($this->parseSystemName($xml));
        $response->setSystemVersion($this->parseSystemVersion($xml));
        $response->setStatus($this->parseStatus($xml));
        $response->setOperatorId($this->parseOperatorId($xml));
        $response->setOperatorDomain($this->parseOperatorDomain($xml));
        $response->setOperatorExternalId($this->parseOperatorExternalId($xml));
        $response->setExpirationDate($this->parseExpirationDate($xml));
        $response->setInsuranceStatus($this->parseInsuranceStatus($xml));
        $response->setPrescriptionSymbol($this->parsePrescriptionSymbol($xml));
        $response->setPatientPesel($this->parsePatientPesel($xml));
        $response->setPatientFirstName($this->parsePatientFirstName($xml));
        $response->setPatientLastName($this->parsePatientLastName($xml));
        $response->setPatientNotes($this->parsePatientNotes($xml));

        return $response;
    }

    private function parseResponseStatus(Xml $xml): ?DOMElement
    {
        return $xml->get('//ewus:status_cwu_odp');
    }

    private function parseSystem(Xml $xml): ?DOMElement
    {
        return $xml->get('//ewus:system_nfz');
    }

    private function parseOperationDate(Xml $xml): ?DateTimeImmutable
    {
        $status = $this->parseResponseStatus($xml);

        if ($status === null) {
            return null;
        }

        $operationDate = $status->getAttribute('data_czas_operacji');

        if (empty($operationDate)) {
            return null;
        }

        return new DateTimeImmutable($operationDate);
    }

    private function parseOperationId(Xml $xml): ?string
    {
        $status = $this->parseResponseStatus($xml);

        if ($status === null) {
            return null;
        }

        return $status->getAttribute('id_operacji');
    }

    private function parseSystemName(Xml $xml): ?string
    {
        $system = $this->parseSystem($xml);

        if ($system === null) {
            return null;
        }

        return $system->getAttribute('nazwa');
    }

    private function parseSystemVersion(Xml $xml): ?string
    {
        $system = $this->parseSystem($xml);

        if ($system === null) {
            return null;
        }

        return $system->getAttribute('wersja');
    }

    private function parseStatus(Xml $xml): ?int
    {
        $status = $xml->get('//ewus:status_cwu');
        $value  = $status->nodeValue ?? '';

        if ($value === '-1') {
            return CheckStatus::OUTDATED;
        } elseif ($value === '0') {
            return CheckStatus::MISSING;
        } elseif ($value === '1') {
            return CheckStatus::OK;
        }

        return null;
    }

    private function parseOperatorId(Xml $xml): ?string
    {
        $status = $xml->get('//ewus:id_operatora');

        return $status->nodeValue ?? null;
    }

    private function parseOperatorDomain(Xml $xml): ?string
    {
        $status = $xml->get('//ewus:id_ow');

        return $status->nodeValue ?? null;
    }

    private function parseOperatorExternalId(Xml $xml): ?string
    {
        $status = $xml->get('//ewus:id_swiad');

        return $status->nodeValue ?? null;
    }

    private function parseExpirationDate(Xml $xml): ?DateTimeImmutable
    {
        $status = $xml->get('//ewus:data_waznosci_potwierdzenia');

        if ($status === null) {
            return null;
        }

        $expirationDate = $status->nodeValue;

        if (empty($expirationDate)) {
            return null;
        }

        return (new DateTimeImmutable($expirationDate))->setTime(23, 59, 59);
    }

    private function parseInsuranceStatus(Xml $xml): ?int
    {
        $status = $xml->get('//ewus:status_ubezp');
        $value  = $status->nodeValue ?? '';

        if ($value === '0') {
            return InsuranceStatus::UNINSURED;
        } elseif ($value === '1') {
            return InsuranceStatus::INSURED;
        }

        return null;
    }

    private function parsePrescriptionSymbol(Xml $xml): ?string
    {
        $status = $xml->get('//ewus:status_ubezp');

        if ($status === null) {
            return null;
        }

        return $status->getAttribute('ozn_rec') ?? null;
    }

    private function parsePatientPesel(Xml $xml): ?string
    {
        $pesel = $xml->get('//ewus:numer_pesel');

        return $pesel->nodeValue ?? null;
    }

    private function parsePatientFirstName(Xml $xml): ?string
    {
        $firstName = $xml->get('//ewus:imie');

        return $firstName->nodeValue ?? null;
    }

    private function parsePatientLastName(Xml $xml): ?string
    {
        $lastName = $xml->get('//ewus:nazwisko');

        return $lastName->nodeValue ?? null;
    }

    /**
     * Parse patient notes.
     *
     * @param   \NGT\Ewus\Support\Xml  $xml
     * @return  string[][]
     */
    private function parsePatientNotes(Xml $xml): array
    {
        $output = [];
        $notes  = $xml->query('//ewus:informacje_dodatkowe/ewus:informacja');

        foreach ($notes as $note) {
            $output[] = [
                'code'  => $note->getAttribute('kod'),
                'level' => $note->getAttribute('poziom'),
                'value' => $note->getAttribute('wartosc'),
            ];
        }

        return $output;
    }
}
