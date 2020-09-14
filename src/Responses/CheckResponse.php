<?php
declare(strict_types=1);

namespace Etermed\Ewus\Responses;

use DateTimeInterface;
use Etermed\Ewus\Contracts\Response as ResponseContract;

class CheckResponse extends Response implements ResponseContract
{
    /**
     * The operation date.
     *
     * @var  DateTimeInterface
     */
    protected $operationDate;

    /**
     * The operation identificator.
     *
     * @var  string
     */
    protected $operationId;

    /**
     * The system (server application) name.
     *
     * @var  string
     */
    protected $systemName;

    /**
     * The system (server application) version.
     *
     * @var  string
     */
    protected $systemVersion;

    /**
     * The status of data in remote system.
     *
     * @var  int
     */
    protected $status;

    /**
     * The operator identificator.
     *
     * @var  string
     */
    protected $operatorId;

    /**
     * The operator domain.
     *
     * @var  string
     */
    protected $operatorDomain;

    /**
     * The operator external identificator.
     *
     * @var  string
     */
    protected $operatorExternalId;

    /**
     * The expiration date of check.
     *
     * @var  DateTimeInterface
     */
    protected $expirationDate;

    /**
     * The status of patient insurance.
     *
     * @var  int
     */
    protected $insuranceStatus;

    /**
     * The prescription symbol.
     *
     * @var  string
     */
    protected $prescriptionSymbol;

    /**
     * The patient PESEL.
     *
     * @var  string
     */
    protected $patientPesel;

    /**
     * The patient first name.
     *
     * @var  string
     */
    protected $patientFirstName;

    /**
     * The patient last name.
     *
     * @var  string
     */
    protected $patientLastName;

    /**
     * The patient notes.
     *
     * @var  array[]
     */
    protected $patientNotes = [];

    /**
     * Set the operation date.
     *
     * @param  DateTimeInterface  $operationDate
     */
    public function setOperationDate(DateTimeInterface $operationDate): self
    {
        $this->operationDate = $operationDate;

        return $this;
    }

    /**
     * Set the operation identificator.
     *
     * @param  string  $operationId
     */
    public function setOperationId(string $operationId): self
    {
        $this->operationId = $operationId;

        return $this;
    }

    /**
     * Set the system (server application) name.
     *
     * @param  string  $systemName
     */
    public function setSystemName(string $systemName): self
    {
        $this->systemName = $systemName;

        return $this;
    }

    /**
     * Set the system (server application) version.
     *
     * @param  string  $systemVersion
     */
    public function setSystemVersion(string $systemVersion): self
    {
        $this->systemVersion = $systemVersion;

        return $this;
    }

    /**
     * Set the status of data in remote system.
     *
     * @param  int  $status
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the operator identificator.
     *
     * @param  string  $operatorId
     */
    public function setOperatorId(string $operatorId): self
    {
        $this->operatorId = $operatorId;

        return $this;
    }

    /**
     * Set the operator domain.
     *
     * @param  string  $operatorDomain
     */
    public function setOperatorDomain(string $operatorDomain): self
    {
        $this->operatorDomain = $operatorDomain;

        return $this;
    }

    /**
     * Set the operator external identificator.
     *
     * @param  string  $operatorExternalId
     */
    public function setOperatorExternalId(string $operatorExternalId): self
    {
        $this->operatorExternalId = $operatorExternalId;

        return $this;
    }

    /**
     * Set the expiration date of check.
     *
     * @param  DateTimeInterface  $expirationDate
     */
    public function setExpirationDate(DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Set the status of patient insurance.
     *
     * @param  int  $insuranceStatus
     */
    public function setInsuranceStatus(int $insuranceStatus): self
    {
        $this->insuranceStatus = $insuranceStatus;

        return $this;
    }

    /**
     * Set the prescription symbol.
     *
     * @param  string  $prescriptionSymbol
     */
    public function setPrescriptionSymbol(string $prescriptionSymbol): self
    {
        $this->prescriptionSymbol = $prescriptionSymbol;

        return $this;
    }

    /**
     * Set the patient PESEL.
     *
     * @param  string  $patientPesel
     */
    public function setPatientPesel(string $patientPesel): self
    {
        $this->patientPesel = $patientPesel;

        return $this;
    }

    /**
     * Set the patient first name.
     *
     * @param  string  $patientFirstName
     */
    public function setPatientFirstName(string $patientFirstName): self
    {
        $this->patientFirstName = $patientFirstName;

        return $this;
    }

    /**
     * Set the patient last name.
     *
     * @param  string  $patientLastName
     */
    public function setPatientLastName(string $patientLastName): self
    {
        $this->patientLastName = $patientLastName;

        return $this;
    }

    /**
     * Set the patient notes.
     *
     * @param  array[]  $patientNotes
     */
    public function setPatientNotes(array $patientNotes): self
    {
        $this->patientNotes = $patientNotes;

        return $this;
    }

    /**
     * Get the operation date.
     *
     * @return  DateTimeInterface
     */
    public function getOperationDate(): DateTimeInterface
    {
        return $this->operationDate;
    }

    /**
     * Get the operation identificator.
     *
     * @return  string
     */
    public function getOperationId(): string
    {
        return $this->operationId;
    }

    /**
     * Get the system (server application) name.
     *
     * @return  string
     */
    public function getSystemName(): string
    {
        return $this->systemName;
    }

    /**
     * Get the system (server application) version.
     *
     * @return  string
     */
    public function getSystemVersion(): string
    {
        return $this->systemVersion;
    }

    /**
     * Get the status of data in remote system.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Get the operator identificator.
     *
     * @return  string
     */
    public function getOperatorId(): string
    {
        return $this->operatorId;
    }

    /**
     * Get the operator domain.
     *
     * @return  string
     */
    public function getOperatorDomain(): string
    {
        return $this->operatorDomain;
    }

    /**
     * Get the operator external identificator.
     *
     * @return  string
     */
    public function getOperatorExternalId(): string
    {
        return $this->operatorExternalId;
    }

    /**
     * Get the expiration date of check.
     *
     * @return  DateTimeInterface
     */
    public function getExpirationDate(): DateTimeInterface
    {
        return $this->expirationDate;
    }

    /**
     * Get the status of patient insurance.
     *
     * @return  int
     */
    public function getInsuranceStatus(): int
    {
        return $this->insuranceStatus;
    }

    /**
     * Get the prescription symbol.
     *
     * @return  string
     */
    public function getPrescriptionSymbol(): string
    {
        return $this->prescriptionSymbol;
    }

    /**
     * Get the patient PESEL.
     *
     * @return  string
     */
    public function getPatientPesel(): string
    {
        return $this->patientPesel;
    }

    /**
     * Get the patient first name.
     *
     * @return  string
     */
    public function getPatientFirstName(): string
    {
        return $this->patientFirstName;
    }

    /**
     * Get the patient last name.
     *
     * @return  string
     */
    public function getPatientLastName(): string
    {
        return $this->patientLastName;
    }

    /**
     * Get the patient notes.
     *
     * @return  array[]
     */
    public function getPatientNotes(): array
    {
        return $this->patientNotes;
    }
}
