<?php

function smarty_function_progress($params, &$smarty)
{
    extract($params);
    unset($params);

    if (!isset($percent)) {
        $percent = 0;
    }

    $progress = '<div class="progressbarcontainer"><div class="progress"><span class="bar" style="width:$percent%">';
    $progress .= $percent;
    $progress .= '%</span></div></div>';

    return $progress;
}

?>