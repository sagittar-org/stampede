#!/usr/bin/php
<?php
$input = "work/{$argv[1]}.svg";
$output = "output/{$argv[1]}.pdf";
shell_exec("inkscape --export-pdf={$output} {$input}");
