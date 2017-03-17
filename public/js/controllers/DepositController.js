angular.module('MetronicApp', ['blueimp.fileupload']).controller('DepositController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    'uploadManager',
    '$rootScope',
    function($scope, $anchorScroll, $state, Restful, uploadManager, $rootScope) {
        var vm = this;
        vm.model = {
            plan_id: '',
            amount: '',
            trans_password: '',
        };
        vm.plans = [];
        vm.deposits = [];
        vm.validation = {
            trans_password : ''
        };

        vm.save = function(){
            if (!$scope.depositForm.$valid) {
                $anchorScroll();
                return;
            }
            vm.loading = true;

            Restful.save('api/deposit', vm.model).success(function(data){
                $state.go('deposit_history');
            }).finally(function () {
                vm.loading= false;
            });
        };

        vm.getHistory = function(params){
            vm.loading = true;
            Restful.get('api/deposit/history').success(function(data){
                vm.deposits = data;
            }).finally(function(){
                vm.loading = false;
            });
        };

        vm.getQrCode = function(params){
            Restful.get('api/qr/admin/bitcoin').success(function(data){
                vm.qrcode = data;
            });
        };

        vm.getPlans = function(){
            Restful.get('/api/plans').success(function(data){
                vm.plans = data;
            });
        }

        vm.inValid = function(){
            return vm.model.amount < vm.model.min_deposit  || vm.model.amount > vm.model.max_deposit;
        }

        vm.showDepositModal = function(){
            Restful.post('/api/transaction/auth', { trans_password: vm.model.trans_password })
            .then(
                function(data){
                    $('#deposit_modal').modal();

                    vm.validation.trans_password = '';
                },
                function(response){
                    if(response.status !== 500){
                        vm.validation.trans_password = response.data.error;
                    }
                }
            );           
        }
        
        vm.getQrCode();
        vm.getPlans();
        vm.getHistory();
        $scope.$on('$viewContentLoaded', function() {});


        

        $scope.files = [];
        $scope.percentage = 0;

        $scope.upload = function () {
            uploadManager.upload();
            $scope.files = [];
        };

        $rootScope.$on('fileAdded', function (e, call) {
            $scope.files.push(call);
            $scope.$apply();
        });

        $rootScope.$on('uploadProgress', function (e, call) {
            $scope.percentage = call;
            $scope.$apply();
        });
    }
]).factory('uploadManager', function ($rootScope) {
    var _files = [];
    return {
        add: function (file) {
            _files.push(file);
            $rootScope.$broadcast('fileAdded', file.files[0].name);
        },
        clear: function () {
            _files = [];
        },
        files: function () {
            var fileNames = [];
            $.each(_files, function (index, file) {
                fileNames.push(file.files[0].name);
            });
            return fileNames;
        },
        upload: function () {
            $.each(_files, function (index, file) {
                file.submit();
            });
            this.clear();
        },
        setProgress: function (percentage) {
            $rootScope.$broadcast('uploadProgress', percentage);
        }
    };
}).directive('upload', ['uploadManager', function factory(uploadManager) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            $(element).fileupload({
                dataType: 'text',
                headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
                add: function (e, data) {
                    uploadManager.add(data);
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    uploadManager.setProgress(progress);
                },
                done: function (e, data) {
                    uploadManager.setProgress(0);
                }
            });
        }
    };
}]);
