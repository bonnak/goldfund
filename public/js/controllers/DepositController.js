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
        vm.deposited = null;

        vm.getHistory = function(params){
            Restful.get('api/deposit/history').success(function(data){
                vm.deposits = data;

                // if(vm.deposits.length === 0){
                //     vm.deposited = 0;
                // }else if(vm.deposits.length >0){
                //     var deposit = vm.deposits.find(function(element){ return element.status == 0; });

                //     if(deposit == null || deposit.status != 0){
                //         vm.deposited = 0;
                //     }else if(deposit.status == 0 && deposit.paid == 1){
                //         vm.deposited = 1;
                //     }else if(deposit.status == 0 && deposit.paid == 0){
                //         vm.deposited = 2;
                //     }
                // }
            });
        };

        vm.currentDeposit = function(){
            Restful.get('api/deposit/current').success(function(data){
                vm.deposited = data.status;
                vm.paymentbox = $sce.trustAsHtml(data.paymentbox);
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

        vm.save = function(){ 
            vm.loading = true;

            Restful.save('api/deposit', vm.model).then(function(response){
                //vm.languages_list = $sce.trustAsHtml(response.data.languages_list);
                vm.paymentbox = $sce.trustAsHtml(response.data.paymentbox);
                vm.deposited = 2;
            }, function(err_response){
                vm.error = err_response.data.error;
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

        vm.currentDeposit();
        //vm.getQrCode();
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