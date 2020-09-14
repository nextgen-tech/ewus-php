<?php
declare(strict_types=1);

namespace Etermed\Ewus\Responses;

use Etermed\Ewus\Contracts\Response as ResponseContract;

class LogoutResponse extends Response implements ResponseContract
{
    /**
     * The logout message.
     *
     * @var  string|null
     */
    protected $logoutMessage;

    /**
     * Set logout message.
     *
     * @param  string  $logoutMessage
     */
    public function setLogoutMessage(?string $logoutMessage): self
    {
        $this->logoutMessage = $logoutMessage;

        return $this;
    }

    /**
     * Get logout message.
     *
     * @return  string|null
     */
    public function getLogoutMessage(): ?string
    {
        return $this->logoutMessage;
    }
}
