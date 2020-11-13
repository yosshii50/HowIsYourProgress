<?php

print( '<canvas id="rectangleW" width="300" height="100"></canvas>' );
print( '<script language="JavaScript">' );
print( 'window.addEventListener(\'load\', init);' );
print( 'function init() {' );
print( 'var rect_ctxW = document.getElementById("rectangleW").getContext("2d");' );
print( 'rect_ctxW.fillStyle = "rgb(128, 255, 128)";' );
print( 'rect_ctxW.fillRect(0, 0, document.getElementById("rectangleW").width, document.getElementById("rectangleW").height);' );
print( 'rect_ctxW.strokeRect(0, 0, 300, 100);' );
print( '}' );
print( '</script>' );

?>
