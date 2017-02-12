<!DOCTYPE html>
<html lang="en" data-ng-app="MetronicApp">
<head>
    <title data-ng-bind="'{{env('APP_TITLE')}} | ' + $state.current.data.pageTitle"></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN DYMANICLY LOADED CSS FILES(all plugin and page related styles must be loaded between GLOBAL and THEME css files ) -->
    <link id="ng_load_plugins_before" />
    <!-- END DYMANICLY LOADED CSS FILES -->
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="{{ URL::asset('assets/global/css/components-rounded.min.css') }}" id="style_components" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/layouts/layout4/css/themes/light.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ URL::asset('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
</head>
<body ng-controller="AppController"
      class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo page-on-load"
      ng-class="{'page-sidebar-closed': settings.layout.pageSidebarClosed}">
<!-- BEGIN PAGE SPINNER -->
<div ng-spinner-bar class="page-spinner-bar">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
<!-- END PAGE SPINNER -->
<!-- BEGIN HEADER -->
<div data-ng-include="'tpl/header.html'" data-ng-controller="HeaderController" class="page-header navbar navbar-fixed-top"> </div>
<!-- END HEADER -->
<div class="clearfix"> </div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div data-ng-include="'tpl/sidebar.html'" data-ng-controller="SidebarController" class="page-sidebar-wrapper"> </div>
    <!-- END SIDEBAR -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEAD -->
            <div data-ng-include="'tpl/page-head.html'" data-ng-controller="PageHeadController" class="page-head"> </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN ACTUAL CONTENT -->
            <div ui-view class="fade-in-up"> </div>
            <!-- END ACTUAL CONTENT -->
        </div>
    </div>
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
    </a>
    <div data-ng-include="'tpl/quick-sidebar.html'" data-ng-controller="QuickSidebarController" class="page-quick-sidebar-wrapper"></div>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div data-ng-include="'tpl/footer.html'" data-ng-controller="FooterController" class="page-footer"> </div>
<!-- END FOOTER -->




<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE JQUERY PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ URL::asset('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::asset('assets/global/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE JQUERY PLUGINS -->
<!-- BEGIN CORE ANGULARJS PLUGINS -->
<script src="{{ URL::asset('assets/global/plugins/angularjs/angular.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/angularjs/angular-sanitize.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/angularjs/angular-touch.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/angularjs/plugins/angular-ui-router.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/angularjs/plugins/ocLazyLoad.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/angularjs/plugins/ui-bootstrap-tpls.min.js') }}" type="text/javascript"></script>
<!-- END CORE ANGULARJS PLUGINS -->
<!-- BEGIN APP LEVEL ANGULARJS SCRIPTS -->
<script src="{{ URL::asset('js/main.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/core/restful/restful.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/controllers/appController.js') }}" type="text/javascript"></script>
<script src="js/directives.js" type="text/javascript"></script>
<!-- END APP LEVEL ANGULARJS SCRIPTS -->
<!-- BEGIN APP LEVEL JQUERY SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
<!-- END APP LEVEL JQUERY SCRIPTS -->
<!-- END JAVASCRIPTS -->

</body>
</html>
