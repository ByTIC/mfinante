<?php

namespace ByTIC\MFinante\Clients\PhantomJs;

use JonnyW\PhantomJs\Client as PhantomJsBaseClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PhantomJsClientBridge
 * @package ByTIC\MFinante\Clients
 */
class ClientBridge implements GuzzleClientInterface
{
    protected $phantomJsClient = null;

    /**
     * @inheritdoc
     */
    public function request($method, $uri = '', array $options = [])
    {
        $client = $this->getPhantomJsClient();

        /**
         * @see \JonnyW\PhantomJs\Http\Request
         **/
        $request = $client->getMessageFactory()->createRequest($uri, $method);
        $request->addHeader(
            'User-Agent',
            'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0'
        );
        /** IMPORTANT - the delay is necessary to make sure the javascript is all loaded */
        $request->setDelay(12);

        /**
         * @see \JonnyW\PhantomJs\Http\Response
         **/
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);

        return ResponseFormatter::format($response);
    }

    /**
     * @inheritdoc
     */
    public function requestAsync($method, $uri = '', array $options = [])
    {
    }

    /**
     * @inheritdoc
     */
    public function send(RequestInterface $request, array $options = [])
    {
    }

    /**
     * @inheritdoc
     */
    public function sendAsync(RequestInterface $request, array $options = [])
    {
    }

    /**
     * @inheritdoc
     */
    public function getConfig($option = null)
    {
    }

    /**
     * @return PhantomJsBaseClient|null
     */
    protected function getPhantomJsClient()
    {
        if ($this->phantomJsClient === null) {
            $this->phantomJsClient = PhantomJsBaseClient::getInstance();

            $uname = strtolower(php_uname());

            if (strpos($uname, 'win') !== false) {
                $this->phantomJsClient->getEngine()->setPath(dirname(dirname(dirname(__DIR__))) . '/bin/phantomjs.exe');

            }
        }
        return $this->phantomJsClient;
    }
}
