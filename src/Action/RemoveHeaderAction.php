<?php namespace Proxy\Action;

use GuzzleHttp\Psr7;
use Psr\Http\Message\MessageInterface;

class RemoveHeaderAction
{
    public function __construct($header)
    {
      $this->header = $header;
    }

    private function proxyHeaderName()
    {
      return "X-Proxy-" . $this->header;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(MessageInterface $message)
    {
      return $message
              ->withHeader($this->proxyHeaderName(), $message->getHeader($this->header))
              ->withoutHeader($this->header);
    }
}
