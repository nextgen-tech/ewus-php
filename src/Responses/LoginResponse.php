<?php
declare(strict_types=1);

namespace NGT\Ewus\Responses;

use NGT\Ewus\Contracts\Response as ResponseContract;

class LoginResponse extends Response implements ResponseContract
{
    /**
     * The session identificator.
     *
     * @var  string
     */
    protected $sessionId;

    /**
     * The authorization token.
     *
     * @var  string
     */
    protected $token;

    /**
     * The login code.
     *
     * @var  string
     */
    protected $loginCode;

    /**
     * The login message.
     *
     * @var  string
     */
    protected $loginMessage;

    /**
     * Set session identificator.
     *
     * @param  string  $sessionId
     */
    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Set autorization token.
     *
     * @param  string  $token
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set login code.
     *
     * @param  string  $loginCode
     */
    public function setLoginCode(string $loginCode): self
    {
        $this->loginCode = $loginCode;

        return $this;
    }

    /**
     * Set login message.
     *
     * @param  string  $loginMessage
     */
    public function setLoginMessage(string $loginMessage): self
    {
        $this->loginMessage = $loginMessage;

        return $this;
    }

    /**
     * Get session identificator.
     *
     * @return  string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * Get authorization token.
     *
     * @return  string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get login code.
     *
     * @return  string
     */
    public function getLoginCode(): string
    {
        return $this->loginCode;
    }

    /**
     * Get login message.
     *
     * @return  string
     */
    public function getLoginMessage(): string
    {
        return $this->loginMessage;
    }
}
