<?php namespace Proxy\Filter;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractPredicateFilter implements FilterInterface {
  protected abstract function getRequestPredicateList();
  protected abstract function getResponsePredicateList();

  /**
   * @inheritdoc
   */
  public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
  {
    $list = $this->getRequestPredicateList();
    if ($list != null) {
      $request = $list->call($request);
    }
    $response = $next($request, $response);

    $list = $this->getResponsePredicateList();
    if ($list != null) {
      $response = $list->call($response);
    }
    return $response;
  }
}
