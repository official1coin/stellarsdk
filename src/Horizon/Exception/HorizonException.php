<?php


namespace OneCoin\StellarSdk\Horizon\Exception;


use GuzzleHttp\Exception\ClientException;
use Throwable;

class HorizonException extends \ErrorException
{
    /**
     * Usually a URL referencing additional documentation
     *
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $detail;

    /**
     * Horizon instance ID
     *
     * @var string
     */
    protected $instance;

    /**
     * URL that was requested and generated the error
     *
     * @var string
     */
    protected $requestedUrl;

    /**
     * HTTP method used to request $requestedUrl
     *
     * @var string
     */
    protected $httpMethod;

    /**
     * @var int
     */
    protected $httpStatusCode;

    /**
     * Original exception generated by the client
     *
     * @var ClientException
     */
    protected $clientException;

    /**
     * Raw response data, if known
     *
     * @var array
     */
    protected $raw;

    /**
     * Result codes for Horizon operations errors.
     *
     * @var string[]
     */
    protected $operationResultCodes;

    /**
     * @var string
     */
    protected $transactionResultCode;

    /**
     * NOTE: changes here may requires changes to PostTransactionException::fromHorizonException
     *
     * @param                 $requestedUrl
     * @param                 $httpMethod
     * @param                 $raw
     * @param ClientException $clientException
     * @return HorizonException
     */
    public static function fromRawResponse($requestedUrl, $httpMethod, $raw, ClientException $clientException = null)
    {
        $title = isset($raw['title']) ? $raw['title'] : 'Unknown Exception';

        $exception = new HorizonException($title, $clientException);
        $exception->title = $title;
        $exception->requestedUrl = $requestedUrl;
        $exception->httpMethod = $httpMethod;

        if (isset($raw['type'])) $exception->type = $raw['type'];
        if (isset($raw['status'])) $exception->httpStatusCode = $raw['status'];
        if (isset($raw['detail'])) $exception->detail = $raw['detail'];
        if (!empty($raw['extras']['result_codes']['operations'])) {
            $exception->operationResultCodes = $raw['extras']['result_codes']['operations'];
        }
        if (!empty($raw['extras']['result_codes']['transaction'])) {
            $exception->transactionResultCode = $raw['extras']['result_codes']['transaction'];
        }

        // Message can contain better info after we've filled out more fields
        $exception->message = $exception->buildMessage();

        $exception->raw = $raw;
        $exception->clientException = $clientException;

        return $exception;
    }

    /**
     * @param string         $title
     * @param Throwable|null $previous
     */
    public function __construct($title, Throwable $previous = null)
    {
        parent::__construct($title, 0, 1, $previous->getFile(), $previous->getLine(), $previous);
    }

    /**
     * @return string
     */
    protected function buildMessage()
    {
        // Additional data used to help the user resolve the error
        $hint = '';

        $message = sprintf(
            '[%s] %s: %s (Requested URL: %s %s)',
            $this->httpStatusCode,
            $this->title,
            $this->detail,
            $this->httpMethod,
            $this->requestedUrl
        );

        if ($this->transactionResultCode) {
            $message .= sprintf(" Tx Result: %s", $this->transactionResultCode);
        }
        if (!empty($this->operationResultCodes)) {
            $message .= sprintf(" Op Results: %s", print_r($this->operationResultCodes, true));
        }

        // Rate limit exceeded
        if ('429' == $this->httpStatusCode) {
            // todo: check response headers and provide better error message
        }

        return $message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    /**
     * @return string
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @param string $instance
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;
    }

    /**
     * @return string
     */
    public function getRequestedUrl()
    {
        return $this->requestedUrl;
    }

    /**
     * @param string $requestedUrl
     */
    public function setRequestedUrl($requestedUrl)
    {
        $this->requestedUrl = $requestedUrl;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @param int $httpStatusCode
     */
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * @return ClientException
     */
    public function getClientException()
    {
        return $this->clientException;
    }

    /**
     * @param ClientException $clientException
     */
    public function setClientException($clientException)
    {
        $this->clientException = $clientException;
    }

    /**
     * Get the result codes from Horizon Response.
     *
     * @return array
     */
    function getOperationResultCodes()
    {
        return $this->operationResultCodes;
    }

    /**
     * Set the result codes from Horizon Response.
     *
     * @param array $operationResultCodes
     */
    function setOperationResultCodes($operationResultCodes)
    {
        $this->operationResultCodes = $operationResultCodes;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @param string $httpMethod
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * @return array
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param array $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    /**
     * @return string
     */
    public function getTransactionResultCode()
    {
        return $this->transactionResultCode;
    }

    /**
     * @param string $transactionResultCode
     */
    public function setTransactionResultCode($transactionResultCode)
    {
        $this->transactionResultCode = $transactionResultCode;
    }
}
