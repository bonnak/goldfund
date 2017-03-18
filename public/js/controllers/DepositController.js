angular.module('MetronicApp').controller('DepositController', [
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
                $('#deposit_modal').on('hidden.bs.modal', function () {
                    $state.go('deposit_history');
                });
                
                $('#deposit_modal').modal('hide');
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
        vm.upload = {
            photo : null,
            percentage : 0,
            is_completed : false,
            in_progress : false
        }

        $rootScope.$on('fileAdded', function (e, call) {            
            uploadManager.upload();
            $scope.files.push(call);
            $scope.$apply();

            // Preview photo.
            vm.previewFiles();

            // Clear uploaded files.
            $scope.files = [];
            $("#bankslip-file").val('');
        });

        $rootScope.$on('uploadProgress', function (e, call) {
            $scope.vm.upload.percentage = call;
            $scope.vm.upload.in_progress = true;
            $scope.$apply();
        });

        $rootScope.$on('uploadResponseResult', function (e, result) {
            $scope.vm.upload.photo = result;
            setTimeout(function(){
                $scope.vm.upload.is_completed = true;
                $scope.vm.upload.in_progress = false;
                $scope.$apply();
            }, 200);
            $scope.$apply();
        });


        vm.previewFiles = function () {

          var preview = document.querySelector('#preview');
          var files   = document.querySelector('input[type=file]').files;

          $(preview).find('img').remove();

          function readAndPreview(file) {

            // Make sure `file.name` matches our extensions criteria
            if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
              var reader = new FileReader();

              reader.addEventListener("load", function () {
                var image = new Image();
                image.title = file.name;
                image.src = this.result;
                preview.appendChild( image );
              }, false);

              reader.readAsDataURL(file);
            }

          }

          if (files) {
            [].forEach.call(files, readAndPreview);
          }

        }
    }
]);
