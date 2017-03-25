/***
GLobal Directives
***/

//var MetronicApp = angular.module("MetronicApp"); 

// Route State Load Spinner(used on page or content load)
MetronicApp.directive('ngSpinnerBar', ['$rootScope',
    function($rootScope) {
        return {
            link: function(scope, element, attrs) {
                // by defult hide the spinner bar
                element.addClass('hide'); // hide spinner bar by default

                // display the spinner bar whenever the route changes(the content part started loading)
                $rootScope.$on('$stateChangeStart', function() {
                    element.removeClass('hide'); // show spinner bar
                });

                // hide the spinner bar on rounte change success(after the content loaded)
                $rootScope.$on('$stateChangeSuccess', function() {
                    element.addClass('hide'); // hide spinner bar
                    $('body').removeClass('page-on-load'); // remove page loading indicator
                    Layout.setSidebarMenuActiveLink('match'); // activate selected link in the sidebar menu
                   
                    // auto scorll to page top
                    setTimeout(function () {
                        App.scrollTop(); // scroll to the top on content load
                    }, $rootScope.settings.layout.pageAutoScrollOnLoad);     
                });

                // handle errors
                $rootScope.$on('$stateNotFound', function() {
                    element.addClass('hide'); // hide spinner bar
                });

                // handle errors
                $rootScope.$on('$stateChangeError', function() {
                    element.addClass('hide'); // hide spinner bar
                });
            }
        };
    }
])

// Handle global LINK click
MetronicApp.directive('a', function() {
    return {
        restrict: 'E',
        link: function(scope, elem, attrs) {
            if (attrs.ngClick || attrs.href === '' || attrs.href === '#') {
                elem.on('click', function(e) {
                    e.preventDefault(); // prevent link click for above criteria
                });
            }
        }
    };
});

// Handle Dropdown Hover Plugin Integration
MetronicApp.directive('dropdownMenuHover', function () {
  return {
    link: function (scope, elem) {
      elem.dropdownHover();
    }
  };  
});


MetronicApp.directive("onlyNumber", function () {
    return {
        restrict: "A",
        link: function (scope, element, attr) {
            element.bind('input', function () {
                var position = this.selectionStart - 1;

                //remove all but number and .
                var fixed = this.value.replace(/[^0-9\.]/g, '');  
                if (fixed.charAt(0) === '.')                  //can't start with .
                    fixed = fixed.slice(1);

                var pos = fixed.indexOf(".") + 1;
                if (pos >= 0)               //avoid more than one .
                    fixed = fixed.substr(0, pos) + fixed.slice(pos).replace('.', '');  

                if (this.value !== fixed) {
                    this.value = fixed;
                    this.selectionStart = position;
                    this.selectionEnd = position;
                }
            });
        }
    };
});

MetronicApp.directive('upload', ['uploadManager', function factory(uploadManager) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            $(element).fileupload({
                dataType: 'text',
                headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
                add: function (e, data) {
                    if(!attrs.hasOwnProperty('multiple')) uploadManager.clear();

                    uploadManager.add(data);
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    uploadManager.setProgress(progress);
                },
                done: function (e, data) {
                    uploadManager.setProgress(0);
                    uploadManager.setCompleted(true);
                    uploadManager.setResponse(data);
                },
                fail: function(e, data){
                    uploadManager.setCompleted(false);
                    uploadManager.setFails(data.response().jqXHR);
                }
            });
        }
    };
}]);