<?php
header("Content-Type: text/html; charset=utf-8");
libxml_use_internal_errors(true);

include "inc/functions.php";
include "lib/Template.php";

$reqURL = htmlspecialchars(strip_tags($_SERVER['REQUEST_URI']), ENT_NOQUOTES);
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$domainURL = '//' . $_SERVER['SERVER_NAME'];
$path = realpath($docRoot . DIRECTORY_SEPARATOR . str_replace(array('index.html', '.html'), '', $reqURL)); // Path to example folder
$exampleFile = $path . DIRECTORY_SEPARATOR . 'example.html'; // File containing the actual example

if($reqURL === '/') {

	$tpl		= new Template('./assets/templates/main.html');
	$tpl->replace('title', 'doctypehtml.net – HTML5/CSS3 Demos + Experiments');

	$tableTpl	= new Template('./assets/templates/table.html');
	$rowTpl		= new Template('./assets/templates/tablerow.html');

	$tpl->replace('html5', tableSection(clone $tableTpl, $rowTpl, 'html5', 'HTML5')->render());
	$tpl->replace('css3', tableSection(clone $tableTpl, $rowTpl, 'css3', 'CSS3')->render());

} else if(
	is_dir($path) // URL resolves to an example?
	&& is_file($exampleFile) // path contains an example file?
	&& strpos($path, $docRoot) !== false // fraud preventing. Example path is within document root?
) {

	$templateFile = file_get_contents($exampleFile);
	preg_match('|<title>(.*)</title>|Usm', $templateFile, $title);
	$templateFile = str_replace('<title>' . $title[1] . '</title>', '', $templateFile);

	preg_match('|<head>(.*)</head>|Usm', $templateFile, $head);
	preg_match('|<div id="content">(.*)</div>|Usm', $templateFile, $content);

	$tpl = new Template('./assets/templates/sub.html');

	$tpl->replace('head', $head[1])
		->replace('title', $title[1])
		->replace('content', $content[1]);

} else {

	$tpl = new Template('./assets/templates/sub.html');
	$tpl->replace('content', '<h2>404 - Not found</h2><p>The page you requested could not be found.</p>')
		->replace('title', '404 - Not found');

}

if($tpl instanceof Template) {

	$tpl->replace('url', $domainURL . str_replace(array('index.html', '.html'), '', $reqURL))
		->replace('baseurl', $domainURL);


	echo $tpl->render();

}