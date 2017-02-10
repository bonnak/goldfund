var app = angular.module(
    'app',
    [
        'ui.router'
        , 'ui.bootstrap'
        , 'ngSanitize'
    ]
);


app.controller(
    'main_ctrl', [
        '$scope'
        , 'Restful'
        , 'Services'
        , '$translate'
        , '$rootScope'
        , function ($scope, Restful, Services, $translate, $rootScope){
            $scope.dateCopyRight = new Date();
            $scope.role = $('#role').data('role');
            $scope.changeLanguage = function (key) {
                $translate.use(key);
            };
            $scope.dateFormat = 'y-MM-dd';

            $rootScope.$on("InitSettingMethod", function(){
                $scope.initSetting();
            });
            $scope.featureRole = {};
            $scope.initSetting = function(){
                Restful.get('api/setting').success(function(data){
                    $scope.company = data.elements[0];
                });
                Restful.get('api/countries').success(function(data){
                    $scope.countries = data;
                });
                Restful.get('api/getUserInfo').success(function(data){
                    $scope.userName = data.elements[0].user_name;
                    $scope.featureRole = data.elements[0].role_detail[0];
                    console.log($scope.featureRole);
                });
            };
            $scope.initSetting();

            $scope.checkPermission = function(string){
                var found = 0;
                angular.forEach($scope.featureRole.permission, function(value, index){
                    //console.log(value.feature_name);
                    //console.log(index);
                    if (value.feature_name == string){
                        found = value.is_selected;
                        return;
                    }
                });
                return found;
            };
        }
    ]
);
