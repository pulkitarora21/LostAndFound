<?php
/**
 * Lost and found results page
 *
 * This page displays lost and found items for a user.
 *
 * @package users
 */
/**
 * Include the model for User
 */
require_once APP_PATH . DS . 'models/User.php';
?>
<html>
<head>
<title>LostAndFound Search Page</title>
<!-- Link external style sheet-->
<link rel="stylesheet" href="../webroot/css/formStyle.css" type="text/css" />
<link rel="stylesheet" href="../webroot/css/style.css" type="text/css" />
<script type="text/javascript">
        <!--
            function confirmation() {
                var answer = confirm("Are you sure you want to delete this item?");
                if (answer){
                    return true;
                }
                else{
                    return false;
                }
            }
</script>

</head>
<body>
<?php include_once '../webroot/include/template/header.php';
include_once '../webroot/include/template/menu.php';
include_once '../webroot/include/template/search.php';
?>
    <div id="innerContent">
        <div class="formHeader" style="width: 730px;">
        <h1>My Lost Items</h1>
    </div>
           <?php
if ( count( $template->lostItems ) == 0 ) {
    echo '<div id="notFound"><h4> You have no reported lost item.</h4></div>';
} else {
?>
        <div id="search">
        <table class="searchStyle" cellpadding="10px" >
          <tr>
             <th>Image</th>
             <th>Description</th>
             <th>isSolved</th>
             <th>Delete</th>
          </tr>
          <?php
    for ( $i = 0; $i < count( $template->lostItems ); $i++ ) {
        echo "<tr>";
        echo '<td><a href="../lost/'.$template->lostItems[$i]->id.'"><img src="../webroot/images/upload/'.$template->lostItems[$i]->image.'" alt="image" /></a></td>';
        echo '<td><div id="itemDetail2"><b>Name: </b><a href="../lost/'.$template->lostItems[$i]->id.'">'.$template->lostItems[$i]->name.'</a><br/>';
        echo "<b>Date: </b>{$template->lostItems[$i]->date}<br/>";
        echo "<b>Address: </b>{$template->lostItems[$i]->street} {$template->lostItems[$i]->suburb} {$template->lostItems[$i]->state} {$template->lostItems[$i]->postcode}</td></div>";
?>
             <td align="center">
                <?php
        if ( $template->lostItems[$i]->isSolved == 0 )
            echo "No";
        else
            echo "Yes";
?>
             </td>
             <td align="center">
                 <form action= '/voodoo/users/showMyItem/deleteLost' method='POST' onsubmit="return confirmation();">
                 <input type="submit" value="Delete" name="delete" class="button" />
                 <input type="hidden" value="<?php echo $template->lostItems[$i]->id; ?>" name="id" />
                 </form>
             </td>
          </tr>
          <?php
    }
?>
        </table>
        </div>
        <?php } ?>
    <br />
    <div class="formHeader" style="width: 730px;">
        <h1>My Found Items</h1>
    </div>
       <?php
if ( count( $template->foundItems ) == 0 ) {
    echo '<div id="notFound"><h4> You have no reported found item.</h4></div>';
} else {
?>
        <div id="search">
        <table class="searchStyle" cellpadding="10px" >
          <tr>
             <th>Image</th>
             <th>Description</th>
             <th>isSolved</th>
             <th>Delete</th>
          </tr>
          <?php
    for ( $i = 0; $i < count( $template->foundItems ); $i++ ) {
        echo "<tr>";
        echo '<td><a href="../found/'.$template->foundItems[$i]->id.'"><img src="../webroot/images/upload/'.$template->foundItems[$i]->image.'" alt="image" /></a></td>';
        echo '<td><div id="itemDetail2"><b>Name: </b><a href="../found/'.$template->foundItems[$i]->id.'">'.$template->foundItems[$i]->name.'</a><br/>';
        echo "<b>Date: </b>{$template->foundItems[$i]->date}<br/>";
        echo "<b>Address: </b>{$template->foundItems[$i]->street} {$template->foundItems[$i]->suburb} {$template->foundItems[$i]->state} {$template->foundItems[$i]->postcode}</td></div>";
?>
             <td align="center">
                <?php
        if ( $template->foundItems[$i]->isSolved == 0 )
            echo "No";
        else
            echo "Yes";
?>
             </td>
             <td align="center">
                <form action= '/voodoo/users/showMyItem/deleteFound' method='POST' onsubmit="return confirmation();">
                <input type="submit" value="Delete" name="delete" class="button" />
                <input type="hidden" value="<?php echo $template->foundItems[$i]->id; ?>" name="id" />
                </form>
             </td>
          </tr>
          <?php
    }
?>
    </table>
    </div>
   <?php } ?>
   </div>
   <?php include_once '../webroot/include/template/footer.php';;?>
</body>
</html>
