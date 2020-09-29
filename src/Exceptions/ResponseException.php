<?php
declare(strict_types=1);

namespace NGT\Ewus\Exceptions;

use NGT\Ewus\Enums\ExceptionType;
use NGT\Ewus\Support\Xml;

class ResponseException extends EwusException
{
    /**
     * Get exception type.
     *
     * @var  string
     */
    protected $type;

    /**
     * The exception constructor.
     *
     * @param  string  $message
     * @param  int     $code
     * @param  string  $type
     */
    public function __construct(string $message, int $code = 0, string $type = '')
    {
        parent::__construct($message, $code);

        $this->type = $type;
    }

    /**
     * Get exception type.
     *
     * @return  string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Transform XML into exception.
     *
     * @param   \NGT\Ewus\Support\Xml     $xml
     * @return  \NGT\Ewus\Exceptions\ResponseException
     */
    public static function fromXml(Xml $xml): self
    {
        $message = self::getErrorMessage($xml);
        $type    = self::getErrorType($xml);
        $code    = self::getErrorCode($type);

        return new self(html_entity_decode($message), $code, $type);
    }

    /**
     * Get error message from response.
     *
     * @param   \NGT\Ewus\Support\Xml     $xml
     * @return  string
     */
    private static function getErrorMessage(Xml $xml): string
    {
        $error = $xml->get('//com:faultstring');

        if ($error === null) {
            $error = $xml->get('//faultstring');
        }

        return $error->nodeValue ?? '';
    }

    /**
     * Get error type from response.
     *
     * @param   \NGT\Ewus\Support\Xml     $xml
     * @return  string
     */
    private static function getErrorType(Xml $xml): string
    {
        $error = $xml->get('//com:faultcode');

        if ($error === null) {
            return '';
        }

        $type     = $error->nodeValue ?? '';
        [, $type] = explode('.', $type);

        return $type;
    }

    /**
     * Get error code from error type.
     *
     * @param   string  $type
     * @return  int
     */
    private static function getErrorCode(string $type): int
    {
        if ($type === ExceptionType::SERVICE_EXCEPTION) {
            return 503;
        } elseif ($type === ExceptionType::SERVER_EXCEPTION) {
            return 500;
        } elseif ($type === ExceptionType::INPUT_EXCEPTION) {
            return 422;
        } elseif ($type === ExceptionType::AUTHORIZATION_EXCEPTION) {
            return 403;
        } elseif (in_array($type, ExceptionType::AUTHORIZATION_EXCEPTIONS, true)) {
            return 401;
        }

        return 0;
    }
}
