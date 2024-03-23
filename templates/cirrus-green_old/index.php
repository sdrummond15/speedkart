<?php

/**

 * @subpackage    Cirrus Green v1.6 HM02J

 * @copyright    Copyright (C) 2010-2013 Hurricane Media - All rights reserved.

 * @license        GNU General Public License version 2 or later; see LICENSE.txt

 */

defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
$document->addStyleSheet($this->baseurl . '/templates/system/css/system.css');
$document->addStyleSheet($this->baseurl . '/templates/system/css/general.css');
$document->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/bootstrap.min.css');
$document->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css');
$document->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/panton.min.css');
$document->addScript($this->baseurl . '/templates/' . $this->template . '/js/sfhover.js');
$document->addScript($this->baseurl . '/templates/' . $this->template . '/js/popover.min.js');
$document->addScript($this->baseurl . '/templates/' . $this->template . '/js/bootstrap.min.js');
$document->addScript($this->baseurl . '/templates/' . $this->template . '/js/script_main.js');

$LeftMenuOn = ($this->countModules('position-4') or $this->countModules('position-7'));

$RightMenuOn = ($this->countModules('position-6') or $this->countModules('position-3'));

$TopNavOn = ($this->countModules('position-13'));

$app = JFactory::getApplication();

$sitename = $app->getCfg('sitename');

$logopath = $this->baseurl . '/templates/' . $this->template . '/images/logo-demo-green.gif';

$logo = $this->params->get('logo', $logopath);

$logoimage = $this->params->get('logoimage');

$sitetitle = $this->params->get('sitetitle');

$sitedescription = $this->params->get('sitedescription');

?>



<?php

$app = JFactory::getApplication();

$menu = $app->getMenu();

$lang = JFactory::getLanguage();

$home = 0;

$backhome = '';

$backfooter = '';

$backtophome = 'class="home-top-article"';

$backbottomhome = 'class="home-bottom-article"';

$backvideohome = '';

if ($menu->getActive() == $menu->getDefault($lang->getTag())) {

    $home = 1;

    $backhome = 'class="home-article"';

    $backfooter = 'class="home-footer"';

    $backvideohome = 'class="home-video"';

}



?>



<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>"

      lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"

      style="overflow-y: scroll !important;">

<head>

    <meta name="viewport" content="width=device-width, user-scalable=no"/>

    <jdoc:include type="head"/>

    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css"/>

    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css"/>

    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css"

          type="text/css"/>
