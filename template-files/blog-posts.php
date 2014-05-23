<?php 

/**
 * Posts template
 * Example template file populated with MarkupBlog output and additional custom code for the Blog Posts
 *
 */

    //CALL THE MODULE - MarkupBlog
    $blogOut = $modules->get("MarkupBlog");
        
    //nav
    $blogHome = $pages->get("/blog/");
    $topNavItems = $blogHome->children('name!=posts');//we exclude the 'posts' page
    //echo $blogOut->renderNav('', $nav->prepend($bloghome), $page);
    $topNav = $blogOut->renderNav('', $topNavItems, $page);

    //main content
    $posts = $pages->find("template=blog-post, blog_categories=$page, limit=10");//grab some posts
    $content = '';
    $content .= "<h2>{$page->get('blog_headline|title')}</h2>";
    //render a limited number of summarised posts
    $content .= $blogOut->renderPosts("limit=5", true); 

    //rss
    /** Note, for the RSS to work, you should not output anything further after calling this, as it outputs the RSS directly. 
        If not, you will get an error **/

    //if we want to view the rss of posts
    if($input->urlSegment1) {
        // rss feed
        if($input->urlSegment1 != 'rss') throw new Wire404Exception();
        $homepage = $pages->get('/'); 
        //render rss; just an example...we have no meta_description field
		$blogOut->renderRSS($page->children("limit=10"), $homepage->get('headline|title'), $homepage->get('summary|meta_description')); 
        
        return;//this is important: stops output of any other markup except the RSS xml
    }
        
?>
     
    
    <!doctype html>
    <html lang="en-gb" dir="ltr" class="uk-notouch">
        <head>
            <meta charset="utf-8">
            <?php header('X-UA-Compatible: IE=edge,chrome=1');//taming IE ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title><?php echo $page->title;?></title>

            <!-- Google Webfonts -->
            <link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'><!--  Main Menu -->
            <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow:400,400italic,700,700italic' rel='stylesheet' type='text/css'><!-- Body Copy, etc -->
            
            <!-- Style Sheets -->
            <link rel="stylesheet" href="<?php echo $config->urls->templates;?>css/pocketgrid.css" /><!-- The PocketGrid -->
            <link rel="stylesheet" href="<?php echo $config->urls->templates;?>css/blog.css" /><!-- Custom Styles -->

            <!-- Scripts -->
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> 
            <script src="<?php echo $config->urls->templates;?>js/blog.js"></script>

        </head>

        <body>

            <div id="wrapper" class="block-group"> <!-- #wrapper -->
            
                <div id="header" class="block"> <!-- header -->                        
						<ul id="navbar">
                            <li><a href="<?php echo $pages->get('/')->url ?>">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="<?php echo $pages->get('/blog/')->url ?>">Blog</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                </div> <!-- end #header -->
         
                <!-- LEFT COLUMN - NAV -->
                <div id ="nav" class="block"><!-- #nav -->             
                    <div id="top-nav"><?php echo $topNav;?></div><!-- #top-nav -->
                </div><!-- end #nav -->
                        
                <!-- CENTRE COLUMN - MAIN -->               
                <div id="main" class="block"><?php echo $content?></div> <!-- #main -->
                  
                <!-- RIGHT COLUMN - SIDEBAR --> 
                <div id="sidebar" class="block"><?php include_once("blog-side-bar.inc"); ?></div><!-- #sidebar -->
          
        <!-- BOTTOM - FOOTER -->

                <div id="footer" class="block"><!-- #footer -->
                    <small id="footer_note">Copyright 2014</small>
                    <small id="processwire">Powered by <a target="_blank" href="http://processwire.com">ProcessWire Open Source CMS</a></small>
                </div><!-- end #footer -->

            </div><!-- end #wrapper -->

        </body>

    </html>