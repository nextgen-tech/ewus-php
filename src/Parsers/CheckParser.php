<?php
declare(strict_types=1);

namespace Etermed\Ewus\Parsers;

use DateTimeImmutable;
use DOMElement;
use Etermed\Ewus\Contracts\Parser as ParserContract;
use Etermed\Ewus\Contracts\Response;
use Etermed\Ewus\Enums\CheckStatus;
use Etermed\Ewus\Enums\InsuranceStatus;
use Etermed\Ewus\Responses\CheckResponse;
use Etermed\Ewus\Support\Xml;

class CheckParser extends Parser implements ParserContract
{
    public function parse(Xml $xml): Response
    {
        $xml->registerNamespace('ewus');

        $response = new CheckResponse($this->request);

        if (($operationDate = $this->parseOperationDate($xml)) !== null) {
            $response->setOperationDate($operationDate);
        }

        if (($operationId = $this->parseOperationId($xml)) !== null) {
            $response->setOperationId($operationId);
        }

        if (($systemName = $this->parseSystemName($xml)) !== null) {
            $response->setSystemName($systemName);
        }

        if (($systemVersion = $this->parseSystemVersion($xml)) !== null) {
            $response->setSystemVersion($systemVersion);
        }

        if (($status = $this->parseStatus($xml)) !== null) {
            $response->setStatus($status);
        }

        if (($operatorId = $this->parseOperatorId($xml)) !== null) {
            $response->setOperatorId($operatorId);
        }

        if (($operatorDomain = $this->parseOperatorDomain($xml)) !== null) {
            $response->setOperatorDomain($operatorDomain);
        }

        if (($operatorExternalId = $this->parseOperatorExternalId($xml)) !== null) {
            $response->setOperatorExternalId($operatorExternalId);
        }

        if (($expirationDate = $this->parseExpirationDate($xml)) !== null) {
            $response->setExpirationDate($expirationDate);
        }

        if (($insuranceStatus = $this->parseInsuranceStatus($xml)) !== null) {
            $response->setInsuranceStatus($insuranceStatus);
        }

        if (($prescriptionSymbol = $this->parsePrescriptionSymbol($xml)) !== null) {
            $response->setPrescriptionSymbol($prescriptionSymbol);
        }

        if (($patientPesel = $this->parsePatientPesel($xml)) !== null) {
            $response->setPatientPesel($patientPesel);
        }

        if (($patientFirstName = $this->parsePatientFirstName($xml)) !== null) {
            $response->setPatientFirstName($patientFirstName);
        }

        if (($patientLastName = $this->parsePatientLastName($xml)) !== null) {
            $response->setPatientLastName($patientLastName);
        }

        if (($patientNotes = $this->parsePatientNotes($xml)) !== null) {
            $response->setPatientNotes($patientNotes);
        }

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
     * @param   \Etermed\Ewus\Support\Xml  $xml
     * @return  array[]
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