<link rel="stylesheet" href="media/system/css/colorbox.css" type="text/css"/>
    <script src="media/system/js/jquery.colorbox-min.js" type="text/javascript"></script>
    <script src="<?php echo $this->baseurl ?>/media/system/js/modal.js" type="text/javascript"></script>

    <link rel="stylesheet"

          href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/font-awesome.min.css"

          type="text/css"/>

    <link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'/>

    <script type="text/javascript"

            src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/sfhover.js"></script>

    <script>

        (function (i, s, o, g, r, a, m) {

            i['GoogleAnalyticsObject'] = r;

            i[r] = i[r] || function () {

                (i[r].q = i[r].q || []).push(arguments)

            }, i[r].l = 1 * new Date();

            a = s.createElement(o),

                m = s.getElementsByTagName(o)[0];

            a.async = 1;

            a.src = g;

            m.parentNode.insertBefore(a, m)

        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');



        ga('create', 'UA-24132529-45', 'auto');

        ga('send', 'pageview');



    </script>



</head>

<body>



<div id="wrapper">



    <div id="header_wrap">



        <div id="header">



            <!-- Logo -->

            <div id="logo">



                <?php if ($logo && $logoimage == 1): ?>

                    <a href="<?php echo $this->baseurl ?>">

                        <img src="<?php echo htmlspecialchars($logo); ?>" alt="<?php echo $sitename; ?>"/>

                    </a>

                <?php endif; ?>

                <?php if (!$logo || $logoimage == 0): ?>



                    <?php if ($sitetitle): ?>

                        <a href="<?php echo $this->baseurl ?>"><?php echo htmlspecialchars($sitetitle); ?></a><br/>

                    <?php endif; ?>



                    <?php if ($sitedescription): ?>

                        <div class="sitedescription"><?php echo htmlspecialchars($sitedescription); ?></div>

                    <?php endif; ?>



                <?php endif; ?>



            </div>




            <div class="menutop">

                <div id="topmenu_wrap">

                    <!-- Search -->

                    <?php if ($this->countModules('position-0')): ?>

                        <div id="midias">

                            <jdoc:include type="modules" name="position-0"/>

                        </div>

                    <?php endif; ?>

                    <!-- Menu Principal -->

                    <div id="topmenu">

                        <jdoc:include type="modules" name="position-1"/>

                    </div>

                </div>



                <div class="gotomenu">

                    <div id="gotomenu">

                        <i class="fa fa-bars smallmenu" aria-hidden="true"></i>

                    </div>

                </div>

                <div class="menuresp">

                    <jdoc:include type="modules" name="position-1"/>

                </div>

            </div>

        </div>

    </div>



    <!-- TopNav -->

    <?php if ($TopNavOn): ?>

        <div id="topnav_wrap">

            <div id="topnav">

                <jdoc:include type="modules" name="position-13" style="xhtml"/>

            </div>

        </div>

    <?php endif; ?>



    <?php if ($this->countModules('position-4')): ?>

        <div class="gotomenuprod">

            <div id="gotomenuprod">

                Serviços &nbsp;&nbsp;<i class="fa fa-angle-double-down smallmenuprod" aria-hidden="true"></i>

            </div>

        </div>

        <div class="menurespprod">

            <jdoc:include type="modules" name="position-4" style="xhtml"/>

        </div>

    <?php endif; ?>



    <!-- Breadcrumbs -->

    <?php if ($this->countModules('position-2')): ?>

        <div id="breadcrumbs">

            <jdoc:include type="modules" name="position-2"/>

        </div>

    <?php endif; ?>


    <div <?php echo $backtophome; ?>></div>



    <?php if ($this->countModules('position-12')): ?>

        <div id="content-top">

            <jdoc:include type="modules" name="position-12"/>

        </div>

    <?php endif; ?>



    <?php if ($this->countModules('position-5')): ?>

        <div id="content-bottom">

            <jdoc:include type="modules" name="position-5" style="xhtml"/>

        </div>

    <?php endif; ?>





    <!-- Content/Menu Wrap -->

    <div id="content-menu_wrap_bg" <?php echo $backhome; ?> >

        <div id="content-menu_wrap">



            <!-- Left Menu -->

            <?php if ($LeftMenuOn): ?>

                <div id="leftmenu">

                    <jdoc:include type="modules" name="position-7" style="xhtml"/>

                </div>

            <?php endif; ?>





            <!-- Contents -->

            <?php

            if ($LeftMenuOn AND $RightMenuOn):

                $w = 'w1';

            elseif ($LeftMenuOn OR $RightMenuOn):

                $w = 'w2';

            else:

                $w = 'w3';

            endif;

            ?>

            <div id="content-<?php echo $w; ?>">

                <jdoc:include type="message"/>

                <jdoc:include type="component"/>

            </div>





            <!-- Right Menu -->

            <?php if ($RightMenuOn): ?>

                <div id="rightmenu">

                    <jdoc:include type="modules" name="position-6" style="xhtml"/>

                    <jdoc:include type="modules" name="position-3" style="xhtml"/>

                </div>

            <?php endif; ?>





        </div>

    </div>

    <div <?php echo $backbottomhome; ?>></div>



    <!-- Units -->

    <?php if ($this->countModules('position-8')): ?>

        <div id="footer_wrap_map">

            <div id="footer_map">

                <jdoc:include type="modules" name="position-8"/>

            </div>

            <div <?php echo $backvideohome; ?>></div>

        </div>

    <?php endif; ?>





    <div id="bottom_wrap">

        <!-- Banner/Links -->

        <?php if (($this->countModules('position-9')) || ($this->countModules('position-10')) || ($this->countModules('position-11'))): ?>

            <div id="box_wrap">

                <div id="box_placeholder">

                    <div id="box1">

                        <jdoc:include type="modules" name="position-9" style="xhtml"/>

                    </div>

                    <div id="box2">

                        <jdoc:include type="modules" name="position-10" style="xhtml"/>

                    </div>

                    <div id="box3">

                        <jdoc:include type="modules" name="position-11" style="xhtml"/>

                    </div>

                </div>

            </div>

        <?php endif; ?>



        <!-- Footer -->

        <?php if ($this->countModules('position-14')): ?>

            <div id="footer_wrap" <?php echo $backfooter; ?> >

                <div id="footer">

                    <jdoc:include type="modules" name="position-14" style="xhtml"/>

                </div>

            </div>

        <?php endif; ?>



        <!-- Page End -->

        <div id="copyright">

            <div class="copyrightint">

                Copyright &copy;<?php echo date('Y'); ?> <?php echo $sitename; ?> - Todos os direitos reservados

                <a class="sd" href="http://www.sdrummond.com.br" title="Sdrummond Tecnologia" target="_blank">

                    <img src="images/sd.png" alt="Sdrummond Tecnologia" title="Sdrummond Tecnologia"/>

                </a>

            </div>

        </div>

    </div>

</div>

<script>

    jQuery.noConflict();

    jQuery(function () {

        jQuery(window).on('resize', function () {

            var largura = jQuery(window).width();



            if (largura <= 1030) {

                jQuery('#topmenu').hide();

                jQuery("#topmenu").css('visibility', 'hidden');

                jQuery("#gotomenu").show();

                jQuery('.gotomenu').show();

                jQuery('.gotomenu').css('visibility', 'visible');

            }

            else {

                jQuery('#topmenu').show();

                jQuery("#topmenu").css('visibility', 'visible');

                jQuery('#gotomenu').hide();

                jQuery('.menuresp').hide();

                jQuery('.gotomenu').hide();

                jQuery('.gotomenu').css('visibility', 'hidden');

            }



            /**** MENU ****/

            var logo = jQuery('#logo a img');

            var divLogo = jQuery('#logo a');

            var menu = jQuery('#topmenu');

            var menuResp = jQuery(".gotomenu");

            jQuery(document).on('scroll', function () {

                if (jQuery(window).scrollTop() > 0) {

                    logo.addClass('diminuirLogo');

                    divLogo.css('padding', '5px 20px');

                    menu.css('margin-top', 15);

                    menuResp.css('padding-top', 10);

                } else {

                    logo.removeClass('diminuirLogo');

                    divLogo.css('padding', '20px 30px');

                    menu.css('margin-top', 45);

                    menuResp.css('padding-top', 40);

                }



            });

            /**** FIM MENU ****/



        }).trigger('resize');



    });





    //MENU RESPONSIVO



    jQuery('.menuresp').hide();



    jQuery('.menuresp ul ul').hide();

    jQuery('.menuresp li span.separator').append(' <i class="fa fa-angle-down" aria-hidden="true"></i>\n');

    jQuery('.menuresp li span.separator').click(function () {

        jQuery(this).siblings('ul').slideToggle("slow");

        jQuery(".fa-angle-down, .fa-angle-up").toggleClass("fa-angle-down fa-angle-up");

    });



    jQuery("#gotomenu").click(function () {

        jQuery('.menuresp').css('visibility', 'visible');

        jQuery('.menuresp').slideToggle();

    });



    jQuery('.moduletable-menu-regulamento h3').append(' <i class="fa fa-angle-down" aria-hidden="true"></i>\n');

    jQuery('.moduletable-menu-regulamento h3').click(function () {

        jQuery(this).siblings('ul').slideToggle("slow");

        jQuery(".fa-angle-down, .fa-angle-up").toggleClass("fa-angle-down fa-angle-up");

    });



    jQuery(document).ready(function ($) {

        jQuery(".scroll").click(function (event) {

            event.preventDefault();

            jQuery('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);

        });

    });



    //LEFT MENU RESPONSIVO



    jQuery('.menurespprod').hide();



    jQuery("#gotomenuprod").click(function () {

        jQuery('.menurespprod').css('visibility', 'visible');

        jQuery('.menurespprod').slideToggle(500);

    });



</script>

</body>

</html>

