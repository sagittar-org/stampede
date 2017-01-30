#!/usr/bin/php
<?php
require_once 'vendor/autoload.php';

$options = getopt('p:t:c::o:');
$page = $options['p'];
$template = "input/{$options['t']}.svg";
$contents = isset($options['c']) ? "input/{$options['c']}.xlsx" : NULL;
$output = "output/{$options['o']}.svg";

phpQuery::newDocumentFileXML($template);

$entities = [];
if ($contents !== NULL)
{
	$objPExcel = PHPExcel_IOFactory::load($contents);
	$entities = $objPExcel->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
	array_shift($entities);
}
$objPExcel = PHPExcel_IOFactory::load('input/config.xlsx');
$config = $objPExcel->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
array_shift($config);
foreach ($config as $key => $arr)
{
	if ($arr['A'] === NULL)
	{
		break;
	}
	$config[$key]['B'] = preg_replace('/{\$page}/', $page, $arr['B']);
	preg_match('/{\$page_plus_([0-9])+}/', $arr['B'], $matches);
	if (isset($matches[1]))
	{
		$config[$key]['B'] = str_replace($matches[0], $page + $matches[1], $arr['B']);
	}
	preg_match('/{\$page_minus_([0-9])+}/', $arr['B'], $matches);
	if (isset($matches[1]))
	{
		$config[$key]['B'] = str_replace($matches[0], $page - $matches[1], $arr['B']);
	}
}
$entities = array_merge($entities, $config);

foreach ($entities as $entity)
{
	if ($entity['A'] === NULL)
	{
		break;
	}
	$key = $entity['A'];
	$value = $entity['B'];
	$element = pq("[inkscape:label={$key}]");
	if ($element->get(0) === NULL)
	{
		continue;
	}
	switch ($element->get(0)->tagName)
	{
	case 'text':
		$element->find('tspan')->text($value);
		break;
	case 'flowRoot':
		$style = $element->find('flowPara')->attr('style');
		$element->find('flowPara')->remove();
		foreach (explode("\n", $value) as $line)
		{
			$para = pq('<flowPara></flowPara>')->attr('style', $style)->text($line);
			$element->append($para);
		}
		break;
	case 'image':
		$element->attr('xlink:href', "../input/{$value}");
		break;
	}
}

file_put_contents($output, pq(''));
