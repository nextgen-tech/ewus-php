<?php
declare(strict_types=1);

namespace Etermed\Ewus;

use Etermed\Ewus\Connections\HttpConnection;
use Etermed\Ewus\Contracts\Connection;
use Etermed\Ewus\Requests\ChangePasswordRequest;
use Etermed\Ewus\Requests\CheckRequest;
use Etermed\Ewus\Requests\LoginRequest;
use Etermed\Ewus\Requests\LogoutRequest;
use Etermed\Ewus\Responses\ChangePasswordResponse;
use Etermed\Ewus\Responses\CheckResponse;
use Etermed\Ewus\Responses\LoginResponse;
use Etermed\Ewus\Responses\LogoutResponse;

final class Ewus
{
    public const NAME = 'etermed/ewus - PHP implementation for eWUŚ service';

    public const VERSION = '0.0.1';

    /**
     * The connection instance.
     *
     * @var  \Etermed\Ewus\Contracts\Connection
     */
    private static $connection;

    /**
     * The sandbox mode indicator.
     *
     * @var  bool
     */
    private static $sandboxMode = false;

    /**
     * The handler instance.
     *
     * @var  \Etermed\Ewus\Handler
     */
    private static $handler;

    /**
     * Get connection instance.
     *
     * @return  \Etermed\Ewus\Contracts\Connection
     */
    private static function connection(): Connection
    {
        if (self::$connection === null) {
            self::$connection = new HttpConnection();
        }

        return self::$connection;
    }

    /**
     * Get handler instance.
     *
     * @return  \Etermed\Ewus\Handler
     */
    private static function handler(): Handler
    {
        if (self::$handler === null) {
            self::$handler = new Handler(self::connection(), self::$sandboxMode);
        }

        return self::$handler;
    }

    /**
     * Set connection type.
     *
     * @param  \Etermed\Ewus\Contracts\Connection  $connection
     * @return void
     */
    public static function setConnection(Connection $connection): void
    {
        self::$connection = $connection;
    }

    /**
     * Enable sandbox mode.
     *
     * @return  void
     */
    public static function enableSandboxMode(): void
    {
        self::$sandboxMode = true;
    }

    /**
     * Login to eWUŚ.
     *
     * @param   string       $domain        The National Health Fund (NFZ) branch code.
     * @param   string       $login         The operator login.
     * @param   string       $password      The operator password.
     * @param   string|null  $operatorId    The operator type code.
     * @param   string|null  $operatorType  The operator identificator.
     * @return  \Etermed\Ewus\Responses\LoginResponse
     * @throws  \Etermed\Ewus\Exceptions\ResponseException
     */
    public static function login(
        string $domain,
        string $login,
        string $password,
        string $operatorId = null,
        string $operatorType = null
    ): LoginResponse {
        $request = new LoginRequest($domain, $login, $password, $operatorId, $operatorType);

        /** @var \Etermed\Ewus\Responses\LoginResponse */
        return self::handler()->handle($request);
    }

    /**
     * Logout from eWUŚ.
     *
     * @param   string  $sessionId
     * @param   string  $token
     * @return  \Etermed\Ewus\Responses\LogoutResponse
     * @throws  \Etermed\Ewus\Exceptions\ResponseException
     */
    public static function logout(string $sessionId, string $token): LogoutResponse
    {
        $request = new LogoutRequest($sessionId, $token);

        /** @var \Etermed\Ewus\Responses\LogoutResponse */
        return self::handler()->handle($request);
    }

    /**
     * Change password.
     *
     * @param   string       $sessionId
     * @param   string       $token
     * @param   string       $domain
     * @param   string       $login
     * @param   string       $oldPassword
     * @param   string       $newPassword
     * @param   string|null  $operatorId
     * @param   string|null  $operatorType
     * @return  \Etermed\Ewus\Responses\ChangePasswordResponse
     * @throws  \Etermed\Ewus\Exceptions\ResponseException
     */
    public static function changePassword(
        string $sessionId,
        string $token,
        string $domain,
        string $login,
        string $oldPassword,
        string $newPassword,
        string $operatorId = null,
        string $operatorType = null
    ): ChangePasswordResponse {
        $request = new ChangePasswordRequest($sessionId, $token, $domain, $login, $oldPassword, $newPassword, $operatorId, $operatorType);

        /** @var \Etermed\Ewus\Responses\ChangePasswordResponse */
        return self::handler()->handle($request);
    }

    /**
     * Check patient status based on its PESEL number.
     *
     * @param   string  $sessionId
     * @param   string  $token
     * @param   string  $pesel
     * @return  \Etermed\Ewus\Responses\CheckResponse
     * @throws  \Etermed\Ewus\Exceptions\ResponseException
     */
    public static function check(string $sessionId, string $token, string $pesel): CheckResponse
    {
        $request = new CheckRequest($sessionId, $token, $pesel);

        /** @var \Etermed\Ewus\Responses\CheckResponse */
        return self::handler()->handle($request);
    }
}
