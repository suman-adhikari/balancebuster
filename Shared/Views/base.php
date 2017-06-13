
<!DOCTYPE html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


    <title><?php echo "BALANCE BUSTER" ?></title>

    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/style.default.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/prettify/prettify.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/validationEngine.jquery.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/jquery.Jcrop.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/jquery.minicolors.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/jquery.minicolors.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo BASE_URL ?>includes/styles/st.scss" />
    <link href="<?php echo BASE_URL ?>includes/styles/balancebuster.css" rel="stylesheet" />

    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery-ui-1.10.3.js"></script>

    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/Chart.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/ajaxGrid.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.ui.timepicker.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/dateTimepicker.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.validationEngine.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/validation.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.minicolors.min.js"></script>

    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/prettify/prettify.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/custom.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.dataTables.min.js"></script>


    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/json2.js"></script>

    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.flot.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.flot.resize.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>includes/scripts/Shared.js"></script>





</head>
<body>


<div class="mainwrapper fullwrapper">

    <!-- START OF LEFT PANEL -->
    <div class="leftpanel">

        <div class="logopanel">
            <h1><a>BALANCE BUSTER</a></h1>

        </div>
        <!--logopanel-->

        <div class="datewidget">Balance Buster</div>


        <div class="leftmenu">
            <ul class="nav nav-tabs nav-stacked">


                <li id="home-menu">
                    <a href="<?php echo BASE_URL ?>Home">
                        <span class="icon glyphicon glyphicon-check"></span>Home
                    </a>
                </li>


                <?php
                if($_SESSION["userType"]==1){ ?>
                    <li id="balance-menu">
                        <a href="<?php echo BASE_URL ?>Balance">
                            <span class="icon glyphicon glyphicon-check"></span>Balance
                        </a>
                    </li>

                <?php }
                ?>

                <li id="dashboard-menu">
                    <a href="<?php echo BASE_URL ?>Dashboard">
                        <span class="icon glyphicon glyphicon-dashboard"></span>Dashboard
                    </a>
                </li>

                <li id="setting-menu">
                    <a href="<?php echo BASE_URL ?>Setting">
                        <span class="icon glyphicon glyphicon-dashboard"></span>Setting
                    </a>
                </li>

                </li>
                <li id="menu-StatisticsChart" class="dropdown animate8 fadeInUp">
                    <a href="">
                        <span class="glyphicon glyphicon-stats"></span>
                        <?php echo  "Statistics" ?> </a>
                    <ul style="display: none;">
                        <li id="menu-generalStatistics">
                            <a href="<?php echo  BASE_URL ?>GeneralStatistics"><?php echo "General Statistics" ?></a>
                        </li>
                        <li id="menu-detailedStatistics">
                            <a href="<?php echo  BASE_URL ?>DetailedStatistics"><?php echo "Detailed Statistics" ?></a>
                        </li>

                        <li id="menu-summaryStatistics">
                            <a href="<?php echo  BASE_URL ?>SummaryStatistics"><?php echo "Summary" ?></a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>


    </div>
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->

    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
        <div class="headerpanel">

            <a href="" class="showmenu"></a>

            <div class="headerright">
                <div class="change-language form-inline" style="display:inline-block">
                </div>

                <div class="dropdown userinfo" style="vertical-align: top;margin-right: 5px">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#"
                       href="/page.html"><?php echo "Setting" ?>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">

                        <?php if(isset($_SESSION['UserType']) && $_SESSION['UserType']!=2) : ?>
                            <li>
                                <a onclick="showAddNewForm('Change Password','<?php echo BASE_URL ?>ChangePassword/Form?RedirectUrl=http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>',400,250);return false;"
                                   href=""><span class="icon-edit"></span><?php echo "Change Password " ?> </a>

                            </li>
                            <li class="divider"></li>
                        <?php endif ?>
                        <li><a href="<?php echo BASE_URL ?>Logout"><span class="icon-off"></span> <?php echo "Logout" ?></a></li>
                    </ul>
                </div>
                <!--dropdown-->

            </div>

            <!--headerright-->

        </div>
        <!--headerpanel-->
        <div class="breadcrumbwidget">
            <ul class="breadcrumb">
                <?php echo $Breadcrumb?>
            </ul>
        </div>
        <!--breadcrumbwidget-->
     <!--   <div class="pagetitle">
            <h1 class="page-title"><?php /*echo $PageTitle */?></h1>

            <div class="pull-right server-title"><?php /*echo $PageLeftHeader */?></div>
        </div>-->
        <!--pagetitle-->

        <div class="maincontent">
            <div class="contentinner content-dashboard">


                 <?php if(isset($_SESSION["ConfirmationMessage"]) && $_SESSION["ConfirmationMessage"] != null): ?>

                    <div id="MessageBox">
                        <?php include_once 'C:/wamp64/www/BalanceBuster/Shared/Views/ConformationMessage.php'; ?>
                    </div>
                <?php endif ?>



                <div class="row-fluid">

<script>
    <?php if(isset($_SESSION["ConfirmationMessage"]) && $_SESSION["ConfirmationMessage"] != null){
    unset($_SESSION["ConfirmationMessage"]);
    }
    ?>
</script>