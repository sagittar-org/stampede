#!/usr/bin/php
<?php
// マージ処理未実装
$output = "output/{$argv[1]}.svg";
$work = "work/{$argv[1]}.svg";
shell_exec("cp {$output} {$work}");
