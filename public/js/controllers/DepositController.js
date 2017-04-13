angular.module('MetronicApp').controller('DepositController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    'uploadManager',
    '$rootScope',
    '$sce',
    function($scope, $anchorScroll, $state, Restful, uploadManager, $rootScope, $sce) {
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
        vm.upload = {
            photo : null,
            percentage : 0,
            is_success : null,
            in_progress : false
        };
        vm.allow_deposited = null;

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
            Restful.get('api/deposit/history').success(function(data){
                vm.deposits = data;

                if(vm.deposits.length === 0){
                    vm.allow_deposited = true;
                }else if(vm.deposits.length >0){
                    vm.allow_deposited = false;

                    vm.deposits.forEach(function(deposit){
                        if(deposit.status !== 0 && deposit.status !== 1){
                            vm.allow_deposited = true;
                        }
                    });
                }
            });
        };

        vm.getQrCode = function(params){
            Restful.get('api/qr/admin/bitcoin').success(function(data){
                vm.qr_code = data.qr_code;
                vm.bitcoin_address = data.bitcoin_address;
            });
        };

        vm.getPlans = function(){
            Restful.get('/api/plans').success(function(data){
                vm.plans = data;
            });
        };

        vm.inValid = function(){
            return vm.model.amount < vm.model.min_deposit  || vm.model.amount > vm.model.max_deposit;
        };

        vm.showDepositModal = function(){
            // Restful.post('/api/transaction/auth', { trans_password: vm.model.trans_password })
            // .then(
            //     function(data){
            //         Restful.get('/api/payment/crypto?deposit_amount=' + vm.model.amount).then(
            //             function(response){
            //                 vm.languages_list = $sce.trustAsHtml(response.data.languages_list);
            //                 vm.paymentbox = $sce.trustAsHtml(response.data.paymentbox);

            //                 $('#deposit_modal').modal();
            //                 vm.validation.trans_password = '';
            //             }
            //         );
            //     },
            //     function(response){
            //         if(response.status !== 500){
            //             vm.validation.trans_password = response.data.error;
            //         }
            //     }
            // );   
            
            vm.loading = true;

            Restful.save('api/deposit', vm.model).then(function(data){
                // $('#deposit_modal').on('hidden.bs.modal', function () {
                //     $state.go('deposit_history');
                // });
                
                // $('#deposit_modal').modal('hide');
            }, function(err_response){
                console.log(err_response);
            }).finally(function () {
                vm.loading= false;
            });      
        };

        vm.initialConfigUpload = function(){
            $rootScope.$on('fileAdded', function (e, call) { 
                $scope.vm.upload.percentage = 0;      
                uploadManager.upload();

                // Clear uploaded files.
                $("#bankslip-file").val('');
                $scope.$apply();
            });

            $rootScope.$on('uploadProgress', function (e, call) {
                $scope.vm.upload.percentage = call;
                $scope.vm.upload.in_progress = true;
                $scope.$apply();
            });

            $rootScope.$on('uploadResponseResult', function (e, result) {
                $scope.vm.upload.photo = result;
                vm.model.bankslip = result;
                setTimeout(function(){
                    $scope.vm.upload.is_success = true;
                    $scope.vm.upload.in_progress = false;
                    $scope.$apply();
                }, 200);
                $scope.$apply();
            });

            $rootScope.$on('uploadResponseFails', function (e, err_res) {
                $scope.vm.upload = Object.assign($scope.vm.upload, JSON.parse(err_res.responseText)); 
                $scope.vm.upload.percentage = 0; 
                $scope.vm.upload.in_progress = false; 
                $scope.vm.upload.is_success = false;    
                $scope.$apply();

                console.log($scope.vm.upload);
            });
        };
        
        vm.getQrCode();
        vm.getPlans();
        vm.getHistory();
        vm.initialConfigUpload();
        $scope.$on('$viewContentLoaded', function() {});  
    }
]);



// vm.previewFiles = function () {
//   var preview = document.querySelector('#preview');
//   var files   = document.querySelector('input[type=file]').files;

//   //$(preview).find('img').remove();

//   function readAndPreview(file) {

//     // Make sure `file.name` matches our extensions criteria
//     if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
//       var reader = new FileReader();

//       reader.addEventListener("load", function () {
//         var image = new Image();
//         image.title = file.name;
//         image.src = this.result;
//         preview.appendChild( image );
//       }, false);

//       reader.readAsDataURL(file);
//     }

//   }

//   if (files) {
//     [].forEach.call(files, readAndPreview);
//   }
// }