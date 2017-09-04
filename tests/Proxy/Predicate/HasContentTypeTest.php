<?php namespace Proxy\Predicate;

use Zend\Diactoros\Response;

class HasContentTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function predicate_matches_content_type()
    {
      $response = new Response('php://memory', 200, ['Content-Type' => 'application/json; charset: utf8']);
      $predicate = new HasContentType(['application/json']);
      $result = call_user_func($predicate, $response);
      $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function predicate_matches_unknown_content_type()
    {
      $response = new Response('php://memory', 200, ['Content-Type' => 'application/jsonp; charset: utf8']);
      $predicate = new HasContentType(['application/json']);
      $result = call_user_func($predicate, $response);
      $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function predicate_matches_multiple_content_type()
    {
      $response = new Response('php://memory', 200, ['Content-Type' => 'application/json']);
      $predicate = new HasContentType(['application/text', 'application/html', 'application/json']);
      $result = call_user_func($predicate, $response);
      $this->assertTrue($result);
    }
}
