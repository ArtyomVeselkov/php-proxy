<?php namespace Proxy\Predicate;

use Zend\Diactoros\Request;
use Proxy\Filter\RemoveLocationFilter;

class PredicateListTest extends \PHPUnit_Framework_TestCase
{
    private function doRequest($uri)
    {
      $request = new Request($uri);
      $predicate = new HasPath('test');

      $filter = new RemoveLocationFilter();

      $requestAction = function() use($request) { return $request->withHeader('foo', 'bar'); };

      $list = new PredicateList([
        new HasPath('test'),
        new HasPath('123'),
      ], $requestAction);

      return $list->call($request);
    }

    /**
     * @test
     */
    public function executes_matching_predicate()
    {
      $request = $this->doRequest('http://wwww.example.com/test/123');
      $this->assertEquals('bar', $request->getHeaderLine('foo'));
    }

    /**
     * @test
     */
    public function does_not_execute_when_not_matching()
    {
      $request = $this->doRequest('http://wwww.example.com/abc/123');
      $this->assertFalse($request->hasHeader('foo'));
    }
}
