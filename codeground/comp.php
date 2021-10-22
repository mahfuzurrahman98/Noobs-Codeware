<?php
$compilation_command = 'timeout 10s node noob.js 2>comp_msg.txt';
echo shell_exec($compilation_command);
?>
