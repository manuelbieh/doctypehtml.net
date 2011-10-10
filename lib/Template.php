<?php

class Template {

	public $tpl;

	public function __construct($file) {
		$this->loadTemplate($file);
	}

	public function loadTemplate($file) {

		if(is_file($file) 
			&& strpos(realpath($file), $_SERVER['DOCUMENT_ROOT']) !== false ) {
			$this->tpl = file_get_contents($file);
		}

		return $this;

	}

	public function replace($s, $r) {

		if(is_array($s)) {
			foreach($s AS $search => $replace) {
				$this->replace($search, $replace);
			}
		} else {
			$s = '[[' . rtrim(ltrim($s, "\n\t\r["), "\n\t\r]") . ']]';
			$this->tpl = str_replace($s, $r, $this->tpl);
		}

		return $this;

	}

	public function append($s, $r) {

		if(is_array($s)) {
			foreach($s AS $search => $replace) {
				$this->replace($search, $replace);
			}
		} else {
			$s = '[[' . rtrim(ltrim($s, "\n\t\r["), "\n\t\r]") . ']]';
			$this->tpl = str_replace($s, $r . $s, $this->tpl);
		}

		return $this;

	}


	public function flatArray($input, $sep='.', $prefix = '', $recursionLimit = 10) {

		$result = array();

		foreach ($input AS $name => $value) {

			if (empty($prefix)) {
				$key = $name;
			} else {
				$key = $prefix.$sep.$name;
			}

			if (is_array($value)) {
				$result = array_merge(
					$result, $this->flatArray($value, $sep, $key, $recursionLimit - 1)
				);

			} else {

				$result[$key] = (string)$value;

			}

		}

		return $result;

	}

	public function render() {

		$this->tpl = preg_replace('|\[\[(.*)\]\]|Usm', '', $this->tpl);

		return $this->tpl;

	}

}