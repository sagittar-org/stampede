#!/usr/bin/php
<?php
shell_exec("cp -r examples/Planets projects/{$argv[1]}");
shell_exec("find projects/{$argv[1]} -name .gitkeep | xargs rm");
shell_exec("cd projects/{$argv[1]}; ../../bin/create_makefile.php");
