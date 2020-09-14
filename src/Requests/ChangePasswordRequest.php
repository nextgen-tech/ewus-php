<?php
declare(strict_types=1);

namespace Etermed\Ewus\Requests;

use Etermed\Ewus\Contracts\Parser as ParserContract;
use Etermed\Ewus\Contracts\Request as RequestContract;
use Etermed\Ewus\Contracts\Service as ServiceContract;
use Etermed\Ewus\Parsers\ChangePasswordParser;
use Etermed\Ewus\Services\AuthService;
use Etermed\Ewus\Support\XmlNamespace;
use Etermed\Ewus\Traits\Authorizeable;
use InvalidArgumentException;

class ChangePasswordRequest extends Request implements RequestContract
{
    use Authorizeable;

    /**
     * The connection session identificator.
     *
     * @var  string
     */
    protected $sessionId;

    /**
     * The connection authorization token.
     *
     * @var  string
     */
    protected $token;

    /**
     * The old password.
     *
     * @var  string
     */
    protected $oldPassword;

    /**
     * The new password.
     *
     * @var  string
     */
    protected $newPassword;

    /**
     * The change password request constructor.
     *
     * @param  string|null  $sessionId
     * @param  string|null  $token
     * @param  string|null  $domain
     * @param  string|null  $login
     * @param  string|null  $oldPassword
     * @param  string|null  $newPassword
     * @param  string|null  $operatorId
     * @param  string|null  $operatorType
     */
    public function __construct(
        string $sessionId = null,
        string $token = null,
        string $domain = null,
        string $login = null,
        string $oldPassword = null,
        string $newPassword = null,
        string $operatorId = null,
        string $operatorType = null
    ) {
        if ($sessionId !== null) {
            $this->setSessionId($sessionId);
        }

        if ($token !== null) {
            $this->setToken($token);
        }

        if ($domain !== null) {
            $this->setDomain($domain);
        }

        if ($login !== null) {
            $this->setLogin($login);
        }

        if ($oldPassword !== null) {
            $this->setOldPassword($oldPassword);
        }

        if ($newPassword !== null) {
            $this->setNewPassword($newPassword);
        }

        $this->setOperatorId($operatorId);
        $this->setOperatorType($operatorType);
    }

    /**
     * @inheritDoc
     */
    public function getParser(): ParserContract
    {
        return new ChangePasswordParser($this);
    }

    /**
     * @inheritDoc
     */
    public function getService(): ServiceContract
    {
        return new AuthService();
    }

    /**
     * Set request session identificator.
     *
     * @param  string  $sessionId
     */
    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Set request authorization token.
     *
     * @param  string  $token
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set old password.
     *
     * @param  string  $oldPassword
     */
    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    /**
     * Set new password.
     *
     * @param  string  $newPassword
     */
    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * Get request session identificator.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getSessionId(): string
    {
        if ($this->sessionId === null) {
            throw new InvalidArgumentException('Missing session identificator parameter.');
        }

        return $this->sessionId;
    }

    /**
     * Get request authorization token.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getToken(): string
    {
        if ($this->token === null) {
            throw new InvalidArgumentException('Missing authorization token parameter.');
        }

        return $this->token;
    }

    /**
     * Get old password.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getOldPassword(): string
    {
        if ($this->oldPassword === null) {
            throw new InvalidArgumentException('Missing old password parameter.');
        }

        return $this->oldPassword;
    }

    /**
     * Get new password.
     *
     * @return  string
     * @throws  InvalidArgumentException
     */
    public function getNewPassword(): string
    {
        if ($this->newPassword === null) {
            throw new InvalidArgumentException('Missing new password parameter.');
        }

        return $this->newPassword;
    }

    /**
     * @inheritDoc
     */
    protected function envelopeNamespaces(): array
    {
        return array_merge(parent::envelopeNamespaces(), [
            'xmlns:com'  => XmlNamespace::get('com'),
            'xmlns:auth' => XmlNamespace::get('auth'),
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function envelopeHeader(): array
    {
        return [
            'com:session' => [
                '_attributes' => [
                    'id' => $this->getSessionId(),
                ],
            ],
            'com:authToken' => [
                '_attributes' => [
                    'id' => $this->getToken(),
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function envelopeBody(): array
    {
        return [
            'auth:changePassword' => [
                'auth:credentials' => [
                    'auth:item' => $this->authCredentials(),
                ],
                'auth:oldPassword'       => $this->getOldPassword(),
                'auth:newPassword'       => $this->getNewPassword(),
                'auth:newPasswordRepeat' => $this->getNewPassword(),
            ],
        ];
    }
}
