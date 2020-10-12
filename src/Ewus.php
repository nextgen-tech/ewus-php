<?php
declare(strict_types=1);

namespace NGT\Ewus;

use NGT\Ewus\Connections\HttpConnection;
use NGT\Ewus\Contracts\Connection;
use NGT\Ewus\Requests\ChangePasswordRequest;
use NGT\Ewus\Requests\CheckRequest;
use NGT\Ewus\Requests\LoginRequest;
use NGT\Ewus\Requests\LogoutRequest;
use NGT\Ewus\Responses\ChangePasswordResponse;
use NGT\Ewus\Responses\CheckResponse;
use NGT\Ewus\Responses\LoginResponse;
use NGT\Ewus\Responses\LogoutResponse;

final class Ewus
{
    public const NAME = 'ngt/ewus - PHP implementation for eWUŚ service';

    public const VERSION = '1.0.0';

    /**
     * The connection instance.
     *
     * @var  \NGT\Ewus\Contracts\Connection
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
     * @var  \NGT\Ewus\Handler
     */
    private static $handler;

    /**
     * Get connection instance.
     *
     * @return  \NGT\Ewus\Contracts\Connection
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
     * @return  \NGT\Ewus\Handler
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
     * @param  \NGT\Ewus\Contracts\Connection  $connection
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
     * @return  \NGT\Ewus\Responses\LoginResponse
     * @throws  \NGT\Ewus\Exceptions\ResponseException
     */
    public static function login(
        string $domain,
        string $login,
        string $password,
        string $operatorId = null,
        string $operatorType = null
    ): LoginResponse {
        $request = new LoginRequest($domain, $login, $password, $operatorId, $operatorType);

        /** @var \NGT\Ewus\Responses\LoginResponse */
        return self::handler()->handle($request);
    }

    /**
     * Logout from eWUŚ.
     *
     * @param   string  $sessionId
     * @param   string  $token
     * @return  \NGT\Ewus\Responses\LogoutResponse
     * @throws  \NGT\Ewus\Exceptions\ResponseException
     */
    public static function logout(string $sessionId, string $token): LogoutResponse
    {
        $request = new LogoutRequest($sessionId, $token);

        /** @var \NGT\Ewus\Responses\LogoutResponse */
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
     * @return  \NGT\Ewus\Responses\ChangePasswordResponse
     * @throws  \NGT\Ewus\Exceptions\ResponseException
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

        /** @var \NGT\Ewus\Responses\ChangePasswordResponse */
        return self::handler()->handle($request);
    }

    /**
     * Check patient status based on its PESEL number.
     *
     * @param   string  $sessionId
     * @param   string  $token
     * @param   string  $pesel
     * @return  \NGT\Ewus\Responses\CheckResponse
     * @throws  \NGT\Ewus\Exceptions\ResponseException
     */
    public static function check(string $sessionId, string $token, string $pesel): CheckResponse
    {
        $request = new CheckRequest($sessionId, $token, $pesel);

        /** @var \NGT\Ewus\Responses\CheckResponse */
        return self::handler()->handle($request);
    }
}
