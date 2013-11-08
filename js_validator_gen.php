<?php

$sRules = <<<'RULES'
\([^\s\)] ## (C
[^\s\(\}]\) ## C)
\[[^\s\]] ## [C
[^\s\[]\] ## C]
^[ ]+ ## leading space
[\t ]+$ ## tailing space
^\s*\}[\s]+\); ## } );
\s+; ## _;
RULES;


function removeComments($sRule) {
    $iPos = strpos( $sRule, ' ##' );
    if ( $iPos !== FALSE ) {
        $sRule = substr($sRule, 0, $iPos);
    }
    return trim( $sRule);
}

$aRules = explode( PHP_EOL, $sRules );
$regexp = implode( '|', array_map( "removeComments", $aRules ));
$sContent = <<<EOT
#!/bin/bash
# Naive js style checker
grep -rnP --color "{$regexp}" $1
EOT;

$sFilename = dirname(__FILE__) . '/wikia_js_check.sh';
file_put_contents( $sFilename, $sContent );
echo $sFilename . PHP_EOL;
