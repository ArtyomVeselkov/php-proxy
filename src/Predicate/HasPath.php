<?php namespace Proxy\Predicate;

use GuzzleHttp\Psr7;
use Psr\Http\Message\MessageInterface;

class HasPath
{
    public function __construct($path)
    {
      $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(MessageInterface $message)
    {
      $parts = explode("/", $message->getUri()->getPath());
      return in_array($this->path, $parts);
    }
}
