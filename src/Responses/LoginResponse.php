<?php
declare(strict_types=1);

namespace Etermed\Ewus\Responses;

use Etermed\Ewus\Contracts\Response as ResponseContract;

class LoginResponse extends Response implements ResponseContract
{
    /**
     * The session identificator.
     *
     * @var  string|null
     */
    protected $sessionId;

    /**
     * The authorization token.
     *
     * @var  string|null
     */
    protected $token;

    /**
     * The login code.
     *
     * @var  string|null
     */
    protected $loginCode;

    /**
     * The login message.
     *
     * @var  string|null
     */
    protected $loginMessage;

    /**
     * Set session identificator.
     *
     * @param  string|null  $sessionId
     */
    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Set autorization token.
     *
     * @param  string|null  $token
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set login code.
     *
     * @param  string|null  $loginCode
     */
    public function setLoginCode(?string $loginCode): self
    {
        $this->loginCode = $loginCode;

        return $this;
    }

    /**
     * Set login message.
     *
     * @param  string|null  $loginMessage
     */
    public function setLoginMessage(?string $loginMessage): self
    {
        $this->loginMessage = $loginMessage;

        return $this;
    }

    /**
     * Get session identificator.
     *
     * @return  string|null
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * Get authorization token.
     *
     * @return  string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Get login code.
     *
     * @return  string|null
     */
    public function getLoginCode(): ?string
    {
        return $this->loginCode;
    }

    /**
     * Get login message.
     *
     * @return  string|null
     */
    public function getLoginMessage(): ?string
    {
        return $this->loginMessage;
    }
}
