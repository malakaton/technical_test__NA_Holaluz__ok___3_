<?php

function cypherString(string $str)
{
    // Please write here a super encryption algorithm as described in instructions.txt!

    $str = str_replace(['a', 'A'], 4, $str);
    $str = str_replace(['E', 'e'], 3, $str);
    $str = str_replace(['I', 'i'], 1, $str);
    $str = str_replace(['O', 'o'], 0, $str);
    $str = str_replace(['B', 'b'], 8, $str);
    $str = str_replace(['S', 's'], 6, $str);
    
    return $str;
}

echo cypherString('Brave soldiers who sacrificed their lives').PHP_EOL;
echo cypherString('Anna, Cris and Mavi').PHP_EOL;
echo cypherString('Holaluz is a great place to work').PHP_EOL;
echo cypherString('This exercise is a bit quirky!').PHP_EOL;
echo cypherString('AEIOBSzzzzaeiobszzzz!').PHP_EOL;
