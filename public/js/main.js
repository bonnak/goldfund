/***
Metronic AngularJS App Main Script
***/

/* Metronic App */
var MetronicApp = angular.module("MetronicApp", [
    "ui.router", 
    "ui.bootstrap", 
    "oc.lazyLoad",  
    "ngSanitize"
]); 

/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
MetronicApp.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
    $ocLazyLoadProvider.config({
        // global configs go here
    });
}]);

/********************************************
 BEGIN: BREAKING CHANGE in AngularJS v1.3.x:
*********************************************/
/**
`$controller` will no longer look for controllers on `window`.
The old behavior of looking on `window` for controllers was originally intended
for use in examples, demos, and toy apps. We found that allowing global controller
functions encouraged poor practices, so we resolved to disable this behavior by
default.

To migrate, register your controllers with modules rather than exposing them
as globals:

Before:

```javascript
function MyController() {
  // ...
}
```

After:

```javascript
angular.module('myApp', []).controller('MyController', [function() {
  // ...
}]);

Although it's not recommended, you can re-enable the old behavior like this:

```javascript
angular.module('myModule').config(['$controllerProvider', function($controllerProvider) {
  // this option might be handy for migrating old apps, but please don't use it
  // in new ones!
  $controllerProvider.allowGlobals();
}]);
**/

//AngularJS v1.3.x workaround for old style controller declarition in HTML
MetronicApp.config(['$controllerProvider', function($controllerProvider) {
  // this option might be handy for migrating old apps, but please don't use it
  // in new ones!
  $controllerProvider.allowGlobals();
}]);

/********************************************
 END: BREAKING CHANGE in AngularJS v1.3.x:
*********************************************/

/* Setup global settings */
MetronicApp.factory('settings', ['$rootScope', function($rootScope) {
    // supported languages
    var settings = {
        layout: {
            pageSidebarClosed: false, // sidebar menu state
            pageContentWhite: true, // set page content layout
            pageBodySolid: false, // solid body color state
            pageAutoScrollOnLoad: 1000 // auto scroll to top on page load
        },
        assetsPath: '../assets',
        globalPath: '../assets/global',
        layoutPath: '../assets/layouts/layout4',
    };

    $rootScope.settings = settings;

    return settings;
}]);

/***
Layout Partials.
By default the partials are loaded through AngularJS ng-include directive. In case they loaded in server side(e.g: PHP include function) then below partial 
initialization can be disabled and Layout.init() should be called on page load complete as explained above.
***/

/* Setup Layout Part - Header */
MetronicApp.controller('HeaderController', ['$scope', function($scope) {
    $scope.$on('$includeContentLoaded', function() {
        Layout.initHeader(); // init header
    });
}]);

/* Setup Layout Part - Sidebar */
MetronicApp.controller('SidebarController', ['$scope', function($scope) {
    $scope.$on('$includeContentLoaded', function() {
        Layout.initSidebar(); // init sidebar
    });
}]);

/* Setup Layout Part - Sidebar */
MetronicApp.controller('PageHeadController', ['$scope', function($scope) {
    $scope.$on('$includeContentLoaded', function() {        
        Demo.init(); // init theme panel
    });
}]);

/* Setup Layout Part - Quick Sidebar */
MetronicApp.controller('QuickSidebarController', ['$scope', function($scope) {    
    $scope.$on('$includeContentLoaded', function() {
       setTimeout(function(){
            QuickSidebar.init(); // init quick sidebar        
        }, 2000)
    });
}]);

/* Setup Layout Part - Theme Panel */
MetronicApp.controller('ThemePanelController', ['$scope', function($scope) {    
    $scope.$on('$includeContentLoaded', function() {
        Demo.init(); // init theme panel
    });
}]);

/* Setup Layout Part - Footer */
MetronicApp.controller('FooterController', ['$scope', function($scope) {
    $scope.$on('$includeContentLoaded', function() {
        Layout.initFooter(); // init footer
    });
}]);

