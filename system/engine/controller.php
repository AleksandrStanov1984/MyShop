<?php
abstract class Controller {
	protected $registry;

	public function __construct($registry) {
// print "<pre>"; debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS); exit;
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}