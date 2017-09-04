<?php namespace Proxy\Filter;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PredicateFilter implements FilterInterface {
  $request_predicates = [];
  $response_predicates = [];

  function __construct($request, $response)
  {
    $this->request_predicates = $request;
    $this->response_predicates = $response;
  }

  /**
   * @inheritdoc
   */
  public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
  {
    if ($this->request_predicates != null) {
      $request = $this->request_predicates->call($request);
    }

    $response = $next($request, $response);

    if ($this->response_predicates != null) {
      $response = $this->response_predicates->call($response);
    }
    return $response;
  }
}
