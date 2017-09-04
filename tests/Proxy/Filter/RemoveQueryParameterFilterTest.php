<?php namespace Proxy\Filter;

use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class RemoveQueryParmaterFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RemoveQueryParmaterFilterTest
     */
    private $filter;

    public function setUp()
    {
        $this->filter = new RemoveQueryParameterFilter(['p', 'z']);
    }

    private function getRequestQuery($uri)
    {
      $request = new Request($uri);
      $response = new Response('php://memory', 200);
      $filter_query = '';
      $next = function ($req, $resp) use ($response, &$filter_query) {
        $filter_query = $req->getUri()->getQuery();
        return $response;
      };
      $response = call_user_func($this->filter, $request, $response, $next);
      return $filter_query;
    }

    /**
     * @test
     */
    public function filter_removes_specified_parameters()
    {
        $filter_query = $this->getRequestQuery('http://example.com?p=123&a=456');
        $this->assertEquals('a=456', $filter_query);
    }

    /**
     * @test
     */
    public function filter_remove_multiple_parameters()
    {
        $filter_query = $this->getRequestQuery('http://example.com?p=123&z=456');
        $this->assertEquals('', $filter_query);
    }

    /**
     * @test
     */
    public function filter_ignores_unfilter_parameters()
    {
        $filter_query = $this->getRequestQuery('http://example.com?q=123&y=456');
        $this->assertEquals('q=123&y=456', $filter_query);
    }
}
