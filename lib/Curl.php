<?php

class Curl {

	public $options = array();
	protected $output;
	protected $url;

	/**
	 * Initialisiert eine neue CURL-Session
	 *
	*/
	public function __construct() {
		$this->curl = curl_init();
	}


	/**
	 * Legt die URL zu der zu verbindenden Seite fest.
	 *
	 * @param int URL der Seite, zu der verbunden werden soll
	 * @return object $this
	*/
	public function connect($url) {

		$this->options = array(
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
		);
		$this->url = $url;

		$this->setOptionArray($this->options);

		$this->setOption(CURLOPT_URL, $this->url);

		return $this;

	}


	/**
	 * Gibt eine Kopie des CURL Handlers zurück
	 *
	 * @return clone
	*/
	public function __clone() {

		return curl_copy_handle($this->curl);

	}


	/**
	 * Magische __toString()-Methode um das aktuelle Objekt als String auszugeben.
	 *
	 * @return string Die angeforderte Seite
	*/
	public function __toString() {

		return $this->output();

	}


	/**
	 * Fehlermeldung der Verbindung
	 *
	 * @return string Fehlermeldung
	*/
	public function getError() {

		return $this->error = curl_error($this->curl);

	}


	/**
	 * Fehlercode der Verbindung
	 *
	 * @return int Fehlercode
	*/
	public function getErrno() {

		return $this->errno = curl_errno($this->curl);

	}


	/**
	 * Setzt eine Option für die aktuelle Verbindung
	 *
	 * @param string Name der Option
	 * @param string Gesetzter Wert der Option
	 * @return object $this
	*/
	public function setOption($optName, $optValue) {

		curl_setopt($this->curl, $optName, $optValue);

		return $this;

	}


	/**
	 * Setzt mehrere Optionen für die aktuelle Verbindung
	 *
	 * @param array Optionen in der Form OPTION=>VALUE
	 * @return object $this
	*/
	public function setOptionArray($optArray) {

		if(is_array($optArray)) {
			curl_setopt_array($this->curl, $optArray);
		}

		return $this;

	}


	/**
	 * Gibt Infos über die aktuelle Verbindungskonfiguration zurück
	 *
	 * @param string Name der Option
	 * @return mixed Wert der Konfiguration oder Array aller Werte
	*/
	public function info($option=NULL) {

		if($option === NULL) {
			return curl_getinfo($this->curl);
		} else {
			return curl_getinfo($this->curl, $option);
		}

	}


	/**
	 * Setzt eine Option für die aktuelle Verbindung
	 *
	 * @param string Name der Option
	 * @param string Gesetzter Wert der Option
	 * @return object $this
	*/
	public function exec() {

		if(!isset($this->url)) {

			throw new Exception('No URL given');

		} else {

			$this->output = curl_exec($this->curl);

			if($this->output === false) {
				$this->getError();
				$this->getErrno();
			}

		}

		return $this;

	}


	/**
	 * Schließt die Verbindung des aktuellen Objekts
	 *
	 * @return object $this
	*/
	public function close() {

		curl_close($this->curl);
		return $this;

	}


	/**
	 * Gibt die Daten der aktuellen Verbindung zurück
	 *
	 * @return string Inhalt der Verbindung als String
	*/
	public function output() {

		if(!isset($this->output)) {
			$this->exec();
		}

		return $this->output;

	}


}



?>