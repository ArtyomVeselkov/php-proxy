<?php namespace Proxy\Predicate;

use Zend\Diactoros\Request;

class HasPathTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function predicate_matches_path()
    {
      $response = new Request('http://example.com/test/123');
      $predicate = new HasPath('test');
      $result = call_user_func($predicate, $response);
      $this->assertTrue($result);

      $predicate = new HasPath('123');
      $result = call_user_func($predicate, $response);
      $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function ignores_missing_path()
    {
      $response = new Request('http://example.com');
      $predicate = new HasPath('test');
      $result = call_user_func($predicate, $response);
      $this->assertFalse($result);
    }
}
