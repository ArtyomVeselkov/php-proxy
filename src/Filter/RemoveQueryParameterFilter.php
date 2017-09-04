<?php namespace Proxy\Filter;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;

class RemoveQueryParameterFilter implements FilterInterface
{
    /**
     * List of query parameters that will be removed from the request.
     *
     * @var string
     */
    private $excludedParams = [];

    public function __construct($params)
    {
      $this->excludedParams = $params;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
      $uri = $request->getUri();
      foreach($this->excludedParams as $param)
      {
        $uri = Psr7\Uri::withoutQueryValue($uri, $param);
      }
      $request = $request->withUri($uri);

      $response = $next($request, $response);
      return $response;
    }
}
