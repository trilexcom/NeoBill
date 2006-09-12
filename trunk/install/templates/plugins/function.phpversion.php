<?php

function smarty_function_phpversion($params, &$smarty)
{
    extract($params);
    unset($params);

    if (isset($assign)) {
        $smarty->assign($assign, phpversion());
    } else {
        return phpversion();
    }
}

?>