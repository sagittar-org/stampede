#!/usr/bin/php
<?php
$input = $argv;
array_shift($input);
foreach ($input as $key => $value)
{
	$input[$key] = "output/{$value}.pdf";
}
$output = 'output/output.pdf';
if (count($input) === 1)
{
	shell_exec("cp {$input[0]} {$output}");
	exit;
}
shell_exec("pdfunite ".implode(' ', $input)." {$output}");
