<?php


namespace Tests;

use GuzzleHttp\Psr7\ServerRequest;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\BrowserKit\Response;

class Client extends AbstractBrowser
{
    protected function doRequest($request)
    {
        if (!defined('BASE_DIR')) {
            define('BASE_DIR', realpath(__DIR__.'/../').DIRECTORY_SEPARATOR);
        }
        if (!defined('PLATFORM_VERSION')) {
            define('PLATFORM_VERSION', json_decode(file_get_contents(BASE_DIR.'composer.json'))->version);
        }

        /** @var \Slim\App $app */
        $app = require BASE_DIR.'bootstrap/app.php';
        $response = $app->handle(new ServerRequest($request->getMethod(), $request->getUri(), [], $request->getContent()));


        return new Response($response->getBody()->getContents(), $response->getStatusCode(), $response->getHeaders());
    }
}
