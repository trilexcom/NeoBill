<?php

function smarty_function_iswriteable($params, &$smarty)
{
    extract($params);
    unset($params);

    if (!isset($file)) {
        return false;
    }

    // is_writable() is not reliable enough - drak
    if(is_dir($file)) {
        $result = is_writable($file);
    }else{
        $result = @fopen($file, 'a');
        if ($result === true) {
            fclose($result);
        }
    }

    if (isset($assign)) {
        $smarty->assign($assign, $result);
    } else {
        return $result;
    }
}

?>