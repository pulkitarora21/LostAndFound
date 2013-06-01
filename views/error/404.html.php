<?php
/**
 * A custom 404 page.
 *
 * This is a custom 404 page, when user tries to access a page that is not existing or he/she has entered wrong url
 * for a page.
 *
 * @package error
 */
?>
<html>
<head>
<title>Page Not Found</title>
<link href="http://p3nlhclust404.shr.prod.phx3.secureserver.net/SharedContent/404-etc-styles.css" rel="stylesheet" type="text/css" media="screen">
<style type="text/css">
.site-visitor-404 {
    float: left;
    font-size: 12px;
    color: #6d6a5b;
    padding-left: 20px;
    border-left: 1px solid #d9d6c5;
}

.body-404 h3.info-bottom {
    clear: both;
    font-size: 14px;
    width: 500px;
    margin: 48px auto 0;
    text-align: center;
    padding: 10px 15px 5px;
    font-weight: bold;
}
</style>
</head>
<body>
    <div class="body-404">
        <h1>
            <span>Ever feel you're in the wrong place?</span>
        </h1>

        <div class="info-container">
            <div class="inner-border clear-fix">
                <h2 class="info-top">
                    404 (Page Not Found) Error
                </h2>

                <div class="site-owner-404">
                    <h3>If you're the <strong>site owner,</strong> one of two things happened:</h3>
                    <ol>
                        <li>
                            1) You entered an incorrect URL into your browser's address bar, or
                        </li>
                        <li>
                            2) You haven't uploaded content.
                        </li>
                    </ol>
                </div>

                <div class="site-visitor-404">
                    <h3>If you're a <strong>visitor</strong> and not sure what happened:</h3>
                    <ol>
                        <li>
                            1) You entered or copied the URL incorrectly or
                        </li>
                        <li>
                            2) The link you used to get here is faulty.
                        </li>
                        <li class="last">
                            (It's an excellent idea to let the link owner know.)
                        </li>
                        <li>
                            3) It is illegal to launch an attack on voodoo site.
                        </li>
                        <li class="last">
                            (You might be curse!)
                        </li>
                    </ol>
                </div>
                <h3 class="info-bottom">
                    Please hit back button to return to previous page.
                </h3>
            </div>
        </div>
    </div>
</body>
</html>
