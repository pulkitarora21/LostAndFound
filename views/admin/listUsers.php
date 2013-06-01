<?php
/**
 * View file for admin functionalities
 *
 * This file is the main view for the admin functionalities. It contains all the
 * design and some of the data related contents, which includes paging as well.
 *
 * @package admin
 */

/**
 * Start the session
 */
session_start();
require_once APP_PATH . DS . 'models/Admin.php';
require_once APP_PATH . DS . 'models/User.php';
define( 'CURRENT_URL', basename( $_SERVER['REQUEST_URI'] ) );

/**
 * get filter alphabet
 */
$filter = isset( $_GET['filter'] ) ? $_GET['filter'] : NULL;
$new = array();
//get filtered user list
for ( $i = 0; $i < count( $template->allUsers ); $i++ ) {
    if ( preg_match( "#^{$filter}#", $template->allUsers[$i]->email ) ) {
        array_push( $new, $template->allUsers[$i] );
    }
}
/**
 * set page size
 */
$pageSize=25;
$page=isset( $_GET['page'] )?intval( $_GET['page'] ):1;
if ( !isset( $_GET['filter'] ) ) {
    $total=count( $template->allUsers );
} else {
    $total=count( $new );
}
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
/**
 * append page to URL
 */
function getIndex( $index ) {
    if ( isset( $_GET['page'] ) ) {
        return str_replace( "page=".$_GET['page'], "page=".$index , CURRENT_URL );
    } else if ( CURRENT_URL=="listUsers" ) {
            return CURRENT_URL."?page=".$index;
        } else {
        return CURRENT_URL."&page=".$index;
    }
}

?>
<html>
<head>
    <title>Display All Users</title>
    <!-- Link external style sheet-->
    <link rel="stylesheet" href="../webroot/css/style.css" type="text/css" />
    <link rel="stylesheet" href="../webroot/css/homeStyle.css" type="text/css" />
    <link rel="stylesheet" href="../webroot/css/formStyle.css" type="text/css" />
    <script type="text/javascript" src="../webroot/js/jquery.min.js"></script>

    <!-- This javascript and jquery are sourced from http://yensdesign.com/2008/09/how-to-create-a-stunning-and-smooth-popup-using-jquery-->
    <script type="text/javascript" src="../webroot/js/jquery.blockUI.js"></script>
</head>
<body>

<?php
include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
    <div id="innerContent">
        <div class="formHeader" style="width: 900px;">
            <h1>Users List</h1>
        </div>
        <div id="adminForm">
            <div style="padding: 5px 20px;">
            <span>Filter by: </span>
            <?php
/**
 * print filter range
 */
foreach ( range( 'a', 'z' ) as $filter ) {
    if ( $filter != 'z' ) {
        echo '<a href="?filter='.$filter.'">'.$filter.'</a> | ';
    } else {
        echo '<a href="?filter='.$filter.'">'.$filter.'</a>';
    }
}
?>
            </div>
            <table id="adminTable" cellpadding="5px">
                <tr>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Phone</th>
                    <th>Edit</th>
                    <th>Block</th>
                </tr>
                <?php
/**
 * list all users with edit and block options
 */
$limit= $page==$last?$total:$page*$pageSize;
for ( $i=( $page-1 )*$pageSize;$i<$limit;$i++ ) {
    if ( $template->allUsers[$i]->email ==  $_SESSION['user']['email'] ) {
        continue;
    }

    if ( !isset( $filter ) ) {
?>
                <tr>
                    <td align="center"><?php echo $template->allUsers[$i]->email; ?></td>
                    <td align="center"><?php echo $template->allUsers[$i]->fname; ?></td>
                    <td align="center"><?php echo $template->allUsers[$i]->lname; ?></td>
                    <td align="center"><?php echo $template->allUsers[$i]->dob; ?></td>
                    <td align="center"><?php echo $template->allUsers[$i]->phone; ?></td>
                    <td align="center"><form method="post" action="editUser" id="editUserForm">
                        <input type="submit" value="Edit" name="edit" class="button" />
                        <input type="hidden" value="<?php echo $template->allUsers[$i]->email; ?>" name="email"/>
                    </form></td>
                    <td align="center">
                        <?php if ( $template->allUsers[$i]->isActivated == 1 ) { ?>
                        <form method="post" action="blockUser" id="blockForm">
                            <input type="submit" value="Block" name="block" class="button" />
                            <input type="hidden" value="<?php echo $template->allUsers[$i]->email; ?>" name="email"/>
                        </form>
                        <?php } else {?>
                        <form method="post" action="unblockUser" id="unblockForm">
                            <input type="submit" value="Unblock" name="unblock" class="button" />
                            <input type="hidden" value="<?php echo $template->allUsers[$i]->email; ?>" name="email"/>
                            <input type="hidden" value="<?php echo $template->allUsers[$i]->fname; ?>" name="fname"/>
                        </form>
                            <?php } ?>
                    </td>
                </tr>
                <?php }
    /**
     * list users by filter with edit and block options
     */
    else {?>
                <tr>
                    <td align="center"><?php echo $new[$i]->email; ?></td>
                    <td align="center"><?php echo $new[$i]->fname; ?></td>
                    <td align="center"><?php echo $new[$i]->lname; ?></td>
                    <td align="center"><?php echo $new[$i]->dob; ?></td>
                    <td align="center"><?php echo $new[$i]->phone; ?></td>
                    <td align="center"><form method="post" action="editUser" id="editUserForm">
                        <input type="submit" value="Edit" name="edit" class="button" />
                        <input type="hidden" value="<?php echo $new[$i]->email; ?>" name="email"/>
                    </form></td>
                    <td align="center">
                        <?php if ( $new[$i]->isActivated == 1 ) { ?>
                        <form method="post" action="blockUser" id="blockForm">
                            <input type="submit" value="Block" name="block" class="button" />
                            <input type="hidden" value="<?php echo $new[$i]->email; ?>" name="email"/>
                        </form>
                        <?php } else {?>
                        <form method="post" action="unblockUser" id="unblockForm">
                            <input type="submit" value="Unblock" name="unblock" class="button" />
                            <input type="hidden" value="<?php echo $new[$i]->email; ?>" name="email"/>
                            <input type="hidden" value="<?php echo $new[$i]->fname; ?>" name="fname"/>
                        </form>
                            <?php } ?>
                    </td>
                </tr>
                  <?php  } } ?>
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
    </div>
    <?php include_once '../webroot/include/template/footer.php';?>
</body>
</html>
