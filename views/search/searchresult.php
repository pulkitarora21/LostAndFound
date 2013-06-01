<?php
/**
 * Result page for search
 *
 * This page displays retrieved search results in formatted way.
 *
 * @package search
 */
/**
 * Include the model for Search
 */
require_once APP_PATH . DS . 'models/Search.php';
define( 'CURRENT_URL', basename( $_SERVER['REQUEST_URI'] ) );

// prepare for pagination
$pageSize=10;
$page=isset( $_GET['page'] )?intval( $_GET['page'] ):1;
$total=count( $template->results );
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

// i do this horrible function here is for validate parameters that attached on url
function getIndex( $index ) {
    if ( isset( $_GET['page'] ) ) {
        return str_replace( "page=".$_GET['page'], "page=".$index , CURRENT_URL );
    } else if ( CURRENT_URL=="normalSearch" || CURRENT_URL=="advancedSearch" ) {
            return CURRENT_URL."?page=".$index;
        } else {
        return CURRENT_URL."&page=".$index;
    }
}



?>
<html>
<head>
<title>LostAndFound Search Page</title>
<!-- Link external style sheet-->
<link rel="stylesheet" href="webroot/css/formStyle.css" type="text/css" />
<link rel="stylesheet" href="webroot/css/style.css" type="text/css" />

</head>
<body>

<?php
include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
<div class="formHeader" style="width: 730px;">
   <h1>Search Result</h1>
   </div>


   <?php
if ( $total==0 ) {
    echo '<div id="notFound"><h4> No result.</h4></div>';
} else {
?>
    <div id="items">
   <table class="searchStyle" cellpadding="10px" >
      <tr>
         <th width="120px">Item</th>
         <th>Description</th>
      </tr>
      <?php

    $limit= $page==$last?$total:$page*$pageSize;
    for ( $i=( $page-1 )*$pageSize;$i<$limit;$i++ ) {
?>
      <tr>
         <td><a href=<?php echo "lost/".$template->results[$i]->id;?>><img src=<?php echo "../voodoo/webroot/images/upload/".$template->results[$i]->image; ?> ></a>
         </td>
         <td>
         <div id='itemDetail'>
         <b>Name: </b><a href=<?php echo "lost/".$template->results[$i]->id;?>><?php echo $template->results[$i]->name;?></a><br />
         <b>Date: </b> <?php echo $template->results[$i]->date;?><br />
         <b>Address: </b> <?php
        if ( $template->results[$i]->street != "" )
            echo $template->results[$i]->street . ",";
        echo $template->results[$i]->suburb . " , " .$template->results[$i]->state;
        if ( $template->results[$i]->postcode != "" )
            echo " , " . $template->results[$i]->postcode;
?>
         </div>
         </td>
      </tr>
      <?php
    }
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
            echo '<a href="'.getIndex( $i ).'">'.$i.'</a> ';
        }
    }
} elseif ( $pageCount>3 ) {
    if ( $page>3 ) {
        echo '<a href="'.getIndex( 1 ).'">&laquo;</a> ';
        echo '<a href="'.getIndex( $pre ).'">&lsaquo;</a> ';
    }
    for ( $i=-2;$i<=2;$i++ ) {
        $cur=$page+$i;
        if ( $cur>=1 && $cur<=$pageCount ) {
            if ( $i==0 ) {
                echo '<span class="current">'.$page.'</span> ';
            } else {
                echo '<a href="'.getIndex( $cur ).'">'.$cur.'</a> ';
            }
        }
    }
    if ( $pageCount-$page>=3 ) {
        echo '<a href="'.getIndex( $next ).'">&rsaquo;</a> ';
        echo '<a href="'.getIndex( $last ).'">&raquo;</a> ';
    }
}
?>
        </div>
   <?php include_once '../webroot/include/template/footer.php';;?>
</body>
</html>
