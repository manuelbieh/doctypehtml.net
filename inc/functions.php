<?php

function tableSection($tableTpl, $rowTpl, $section, $headline) {

	foreach(glob("./" . $section . "/*/meta.json") AS $metaFile) {

		$data = json_decode(file_get_contents($metaFile), true);
		$tableRow = clone $rowTpl;

		$data = $tableRow->flatArray($data);
		$tableRow->replace($data, $data);
		$tableRow->replace('link', dirname($metaFile));
		$tableTpl->append('rows', $tableRow->render());

	}

	$tableTpl->replace('table_headline', $headline)
		->replace('section_id', $section);

	return $tableTpl;

}