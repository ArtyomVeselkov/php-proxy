<?php namespace Proxy\Filter;

use Proxy\Predicate\PredicateList;
use Proxy\Predicate\HasHeader;
use Proxy\Action\RemoveHeaderAction;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RemoveLocationFilter extends AbstractPredicateFilter {

    const LOCATION = 'location';

    protected function getRequestPredicateList() {
      return null;
    }

    protected function getResponsePredicateList() {
      return new PredicateList([new HasHeader(self::LOCATION)], new RemoveHeaderAction(self::LOCATION));
    }


}
