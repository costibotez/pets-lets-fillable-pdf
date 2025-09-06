<?php

namespace {
    if (\class_exists('Google_Client', \false)) {
        // Prevent error with preloading in PHP 7.4
        // @see https://github.com/googleapis/google-api-php-client/issues/1976
        return;
    }
    $classMap = ['ForGravity\\Fillable_PDFs\\Google\\Client' => 'Google_Client', 'ForGravity\\Fillable_PDFs\\Google\\Service' => 'Google_Service', 'ForGravity\\Fillable_PDFs\\Google\\AccessToken\\Revoke' => 'Google_AccessToken_Revoke', 'ForGravity\\Fillable_PDFs\\Google\\AccessToken\\Verify' => 'Google_AccessToken_Verify', 'ForGravity\\Fillable_PDFs\\Google\\Model' => 'Google_Model', 'ForGravity\\Fillable_PDFs\\Google\\Utils\\UriTemplate' => 'Google_Utils_UriTemplate', 'ForGravity\\Fillable_PDFs\\Google\\AuthHandler\\Guzzle6AuthHandler' => 'Google_AuthHandler_Guzzle6AuthHandler', 'ForGravity\\Fillable_PDFs\\Google\\AuthHandler\\Guzzle7AuthHandler' => 'Google_AuthHandler_Guzzle7AuthHandler', 'ForGravity\\Fillable_PDFs\\Google\\AuthHandler\\AuthHandlerFactory' => 'Google_AuthHandler_AuthHandlerFactory', 'ForGravity\\Fillable_PDFs\\Google\\Http\\Batch' => 'Google_Http_Batch', 'ForGravity\\Fillable_PDFs\\Google\\Http\\MediaFileUpload' => 'Google_Http_MediaFileUpload', 'ForGravity\\Fillable_PDFs\\Google\\Http\\REST' => 'Google_Http_REST', 'ForGravity\\Fillable_PDFs\\Google\\Task\\Retryable' => 'Google_Task_Retryable', 'ForGravity\\Fillable_PDFs\\Google\\Task\\Exception' => 'Google_Task_Exception', 'ForGravity\\Fillable_PDFs\\Google\\Task\\Runner' => 'Google_Task_Runner', 'ForGravity\\Fillable_PDFs\\Google\\Collection' => 'Google_Collection', 'ForGravity\\Fillable_PDFs\\Google\\Service\\Exception' => 'Google_Service_Exception', 'ForGravity\\Fillable_PDFs\\Google\\Service\\Resource' => 'Google_Service_Resource', 'ForGravity\\Fillable_PDFs\\Google\\Exception' => 'Google_Exception'];
    foreach ($classMap as $class => $alias) {
        \class_alias($class, $alias);
    }
    /**
     * This class needs to be defined explicitly as scripts must be recognized by
     * the autoloader.
     */
    class Google_Task_Composer extends \ForGravity\Fillable_PDFs\Google\Task\Composer
    {
    }
    /** @phpstan-ignore-next-line */
    if (\false) {
        class Google_AccessToken_Revoke extends \ForGravity\Fillable_PDFs\Google\AccessToken\Revoke
        {
        }
        class Google_AccessToken_Verify extends \ForGravity\Fillable_PDFs\Google\AccessToken\Verify
        {
        }
        class Google_AuthHandler_AuthHandlerFactory extends \ForGravity\Fillable_PDFs\Google\AuthHandler\AuthHandlerFactory
        {
        }
        class Google_AuthHandler_Guzzle6AuthHandler extends \ForGravity\Fillable_PDFs\Google\AuthHandler\Guzzle6AuthHandler
        {
        }
        class Google_AuthHandler_Guzzle7AuthHandler extends \ForGravity\Fillable_PDFs\Google\AuthHandler\Guzzle7AuthHandler
        {
        }
        class Google_Client extends \ForGravity\Fillable_PDFs\Google\Client
        {
        }
        class Google_Collection extends \ForGravity\Fillable_PDFs\Google\Collection
        {
        }
        class Google_Exception extends \ForGravity\Fillable_PDFs\Google\Exception
        {
        }
        class Google_Http_Batch extends \ForGravity\Fillable_PDFs\Google\Http\Batch
        {
        }
        class Google_Http_MediaFileUpload extends \ForGravity\Fillable_PDFs\Google\Http\MediaFileUpload
        {
        }
        class Google_Http_REST extends \ForGravity\Fillable_PDFs\Google\Http\REST
        {
        }
        class Google_Model extends \ForGravity\Fillable_PDFs\Google\Model
        {
        }
        class Google_Service extends \ForGravity\Fillable_PDFs\Google\Service
        {
        }
        class Google_Service_Exception extends \ForGravity\Fillable_PDFs\Google\Service\Exception
        {
        }
        class Google_Service_Resource extends \ForGravity\Fillable_PDFs\Google\Service\Resource
        {
        }
        class Google_Task_Exception extends \ForGravity\Fillable_PDFs\Google\Task\Exception
        {
        }
        interface Google_Task_Retryable extends \ForGravity\Fillable_PDFs\Google\Task\Retryable
        {
        }
        class Google_Task_Runner extends \ForGravity\Fillable_PDFs\Google\Task\Runner
        {
        }
        class Google_Utils_UriTemplate extends \ForGravity\Fillable_PDFs\Google\Utils\UriTemplate
        {
        }
    }
}
