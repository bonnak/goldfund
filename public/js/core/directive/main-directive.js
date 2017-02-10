app.directive('onlyNumbers', function() {
    return function(scope, element, attrs) {
        var keyCode =
            [
                8,9,13,37,39,46,48,49,50,51,52,53,54,55,56,57,96,97,
                98,99,100,101,102,103,104,105,110,190
            ];
        element.bind("keydown", function(event) {
            if($.inArray(event.which,keyCode) == -1) {
                scope.$apply(function(){
                    scope.$eval(attrs.onlyNum);
                    event.preventDefault();
                });
                event.preventDefault();
            }
        });
    };
});

app.directive('emptyData', function() {
    return {
        restrict: 'AE',
        template: "<div class='alert alert-warning alert-dismissible'><strong>{{'Warning' | translate }}</strong> {{'RecordNotFound' | translate }}</div>",
        link: function ($scope, element, att) {

        }
    }
});

/**
 * customer list directive
 */
app.directive('customerListDropDown', [
    function () {
        return {
            restrict: 'AE',
            scope: {
                ngModel: '=ngModel',
                required: '@required',
                name: '@name',
                id: '@id'
            },
            require: ['?ngModel'],
            templateUrl: 'js/ng/app/core/directive/customerListDropDown.html',
            controller: 'customerListDropDownCtrl as vm',
            link: function ($scope, element, attrs) {
                //@todo
            }
        };
    }
]);
/**
 * controller for customer list drop down
 */
app.controller('customerListDropDownCtrl', [
    '$scope',
    'Restful',
    function ($scope, Restful) {
        var vm = this;

        vm.localSelected = $scope.ngModel ? $scope.ngModel : '';

        //when local data is changed, update model from outside
        $scope.$watch('vm.localSelected', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if ($scope.ngModel != newValue) {
                $scope.ngModel = newValue;
            }
        });

        //when model from outside is changed, update local data
        $scope.$watch('ngModel', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if (newValue != vm.localSelected) {
                vm.localSelected = newValue;
            }
        });


        vm.customerLists = [];

        vm.bindCustomerList = function (filterText) {
            var params = {name: filterText};
            return Restful.get('api/CustomerList', params).then(function(response) {
                vm.customerLists = response.data.elements;
            });
        }
    }
]);


/**
 * doctor list directive
 */
app.directive('doctorListDropDown', [
    function () {
        return {
            restrict: 'AE',
            scope: {
                doctorModel: '=',
                required: '@required',
                name: '@name',
                id: '@id'
            },
            require: ['?ngModel'],
            templateUrl: 'js/ng/app/core/directive/doctorListDropDown.html',
            controller: 'doctorListDropDownCtrl as vm',
            link: function ($scope, element, attrs) {
                //@todo
            }
        };
    }
]);
/**
 * controller for customer list drop down
 */
app.controller('doctorListDropDownCtrl', [
    '$scope',
    'Restful',
    function ($scope, Restful) {
        var vm = this;

        vm.localSelected = $scope.customerModel ? $scope.customerModel : '';

        //when local data is changed, update model from outside
        $scope.$watch('vm.localSelected', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if ($scope.doctorModel != newValue) {
                $scope.doctorModel = newValue;
            }
        });

        //when model from outside is changed, update local data
        $scope.$watch('doctorModel', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if (newValue != vm.localSelected) {
                vm.localSelected = newValue;
            }
        });


        vm.doctorLists = [];

        vm.bindDoctorList = function (filterText) {
            var params = {name: filterText};
            return Restful.get('api/DoctorList', params).then(function(response) {
                vm.doctorLists = response.data.elements;
            });
        }
    }
]);




/********************************************
 * product list drop down directive
 *******************************************/
app.directive('productListDropDown', [
    function () {
        return {
            restrict: 'AE',
            scope: {
                productModel: '=',
                onChange: '&',
                required: '@required',
                name: '@name',
                id: '@id'
            },
            require: ['?ngModel'],
            templateUrl: 'js/ng/app/core/directive/productListDropDown.html',
            //replace: true,
            controller: 'productListDropDownCtrl as vm',
            link: function ($scope, element, attrs) {
                //@todo
            }
        };
    }
]);

/********************************************
 * controller for product list drop down
 *******************************************/
app.controller('productListDropDownCtrl', [
    '$scope',
    'Restful',
    function ($scope, Restful) {
        var vm = this;

        vm.localSelected = $scope.productModel ? $scope.productModel : '';

        //when local data is changed, update model from outside
        $scope.$watch('vm.localSelected', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if ($scope.productModel != newValue) {
                $scope.productModel = newValue;
            }
        });

        //when model from outside is changed, update local data
        $scope.$watch('productModel', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if (newValue != vm.localSelected) {
                vm.localSelected = newValue;
            }
        });


        vm.productLists = [];

        vm.bindProductList = function (filterText) {
            var params = {name: filterText, pagination: 'yes'};
            return Restful.get('api/products', params).then(function(response) {
                vm.productLists = response.data.elements;
            });
        }
    }
]);

/** ==========================================================
 * ====================== End ================================
 * ==========================================================*/

/********************************************
 * vendor list drop down directive
 *******************************************/
app.directive('vendorListDropDown', [
    function () {
        return {
            restrict: 'AE',
            scope: {
                vendorModel: '=',
                required: '@required',
                name: '@name',
                id: '@id'
            },
            require: ['?ngModel'],
            templateUrl: 'js/ng/app/core/directive/vendorListDropDown.html',
            controller: 'vendorListDropDownCtrl as vm',
            link: function ($scope, element, attrs) {
                //@todo
            }
        };
    }
]);

/********************************************
 * controller for vendorListDropDownCtrl drop down
 *******************************************/
app.controller('vendorListDropDownCtrl', [
    '$scope',
    'Restful',
    function ($scope, Restful) {
        var vm = this;

        vm.localSelected = $scope.vendorModel ? $scope.vendorModel : '';

        //when local data is changed, update model from outside
        $scope.$watch('vm.localSelected', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if ($scope.vendorModel != newValue) {
                $scope.vendorModel = newValue;
            }
        });

        //when model from outside is changed, update local data
        $scope.$watch('vendorModel', function (newValue, oldValue) {
            //check to make sure no loop cycle
            if (newValue != vm.localSelected) {
                vm.localSelected = newValue;
            }
        });


        vm.vendorLists = [];

        vm.bindVendorList = function (filterText) {
            var params = {name: filterText, paginate: 'yes'};
            return Restful.get('api/VendorList', params).then(function(response) {
                vm.vendorLists = response.data.elements;
            });
        }
    }
]);
/***************************************
 * Directive for permission user role **
 ***************************************/
app.directive('permission', ['Restful',
    function(Restful) {
        return {
            restrict: 'A',
            scope: {
                permission: '=',
                feature: '='
            },
            link: function ($scope, elem, attrs) {
                console.log($scope.feature);
                var found = false;
                $scope.featureRole = {};
                Restful.get('api/getUserInfo').success(function(data){
                    $scope.userPermission = data.elements[0].role_detail[0];
                    //console.log($scope.featureRole);
                    angular.forEach($scope.userPermission.permission, function(value, index){
                        //console.log(value);
                        //console.log(index);
                        if (value.feature_name == $scope.permission){
                            found = true;
                            return;
                        }
                    });
                    if(found){
                        elem.show();
                    }else{
                        elem.remove();
                    }
                });
            }
        }
    }
]);

