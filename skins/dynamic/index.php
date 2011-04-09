<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- page title -->
<title>dynamic - a premium HTML web template</title>

<!--
A free web template by spyka Webmaster (http://www.spyka.net)
//-->

<link rel="stylesheet" href="<?=$tpl->skin?>/css/core.css" type="text/css" />
<?=$tpl->aux_head?>
<?=$tpl->aux_js?>
</head>
<body>
<div id="wrapper">

	<div id="sitename" class="clear">
    	<!-- YOUR SITE NAME -->
		<h1><a href="#"><img src="<?=$tpl->skin?>/images/fermi-logo.jpg" /></a></h1>
	</div>
	
	<div id="navbar">	
		<div class="clear">
			<ul class="sf-menu clear">
            	<!-- PAGE NAVIGATION -->
            	<?php
            		$list = array('index', 'hans', 'blog', 'products', 'portfolio', 'support', 'contact') ;
            		foreach($list as $page)
            		{
            			if(Request::_('site') == $page)
            			{
            				echo '<li class="selected"><a href="'.$tpl->site($page).'"><span>'.$page.'</span></a></li>' ;
            			}
            			else
            			{
            				echo '<li><a href="'.$tpl->site($page).'"><span>'.$page.'</span></a></li>' ;
            			}
            		}
            	?>

			</ul>
		</div>
	</div>
	
	<div id="header" class="clear">
		<div class="header-text">
			<h2><strong>Pellentesque</strong> habitant morbi tristique </h2>
			<p>Pellentesque sit amet odio eget ipsum tempor ultricies. Maecenas tempor massa turpis. Aenean euismod, dui et porttitor euismod, arcu erat pellentesque erat, eu tincidunt diam lacus ac nisi.</p>
			
			<p class="header-buttons">
				<a href="#" class="button pngfix">Preview</a>
				<a href="#" class="button color-button pngfix">Purchase</a>
			</p>
			
		</div>
		<div class="header-images">
			<img src="images/slide-1.jpg" alt="Slide #1" width="250" height="154" />
		</div>
		
	</div>
	<div class="header-bottom"></div>
	
	<div id="body-wrapper">
	
    	<!-- BREADCRUMB NAVIGATION -->
		<div class="bcnav">
			<div class="bcnav-left">
				<div class="bcnav-right clear">
					<h3>you are here:</h3>
					<ul class="bcnavlist">
						<li><a href="#">home</a></li>
                        <li>/</li>
						<li><a href="#">products</a></li>
                        <li>/</li>
						<li>widget</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div id="body" class="clear">

			
			<div class="clear">
				<div class="column column-650 column-left">
				
				
					<?=$tpl->main?>
				</div>
				<div id="sidebar" class="column column-240 column-right">
								<ul>	
                        <li>
        
                            <h4>Links</h4>
            
                            <ul>
                                <li><a href="http://www.spyka.net" title="spyka Webmaster resources">spyka webmaster</a></li>
                                <li><a href="http://www.justfreetemplates.com" title="free web templates">Free web templates</a></li>
                                <li><a href="http://www.spyka.net/forums" title="webmaster forums">Webmaster forums</a></li>
                                <li><a href="http://www.awesomestyles.com/mybb-themes" title="mybb themes">MyBB themes</a></li>
        
                                <li><a href="http://www.awesomestyles.com" title="free phpbb3 themes">phpBB3 styles</a></li>
                            </ul>
                        </li>
                        
                        <li>
            
                            <h4>Categories</h4>
                            <ul>
                              <li><a href="#">Lorem ipsum dolor sit amet.</a></li>
        
                              <li><a href="#">Quisque consequat nunc a felis.</a></li>
                              <li><a href="#">Suspendisse consequat magna at.</a></li>
                              <li><a href="#">Etiam eget diam id ligula rhoncus.</a></li>
                              <li><a href="#">Sed in mauris non nibh.</a></li>
                            </ul>
                        </li>
                        <li>
        
                            <h4>Sponsors</h4>
            
                            <ul>
            
                                <li><a href="http://www.themeforest.net/?ref=spykawg" title="premium templates"><strong>ThemeForest</strong></a> - premium HTML templates, WordPress themes and PHP scripts</li>
                                <li><a href="http://www.dreamhost.com/r.cgi?259541" title="web hosting"><strong>Web hosting</strong></a> - 50 dollars off when you use promocode <strong>awesome50</strong></li>
                                <li><a href="http://www.4templates.com/?aff=spykawg" title="4templates"><strong>4templates</strong></a> - brilliant premium templates</li>
        
            
                            </ul>
                        </li>
                    </ul> 
				</div>
			</div>
			<!-- end three column -->

			
			
			
		</div>
		
	</div>
	
	<div id="footer">
		<p>&copy; 2009. Design by <a href="http://www.spyka.net">Free CSS Templates</a> &amp; <a href="http://www.justfreetemplates.com">Free Web Templates</a></p>
	</div>

</div>
</body>
</html>
