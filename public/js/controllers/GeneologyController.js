angular.module('MetronicApp')
.controller('GeneologyController', [
    '$rootScope',
    '$scope',
    '$location',
    'Restful',
    function($rootScope, $scope, $location, Restful) {
        var vm = this;
        vm.countries = [];
        vm.model = {
            username                : '',
            email                   : '',
            password                : '',
            first_name              : '',
            last_name               : '',
            country_id              : '',
            gender                  : '',
            bitcoin_account         : '',
            date_of_birth           : '',
            agree_term_condition    : '',
            sponsor_name            : $rootScope.user.username,
            sponsor_id              : $rootScope.user.id,
            direction               : ''
        };

        Restful.get('/getCountry').success(function(data){
            vm.countries = data;
        }); 

        vm.submitRegister = function(){
            vm.loading = true;

            Restful.save('/register', vm.model).success(function(response){
                $('#register_modal').modal('hide');
                vm.resetModel();
                vm.loadTree();                
            }).finally(function () {
                vm.loading= false;
            });
        }

        vm.loadTree = function(){
            Restful.get('api/binary/json').success(function(data){
                vm.binary_tree = data;
            });
        }

        vm.resetModel = function(){
            vm.model.username = '';
            vm.model.email = '';
            vm.model.password = '';
            vm.model.first_name = '';
            vm.model.last_name = '';
            vm.model.country_id = '';
            vm.model.gender = '';
            vm.model.bitcoin_account = '';
            vm.model.date_of_birth = '';
            vm.model.agree_term_condition = '';
        }

        vm.loadTree();
    }
])
.directive('draw', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            scope.$watch('vm.binary_tree',function(treeValue) {
                if(treeValue === undefined) return;

                var path;
                paper.setup(element.get(0));
                // var tool = new paper.Tool();
                // tool.onMouseDown = function (event) {
                //     path = new paper.Path();
                //     path.strokeColor = 'black';
                // };
                // tool.onMouseDrag = function (event) {
                //     path.add(event.point);
                // };
                // tool.onMouseUp = function (event) {
                //     //nothing special here
                // };

                var internalHandler = function(event)
                {
                    // From http://www.adomas.org/javascript-mouse-wheel/
                    var delta = 0;
                    if (!event) /* For IE. */
                        event = window.event;
                    if (event.wheelDelta) { /* IE/Opera. */
                        delta = event.wheelDelta/120;
                    } else if (event.detail) { /** Mozilla case. */
                        /** In Mozilla, sign of delta is different than in IE.
                        * Also, delta is multiple of 3.
                        */
                        delta = -event.detail/3;
                    }
                    /** If delta is nonzero, handle it.
                    * Basically, delta is now positive if wheel was scrolled up,
                    * and negative, if wheel was scrolled down.
                    */
                    if (delta > 0)
                        paper.view.scale(1.1);
                    else
                        paper.view.scale(0.9);
                    /** Prevent default actions caused by mouse wheel.
                    * That might be ugly, but we handle scrolls somehow
                    * anyway, so don't bother here..
                    */
                    if (event.preventDefault)
                        event.preventDefault();

                    event.returnValue = false;
                }

                /** DOMMouseScroll is for mozilla. */
                if (window.addEventListener)
                        window.addEventListener('DOMMouseScroll', internalHandler, false);
                /** IE/Opera. */
                window.onmousewheel = document.onmousewheel = internalHandler;

                
                var data = treeValue;

                var group = new paper.Group();
                var x_position_org = 500;
                var y_position_org = 0;
                var x_position = x_position_org;
                var y_position = y_position_org;
                var x_gap = 300;
                var y_gap = 300;
                var width = 100;
                var height = 100;

                var parent_node = new paper.Raster('bn/img/p' + data.deposit_plan + '.png');
                parent_node.position = new paper.Point(x_position + width/2, y_position + height/2);
                parent_node.on('load', function() {
                    this.size = new paper.Size(width, height);    
                });
                group.addChild(parent_node);

                var caption = new paper.PointText(new paper.Point(x_position + width/2, y_position + height + 20));
                caption.justification = 'center';
                caption.fillColor = '#ff0000';
                caption.fontSize = '20px';
                caption.content = data.username;
                group.addChild(caption);    

                while(data.left !== null){  
                    var path_l = new paper.Path();
                    path_l.strokeColor = '#000';
                    path_l.add(new paper.Point(x_position + width/2, y_position + height));   
                    path_l.add(new paper.Point((x_position + width/2) - x_gap, (y_position + height/2) + y_gap));             
                    group.addChild(path_l);

                    data = data.left;

                    x_position = (x_position) - x_gap;
                    y_position = (y_position + height/2) + y_gap;


                    var node = new paper.Raster('bn/img/p' + data.deposit_plan + '.png');
                    node.position = new paper.Point(x_position + width/2, y_position + height/2);
                    node.on('load', function() {
                        this.size = new paper.Size(width, height);    
                    });
                    group.addChild(node);

                    var caption = new paper.PointText(new paper.Point(x_position + width/2, y_position + height + 20));
                    caption.justification = 'center';
                    caption.fillColor = '#ff0000';
                    caption.fontSize = '20px';
                    caption.content = data.username;
                    group.addChild(caption);    

                    //Unknown Right
                    var path_r = new paper.Path();
                    path_r.strokeColor = '#000';
                    path_r.add(new paper.Point(x_position + width/2, y_position + height));   
                    path_r.add(new paper.Point((x_position + width/2) + x_gap - 50, (y_position + height/2) + y_gap));             
                    group.addChild(path_r);

                    var x_position_unknown = (x_position) + x_gap - 50;
                    var y_position_unknown = (y_position + height/2) + y_gap;


                    var node = new paper.Raster('bn/img/p.png');
                    node.position = new paper.Point(x_position_unknown + width/2, y_position_unknown + height/2);
                    node.on('load', function() {
                        this.size = new paper.Size(width, height);    
                    });
                    group.addChild(node);         
                }

                var path_l = new paper.Path();
                path_l.strokeColor = '#000';
                path_l.add(new paper.Point(x_position + width/2, y_position + height));   
                path_l.add(new paper.Point((x_position + width/2) - x_gap, (y_position + height/2) + y_gap));             
                group.addChild(path_l);

                x_position = (x_position) - x_gap;
                y_position = (y_position + height/2) + y_gap;

                var add_new_node_l = new paper.Raster('bn/img/add.png');
                add_new_node_l.position = new paper.Point(x_position + width/2, y_position + height/2 - 20);
                add_new_node_l.on('load', function() {
                    this.size = new paper.Size(60, 60);
                    this.onClick = function(e){
                        scope.$apply(function () {
                            scope.vm.model.direction = 'L';
                        });

                        $('#register_modal').on('hidden.bs.modal', function () {
                            scope.$apply(function () {
                                scope.vm.resetModel();
                            });
                        });

                        $('#register_modal').modal();
                    }   
                });
                group.addChild(add_new_node_l);



                data = treeValue;
                x_position = x_position_org;
                y_position = y_position_org;

                while(data.right !== null){  
                    var path_r = new paper.Path();
                    path_r.strokeColor = '#000';
                    path_r.add(new paper.Point(x_position + width/2, y_position + height));   
                    path_r.add(new paper.Point((x_position + width/2) + x_gap, (y_position + height/2) + y_gap));             
                    group.addChild(path_r);

                    data = data.right;

                    x_position = (x_position) + x_gap;
                    y_position = (y_position + height/2) + y_gap;


                    var node = new paper.Raster('bn/img/p' + data.deposit_plan + '.png');
                    node.position = new paper.Point(x_position + width/2, y_position + height/2);
                    node.on('load', function() {
                        this.size = new paper.Size(width, height);    
                    });
                    group.addChild(node);

                    var caption = new paper.PointText(new paper.Point(x_position + width/2, y_position + height + 20));
                    caption.justification = 'center';
                    caption.fillColor = '#ff0000';
                    caption.fontSize = '20px';
                    caption.content = data.username;
                    group.addChild(caption);   


                    //Unknown Left
                    var path_l = new paper.Path();
                    path_l.strokeColor = '#000';
                    path_l.add(new paper.Point(x_position + width/2, y_position + height));   
                    path_l.add(new paper.Point((x_position + width/2) - x_gap + 50, (y_position + height/2) + y_gap));             
                    group.addChild(path_l);

                    var x_position_unknown = (x_position) - x_gap + 50;
                    var y_position_unknown = (y_position + height/2) + y_gap;


                    var node = new paper.Raster('bn/img/p.png');
                    node.position = new paper.Point(x_position_unknown + width/2, y_position_unknown + height/2);
                    node.on('load', function() {
                        this.size = new paper.Size(width, height);    
                    });
                    group.addChild(node);         
                }

                var path_l = new paper.Path();
                path_l.strokeColor = '#000';
                path_l.add(new paper.Point(x_position + width/2, y_position + height));   
                path_l.add(new paper.Point((x_position + width/2) + x_gap, (y_position + height/2) + y_gap));             
                group.addChild(path_l);

                x_position = (x_position) + x_gap;
                y_position = (y_position + height/2) + y_gap;

                var add_new_node_r = new paper.Raster('bn/img/add.png');
                add_new_node_r.position = new paper.Point(x_position + width/2, y_position + height/2 -20);
                add_new_node_r.on('load', function() {
                    this.size = new paper.Size(60, 60);
                    this.onClick = function(e){
                        scope.$apply(function () {
                            scope.vm.model.direction = 'R';
                        });

                        $('#register_modal').on('hidden.bs.modal', function () {
                            scope.$apply(function () {
                                scope.vm.resetModel();
                            });
                        });

                        $('#register_modal').modal();                        
                    }   
                });
                group.addChild(add_new_node_r);

                paper.view.scale(0.4);


                paper.view.onMouseDrag = function(event){
                    group.position.x += event.delta.x;
                    group.position.y += event.delta.y;                    
                }
            });            
        }
    };
});