<?php
define( 'CURRENT_URL', $_SERVER['REQUEST_URI'] );

//explode to get basename of url
$uri = explode( "voodoo/", CURRENT_URL );

if ( $uri[0]==CURRENT_URL ) {
    $url = explode( "?", CURRENT_URL );

    if ( $url[0] == '' ) {
        $url = array( '' );
    }
} elseif ( $uri[1]=='' ) {
    $url = explode( "?", CURRENT_URL );
    if ( $url=='' ) {
        $url = CURRENT_URL;
    }
} elseif ( $url[0] == CURRENT_URL ) {
    $url[0]='';
} else {
    $url = explode( "?", $uri[1] );
    if ( preg_match( "#^lost\/[0-9]+#", $url[0] ) || preg_match( "#^found\/[0-9]+#",  $url[0] ) ) {
        $url[0] = 'lost';
    }
}

if ( !isset( $_SESSION['user']['email'] ) ) { ?>
            <div class="nav-wrapper">
                <div class="nav-left"></div>
                <div class="nav">
                    <ul id="navigation">
                    <!-- different ??? -->
                        <?php if ( $url[0]=='' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                        <!-- address needed here -->
                            <a href="/voodoo">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Home</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='lost' || $url[0]=='found' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a>
                                <span class="menu-left"></span>
                                <span class="menu-mid">View Item</span>
                                <span class="menu-right"></span>
                            </a>
                            <div class="sub">
                                <ul>
                                    <li>
                                        <a href="/voodoo/lost">View Lost Item</a>
                                    </li>
                                    <li>
                                        <a href="/voodoo/found">View Found Item</a>
                                    </li>
                                </ul>
                                <div class="btm-bg"></div>
                            </div>
                        </li>
                        <?php if ( $url[0]=='search' || $url[0]=='advancedSearch' || $url[0]=='normalSearch' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a href="/voodoo/search">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Advanced Search</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='users/new' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a href="/voodoo/users/new">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Register</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='session/new' || $url[0]=='users/forgot_password' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a href="/voodoo/session/new">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Login</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-right"></div>
            </div>
<?php } else if ( $_SESSION['user']['type'] == 'a' ) {?>
            <div class="nav-wrapper">
                <div class="nav-left"></div>
                <div class="nav">
                    <ul id="navigation">
                    <?php if ( $url[0]=='' ) {
            echo '<li class="active">';
        } else { echo '<li>'; } ?>
                        <!-- address needed here -->
                            <a href="/voodoo">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Home</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='lost' || $url[0]=='found' ) {
            echo '<li class="active">';
        } else { echo '<li>'; } ?>
                            <a>
                                <span class="menu-left"></span>
                                <span class="menu-mid">View Item</span>
                                <span class="menu-right"></span>
                            </a>
                            <div class="sub">
                                <ul>
                                    <li>
                                        <a href="/voodoo/lost">View Lost Item</a>
                                    </li>
                                    <li>
                                        <a href="/voodoo/found">View Found Item</a>
                                    </li>
                                </ul>
                                <div class="btm-bg"></div>
                            </div>
                        </li>
                        <?php if ( $url[0]=='search' || $url[0]=='advancedSearch' || $url[0]=='normalSearch' ) {
            echo '<li class="active">';
        } else { echo '<li>'; } ?>
                            <a href="/voodoo/search">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Advanced Search</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='listUsers' || $url[0]=='users/edit' || $url[0]=='users' ) {
            echo '<li class="active">';
        } else { echo '<li>'; } ?>
                            <a>
                                <span class="menu-left"></span>
                                <span class="menu-mid">Admin</span>
                                <span class="menu-right"></span>
                            </a>
                            <div class="sub">
                                <ul>
                                    <li>
                                        <a href="/voodoo/admin/listUsers">Display All Users</a>
                                    </li>
                                </ul>
                                <div class="btm-bg"></div>
                            </div>
                        </li>
                        <?php if ( $url[0]=='session/destroy' ) {
            echo '<li class="active">';
        } else { echo '<li>'; } ?>
                            <a href="/voodoo/session/destroy">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Log out</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                    </ul>
                    <div class="name">
                    <?php
        $name = explode( "@", $_SESSION['user']['email'] );
        echo 'Hello '.$name[0];
        ?></div>
                </div>
                <div class="nav-right"></div>
            </div>
<?php }else { ?>
            <div class="nav-wrapper">
                <div class="nav-left"></div>
                <div class="nav">
                    <ul id="navigation">
                    <?php if ( $url[0]=='' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                        <!-- address needed here -->
                            <a href="/voodoo">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Home</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='post' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a href="/voodoo/post">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Post Item</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='lost' || $url[0]=='found' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a>
                                <span class="menu-left"></span>
                                <span class="menu-mid">View Item</span>
                                <span class="menu-right"></span>
                            </a>
                            <div class="sub">
                                <ul>
                                    <li>
                                        <a href="/voodoo/lost">View Lost Item</a>
                                    </li>
                                    <li>
                                        <a href="/voodoo/found">View Found Item</a>
                                    </li>
                                </ul>
                                <div class="btm-bg"></div>
                            </div>
                        </li>
                        <?php if ( $url[0]=='search' || $url[0]=='advancedSearch' || $url[0]=='normalSearch' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a href="/voodoo/search">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Advanced Search</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                        <?php if ( $url[0]=='users' || $url[0]=='users/showMyItem' || $url[0]=='users/change_password' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a href="/voodoo/users">
                                <span class="menu-left"></span>
                                <span class="menu-mid">My Account</span>
                                <span class="menu-right"></span>
                            </a>
                            <div class="sub">
                                <ul>
                                    <li>
                                        <a href="/voodoo/users/showMyItem">My Post Item</a>
                                    </li>
                                    <li>
                                        <a href="/voodoo/users/change_password">Change password</a>
                                    </li>
                                </ul>
                                <div class="btm-bg"></div>
                            </div>
                        </li>
                        <?php if ( $url[0]=='session/destroy' ) {
        echo '<li class="active">';
    } else { echo '<li>'; } ?>
                            <a href="/voodoo/session/destroy">
                                <span class="menu-left"></span>
                                <span class="menu-mid">Log out</span>
                                <span class="menu-right"></span>
                            </a>
                        </li>
                    </ul>
                    <div class="name">
                    <?php
    $name = explode( "@", $_SESSION['user']['email'] );
    echo 'Hello '.$name[0];
    ?></div>
                </div>
                <div class="nav-right"></div>
            </div>
<?php } ?>
