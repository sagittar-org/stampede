#!/usr/bin/php
<?php
require_once 'vendor/autoload.php';

$objPExcel = PHPExcel_IOFactory::load('input/index.xlsx');
$entities = $objPExcel->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
array_shift($entities);
$page = 1;
foreach ($entities as $entity)
{
	if ($entity['A'] === NULL)
	{
		break;
	}

	$output = $entity['A'];
	$svg = "output/{$entity['A']}.svg";
	$work = "work/{$entity['A']}.svg";
	$pdf = "output/{$entity['A']}.pdf";
	$template = "input/{$entity['B']}.svg";
	$contents = $entity['C'] === NULL ? NULL : "input/{$entity['C']}.xlsx";

	$dependencies = [];
	$dependencies[] = 'Makefile';
	$dependencies[] = 'input/config.xlsx';
	$dependencies[] = $template;
	if ($contents !== NULL)
	{
		$dependencies[] = $contents;
	}
	foreach ($entity['D'] === NULL ? [] : explode(' ', $entity['D']) as $value)
	{
		$dependencies[] = "input/{$value}";
	}
	$dependencies = implode(' ', $dependencies);

	$svg_lines[] = "{$svg}: ../../bin/render_svg.php {$dependencies}\n\t../../bin/render_svg.php -p{$page} -t{$entity['B']}".($entity['C'] !== NULL ? " -c{$entity['C']}" : '')." -o{$entity['A']}";
	$work_lines[] = "{$work}: ../../bin/copy_svg.php {$svg}\n\t../../bin/copy_svg.php {$output}";
	$pdf_lines[] = "{$pdf}: ../../bin/export_pdf.php {$work}\n\t../../bin/export_pdf.php {$entity['A']}";
	$outputs[] = $output;
	$pdfs[] = $pdf;
	$page++;
}
$svg_lines = implode("\n", $svg_lines);
$work_lines = implode("\n", $work_lines);
$pdf_lines = implode("\n", $pdf_lines);
$outputs = implode(' ', $outputs);
$pdfs = implode(' ', $pdfs);

ob_start();
echo <<<EOD
# output.pdf
output/output.pdf: ../../bin/unite_pdf.php {$pdfs}
	../../bin/unite_pdf.php {$outputs}

# output/*.pdf
{$pdf_lines}

# work/*.svg
{$work_lines}

# output/*.svg
{$svg_lines}

# Makefile
Makefile: ../../bin/create_makefile.php input/index.xlsx
	../../bin/create_makefile.php

# misc
PHONY: clean
clean:
	rm output/*
PHONY: clean_work
clean_work:
	rm work/*
	rm output/*
EOD;
file_put_contents('Makefile', ob_get_contents());
ob_end_clean();
