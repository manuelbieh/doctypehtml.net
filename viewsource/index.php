<!DOCTYPE html>
<html lang="en">
<head>
<title>View-Source</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />
<meta charset="utf-8" />
<script src="sh_main.min.js"></script>
<script src="lang/sh_html.min.js"></script>
<script src="lang/sh_javascript.min.js"></script>
<script src="lang/sh_css.min.js"></script>
<style>
body {
	background: white;
}
</style>
<link href="syntax.css" rel="stylesheet" type="text/css" />

</head>
<body onload="sh_highlightDocument();">

<?php

include "../lib/Curl.php";

$url = $_GET['url'];
$url = str_replace('http://' . $_SERVER['SERVER_NAME'] . '/', '', $url);

$suffix = explode('.', $url);
$suffix = end($suffix);

switch($suffix) {
	case 'js':
		$type = 'javascript';
		break;
	case 'css':
		$type = 'css';
		break;
	case 'html':
	default: 
		$type = 'html';
}
?>
<pre id="source" class="sh_<?php echo $type; ?>" style="white-space: pre-wrap;">
<?php
libxml_use_internal_errors(true);

//$file = file_get_contents('http://doctypehtml.net/' . $url);
$curl = new Curl();

$file = $curl->connect('http://' . $_SERVER['SERVER_NAME'] . '/' . $url)->setOption(CURLOPT_FOLLOWLOCATION, 1)->output();
$status = $curl->info(CURLINFO_HTTP_CODE);

if($status < 400) {

	if($type == 'html') {

		$dom = new DOMDocument();
		$dom->encoding = 'UTF-8';
		$dom->formatOutput = true;
		$dom->preserveWhiteSpace = true;
		$dom->loadHTML($file);

		$scripts = $dom->getElementsByTagName('script');

		foreach($scripts AS $script) {
			$src = ltrim($script->getAttribute('src'), '/');
			if(strpos($src, 'http') !== 0 && $src != '') {
				$script->setAttribute('src', 'http://' . $_SERVER['SERVER_NAME'] . '/' . $src);
			}
		}

		$styles = $dom->getElementsByTagName('link');
		foreach($styles AS $style) {
			$href = ltrim($style->getAttribute('href'), '/');
			if(strpos($href, 'http') !== 0 && $href != '') {
				$style->setAttribute('href', 'http://' . $_SERVER['SERVER_NAME'] . '/' . $href);
			}
		}

		$links = $dom->getElementsByTagName('a');
		foreach($links AS $link) {
			$href = ltrim($link->getAttribute('href'), '/');
			if(strpos($href, 'http') !== 0 && $href != '') {
				$link->setAttribute('href', 'http://' . $_SERVER['SERVER_NAME'] . '/' . $href);
			}
		}

		$output = $dom->saveHTML();

		$config = array('indent' => TRUE, 'output-html' => TRUE, 'wrap'=>200, 'indent-spaces'=>4);

		$tidy = tidy_parse_string($output, $config, 'UTF8');
		$html = htmlentities($tidy, ENT_COMPAT, 'UTF-8');

		$html = preg_replace('((src|href)=&quot;http://' . $_SERVER['SERVER_NAME'] . '/(.*)&quot;)U', '$1=&quot;<a href="?url=http://' . $_SERVER['SERVER_NAME'] . '/$2">http://' . $_SERVER['SERVER_NAME'] . '/$2</a>&quot;', $html);

		echo $html;

	} else {
		echo htmlentities($file, ENT_COMPAT, 'UTF-8');
	}

} else {
	echo '<h3>Error ' . $status . '<br />Document could not be loaded.</h3>';
}

?>

</pre>

</body>
</html>