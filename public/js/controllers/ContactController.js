angular.module('MetronicApp').controller('ContactController', [
    '$scope',
    '$anchorScroll',
    '$state',
    'Restful',
    function($scope, $anchorScroll, $state, Restful) {
        var vm = this;
        vm.model = {
            name: '',
            email: '',
            subject: '',
            message: ''
        };
        vm.uploadme = {};        
        vm.errors = [];
        vm.msg_success = '';


        vm.onFormSubmit = function(){
            // var formData = new FormData();
            // formData.append('name', vm.model.name);
            // formData.append('email', vm.model.email);
            // formData.append('subject', vm.model.subject);
            // formData.append('message', vm.model.message);
            // //formData.append('attachment', $('#attachment')[0].files[0]);

            // const config = {
            //     headers: { 
            //         'content-type': 'multipart/form-data'
            //     }
            // };
            
            // axios.post('api/customer/message', formData, config)
            // .then(function(response) {
            //     console.log(response);
            // })
            // .catch(function(error) {
            //     vm.errors = Object.assign({}, error.response.data.errors);
            // });
            
            Restful.save('api/customer/message', vm.model)
            .success(function(response){ 
                vm.msg_success = response;
                vm.errors = [];            
            }).error(function(err_response){
                vm.errors = err_response.errors;
            });
        }

    }
]).directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);