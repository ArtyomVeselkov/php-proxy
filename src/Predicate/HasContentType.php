<?php namespace Proxy\Predicate;

use GuzzleHttp\Psr7;
use Psr\Http\Message\MessageInterface;

class HasContentType
{
    public function __construct($contentTypes)
    {
      $this->contentTypes = $contentTypes;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(MessageInterface $message)
    {
      $parsed = Psr7\parse_header($message->getHeader('Content-Type'));
      foreach($parsed as $header_parts)
      {
        list($content_type) = $header_parts;
        if (in_array($content_type, $this->contentTypes))
        {
          return true;
        }
      }
      return false;
    }

}
