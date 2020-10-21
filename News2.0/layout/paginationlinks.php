<?php

if($numrows == 0)
    echo "";
else {

    echo "<p style='text-align: center'>";

    // Range of number links to show:
    $range = $pagination->getRangeNumber();

    // If we are not on first page, donnot show next and last page links:
    if ($currentpage > 1) {
        echo " <a href='{$_SERVER['PHP_SELF']}?page=1' title='First page.'><b>&laquo;</b></a> ";
    }

    echo "[";

    // Loop to show links to range of pages around current page:
    for ($i = ($currentpage - $range); $i < (($currentpage + $range) + 1); $i++) {
        // If it is a valid page number:
        if (($i > 0) && ($i <= $totalpages)) {

            // If we are on current page, hightlight the page number:
            if ($i == $currentpage) {
                echo " <b>$i</b> ";
            } else {
                echo " <a href='{$_SERVER['PHP_SELF']}?page=$i'>$i</a> ";
            }
        }
    }

    echo "]";

    // If we are not on last page, show next and last page links:       
    if ($currentpage != $totalpages) {
        // Echo forward link for lastpage:
        echo " <a href='{$_SERVER['PHP_SELF']}?page=$totalpages' title='Last page.'><b>&raquo;</b></a> ";
    }
    echo "</p>";

}

?>