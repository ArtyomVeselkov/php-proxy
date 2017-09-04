<?php namespace Proxy\Predicate;

use Psr\Http\Message\MessageInterface;

class PredicateList {
  private $predicates = [];
  private $action = null;

  function __construct(array $predicates, callable $action)
  {
    $this->predicates = $predicates;
    $this->action = $action;
  }

  public function call(MessageInterface $message)
  {
    if ($this->all_predicates_match($message)) {
      return call_user_func($this->action, $message);
    }
    return $message;
  }

  private function all_predicates_match(MessageInterface $message)
  {
    foreach ($this->predicates as $predicate)
    {
      if (!call_user_func($predicate, $message))
      {
         return false;
      }
    }
    return true;
  }
}
