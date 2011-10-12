<?php

function tableSection($tableTpl, $rowTpl, $section, $headline) {

	foreach(glob("./" . $section . "/*/meta.json") AS $metaFile) {

		$data = json_decode(file_get_contents($metaFile), true);
		$tableRow = clone $rowTpl;

		$data = $tableRow->flatArray($data);
		if(isset($data['credits.author'])) {

			if(isset($data['credits.url'])) {
				$data['credits.author'] = '<span class="contributor">Contributed by: <a href="' . $data['credits.url'] . '">' . $data['credits.author'] . '</a></span>';
			} else {
				$data['credits.author'] = '<span class="contributor">Contributed by: ' . $data['credits.author'] . '</span>';
			}

		}

		$tableRow->replace($data, $data);
		$tableRow->replace('link', rtrim(dirname($metaFile), "/\r\n\t") . '.html');
		$tableTpl->append('rows', $tableRow->render());

	}

	$tableTpl->replace('table_headline', $headline)
		->replace('section_id', $section);

	return $tableTpl;

}