/* Setup Rounting For All Pages */
MetronicApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
    // Redirect any unmatched url
    $urlRouterProvider.otherwise("dashboard.html");
    
    $stateProvider

        // Dashboard
        .state('dashboard', {
            url: "/dashboard.html",
            templateUrl: "views/dashboard.html",
            data: {pageTitle: 'User Dashboard'},
            controller: "DashboardController as vm",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        //insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID.
                        // Dynamic CSS files must be loaded between core and theme css files
                        files: [
                            'js/controllers/DashboardController.js',
                        ]
                    });
                }]
            }
        })

        // Blank Page
        .state('deposit', {
            url: "/deposit.html",
            templateUrl: "views/deposit.html",
            data: {pageTitle: 'Make Deposit'},
            controller: "DepositController as vm",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
                        files: [
                            'css-template/plan_style.css',
                            'js/controllers/DepositController.js',
                        ] 
                    });
                }]
            }
        })

        // AngularJS plugins
        .state('request_payment', {
            url: "/request_payment.html",
            templateUrl: "views/request_payment.html",
            data: {pageTitle: 'Request Payment'},
            controller: "RequestPaymentController as vm",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([{
                        name: 'angularFileUpload',
                        files: [
                            'js/controllers/RequestPaymentController.js',
                        ]
                    }]);
                }]
            }
        })

        // UI Select
        .state('deposit_list', {
            url: "/deposit_list.html",
            templateUrl: "views/deposit_list.html",
            data: {pageTitle: 'Deposit Information'},
            controller: "DepositListController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([{
                        name: 'ui.select',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            '../assets/global/plugins/angularjs/plugins/ui-select/select.min.css',
                            '../assets/global/plugins/angularjs/plugins/ui-select/select.min.js'
                        ] 
                    }, {
                        name: 'MetronicApp',
                        files: [
                            'js/controllers/UISelectController.js'
                        ] 
                    }]);
                }]
            }
        })

        .state('user_profile', {
            url: "/user_profile.html",
            templateUrl: "views/user_profile.html",
            data: {pageTitle: 'User Profile'},
            controller: "UserProfileController as vm",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([{
                        name: 'MetronicApp',
                        files: [
                            'js/controllers/UserProfileController.js'
                        ]
                    }]);
                }]
            }
        })
        .state('user_profile_edit', {
            url: "/user_profile_edit.html",
            templateUrl: "views/user_profile_edit.html",
            data: {pageTitle: 'Edit User Profile'},
            controller: "UserProfileEditController as vm",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load([{
                        name: 'MetronicApp',
                        files: [
                            'js/controllers/UserProfileEditController.js'
                        ]
                    }]);
                }]
            }
        })
        //// Tree View
        //.state('tree', {
        //    url: "/tree",
        //    templateUrl: "views/tree.html",
        //    data: {pageTitle: 'jQuery Tree View'},
        //    controller: "GeneralPageController",
        //    resolve: {
        //        deps: ['$ocLazyLoad', function($ocLazyLoad) {
        //            return $ocLazyLoad.load([{
        //                name: 'MetronicApp',
        //                insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
        //                files: [
        //                    '../assets/global/plugins/jstree/dist/themes/default/style.min.css',
        //
        //                    '../assets/global/plugins/jstree/dist/jstree.min.js',
        //                    '../assets/pages/scripts/ui-tree.min.js',
        //                    'js/controllers/GeneralPageController.js'
        //                ]
        //            }]);
        //        }]
        //    }
        //})
        //// User Profile
        //.state("profile", {
        //    url: "/profile",
        //    templateUrl: "views/profile/main.html",
        //    data: {pageTitle: 'User Profile'},
        //    controller: "UserProfileController",
        //    resolve: {
        //        deps: ['$ocLazyLoad', function($ocLazyLoad) {
        //            return $ocLazyLoad.load({
        //                name: 'MetronicApp',
        //                insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
        //                files: [
        //                    'js/controllers/UserProfileController.js'
        //                ]
        //            });
        //        }]
        //    }
        //})

        // User Profile
        //.state("profile", {
        //    url: "/profile.html",
        //    templateUrl: "views/profile/dashboard.html",
        //    data: {pageTitle: 'User Profile'}
        //})

        // User Profile Account
        //.state("profile.account", {
        //    url: "/account",
        //    templateUrl: "views/profile/account.html",
        //    data: {pageTitle: 'User Account'}
        //})
        //
        //// User Profile Help
        //.state("profile.help", {
        //    url: "/help",
        //    templateUrl: "views/profile/help.html",
        //    data: {pageTitle: 'User Help'}
        //})
        //
        //// Todo
        //.state('todo', {
        //    url: "/todo",
        //    templateUrl: "views/todo.html",
        //    data: {pageTitle: 'Todo'},
        //    controller: "TodoController",
        //    resolve: {
        //        deps: ['$ocLazyLoad', function($ocLazyLoad) {
        //            return $ocLazyLoad.load({
        //                name: 'MetronicApp',
        //                insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
        //                files: [
        //                    '../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        //                    '../assets/apps/css/todo-2.css',
        //                    '../assets/global/plugins/select2/css/select2.min.css',
        //                    '../assets/global/plugins/select2/css/select2-bootstrap.min.css',
        //
        //                    '../assets/global/plugins/select2/js/select2.full.min.js',
        //
        //                    '../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        //
        //                    '../assets/apps/scripts/todo-2.min.js',
        //
        //                    'js/controllers/TodoController.js'
        //                ]
        //            });
        //        }]
        //    }
        //})

}]);

/* Init global settings and run the app */
MetronicApp.run(["$rootScope", "settings", "$state", function($rootScope, settings, $state) {
    $rootScope.$state = $state; // state to be accessed from view
    $rootScope.$settings = settings; // state to be accessed from view
}]);