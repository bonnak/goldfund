
/* Setup App Main Controller */
MetronicApp.controller('AppController', [
    '$scope',
    '$rootScope',
    '$location',
    '$interval',
    'Restful',
    function($scope, $rootScope, $location, $interval, Restful) {
        $scope.$on('$viewContentLoaded', function() {
            App.initComponents(); // init core components
            // Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials
            // included in server side instead of loading with ng-include directive
        });
        $scope.initSetting = function(){
            Restful.get('/user/getProfile').success(function(result){
                $scope.userProfile = result;

                var deposit = $scope.userProfile.deposit;

                if(deposit !== null){
                    $scope.expire_from_now = moment(deposit.expire_date, "YYYY-MM-DD").diff(moment(), 'days');
                    if($scope.expire_from_now <= 5){
                        $('#modal-alert-expire').modal();
                    }
                }

            });
        };

        $scope.autoLogout = function(){
            $(window).on("blur focus", function(e) {
                var stopTime;
                var prevType = $(this).data("prevType");

                if (prevType != e.type) {
                    switch (e.type) {
                        case "blur":
                            stopTime = $interval(function(){                 
                                window.location.assign('/logout');
                            }, 60000);
                            break;
                        case "focus":
                            $interval.cancel(stopTime);
                            break;
                    }
                }

                $(this).data("prevType", e.type);
            });
            
            // $interval(function(){
            //     Restful.get('/user/getProfile').error(function(result){                  
            //         window.location.assign('/logout');
            //     });
            // }, 660000);
        }

        $scope.initSetting();
        $scope.autoLogout();

        $rootScope.$on("InitSettingMethod", function(){
            $scope.initSetting();
        });
    }
]);
