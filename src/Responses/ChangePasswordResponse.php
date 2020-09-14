<?php
declare(strict_types=1);

namespace Etermed\Ewus\Responses;

use Etermed\Ewus\Contracts\Response as ResponseContract;

class ChangePasswordResponse extends Response implements ResponseContract
{
    /**
     * The change password message.
     *
     * @var  string|null
     */
    protected $changePasswordMessage;

    /**
     * Set change password message.
     *
     * @param  string  $changePasswordMessage
     */
    public function setChangePasswordMessage(?string $changePasswordMessage): self
    {
        $this->changePasswordMessage = $changePasswordMessage;

        return $this;
    }

    /**
     * Get change password message.
     *
     * @return  string|null
     */
    public function getChangePasswordMessage(): ?string
    {
        return $this->changePasswordMessage;
    }
}
