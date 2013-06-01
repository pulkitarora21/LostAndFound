<?php
/**
 * An index page for found items.
 *
 * This page is used by controllers to display all the found items.
 *
 * @package found
 */
/**
 * Include the model for found items
 */
require_once APP_PATH . DS . 'models/Found.php';
define( IMAGE_URL, 'webroot/images/upload/' );

// prepare for pagination
$pageSize=10;
$page=isset( $_GET['page'] )?intval( $_GET['page'] ):1;
$total=count( $template->allFoundItems );
$pageCount=ceil( $total/$pageSize );
if ( $page>$pageCount ) {
    $page=$pageCount;
}
if ( $page<=0 ) {
    $page=1;
}
$pre=$page-1!=0?$page-1:1;
$next=$page+1<$pageCount?$page+1:$pageCount;
$first=1;
$last=$pageCount;
?>
<html>
<head>
<title>Found Item Page</title>

    <!-- Link external style sheet-->
    <link rel="stylesheet" href="webroot/css/style.css" type="text/css" />
    <link rel="stylesheet" href="webroot/css/formStyle.css" type="text/css" />
</head>
<body>
    <?php
include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
    <div id="innerContent">
    <div class="formHeader" style="width: 730px;">
        <h1>Found Item</h1>
    </div>
    <div id="items">
        <table class="searchStyle" cellpadding="10px" >
            <tr>
                <th style="width:120px">Item</th>
                <th>Description</th>
            </tr>
            <?php
$items = $template->allFoundItems;
$limit= $page==$last?$total:$page*$pageSize;
for ( $i=( $page-1 )*$pageSize;$i<$limit;$i++ ) {
    echo "<tr>";
    echo '<td><a href="found/'.$items[$i]["id"].'"><img src="'.IMAGE_URL.$items[$i]['image'].'" alt="image" /></a></td>';
    echo '<td><div id="itemDetail"><b>Name: </b><a href="found/'.$items[$i]["id"].'">'.$items[$i]["name"].'</a><br/>';
    echo "<b>Date: </b>{$items[$i]["date"]}<br/>";
    echo "<b>Address: </b>{$items[$i]["street"]} {$items[$i]["suburb"]} {$items[$i]["state"]} {$items[$i]["postcode"]}</td></div>";
    echo "</tr>";
}
?>
        </table>
        </div>
        <div class="pagination">
      <?php
if ( $pageCount<=3 && $pageCount>1 ) {
    for ( $i=1;$i<=$pageCount;$i++ ) {
        if ( $page==$i ) {
            echo '<span class="current">'.$page.'</span> ';
        } else {
            echo '<a href="?page='.$i.'">'.$i.'</a> ';
        }
    }
} elseif ( $pageCount>3 ) {
    if ( $page>3 ) {
        echo '<a href="?page=1">&laquo;</a> ';
        echo '<a href="?page='.$pre.'">&lsaquo;</a> ';
    }
    for ( $i=-2;$i<=2;$i++ ) {
        $cur=$page+$i;
        if ( $cur>=1 && $cur<=$pageCount ) {
            if ( $i==0 ) {
                echo '<span class="current">'.$page.'</span> ';
            } else {
                echo '<a href="?page='.$cur.'">'.$cur.'</a> ';
            }
        }
    }
    if ( $pageCount-$page>=3 ) {
        echo '<a href="?page='.$next.'">&rsaquo;</a> ';
        echo '<a href="?page='.$last.'">&raquo;</a> ';
    }
}
?>
        </div>
    </div>
    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
