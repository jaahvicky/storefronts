<?php

namespace App\Dtos;

class EmailRequest {	

	private $email;
	private $name;
	private $template;
	private $subject;
	private $body;
	private $variables = [];
	
	//Adds a single variable
	function addVariable($name, $content) {
            $this->variables[] = ['name' => $name, 'content' => $content]; //Mandrill requires variables to be arrays, like so.
	}
	
	/* GET */

	function getEmail() {
		return $this->email;
	}

	function getName() {
		return $this->name;
	}

	function getTemplate() {
		return $this->template;
	}

	function getSubject() {
		return $this->subject;
	}

	function getVariables() {
		return $this->variables;
	}

	/* SET */

	function setEmail($email) {
		$this->email = $email;
	}

	function setName($name) {
		$this->name = $name;
	}

	function setTemplate($template) {
		$this->template = $template;
	}

	function setSubject($subject) {
		$this->subject = $subject;
	}

	//Replaces all variables
	function setVariables($variables) {
		$this->variables = $variables;
	}
	
}

