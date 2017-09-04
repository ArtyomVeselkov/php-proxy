<?php namespace Proxy\Predicate;

use GuzzleHttp\Psr7;
use Psr\Http\Message\MessageInterface;

class HasHeader
{
    public function __construct($header)
    {
      $this->header = $header;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(MessageInterface $message)
    {
      return $message->hasHeader($this->header);
    }
}
