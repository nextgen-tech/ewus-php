<?php
declare(strict_types=1);

namespace Etermed\Ewus\Enums;

class ExceptionType
{
    const SERVICE_EXCEPTION = 'ServiceException';

    const SERVER_EXCEPTION = 'ServerException';

    const INPUT_EXCEPTION = 'InputException';

    const AUTHORIZATION_EXCEPTION = 'AuthorizationException';

    const AUTH_TOKEN_EXCEPTION = 'AuthTokenException';

    const SESSION_EXCEPTION = 'SessionException';

    const AUTHENTICATION_EXCEPTION = 'AuthenticationException';

    const AUTHORIZATION_EXCEPTIONS = [
        self::AUTH_TOKEN_EXCEPTION,
        self::SESSION_EXCEPTION,
        self::AUTHENTICATION_EXCEPTION,
    ];
}
