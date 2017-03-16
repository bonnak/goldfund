angular.module('MetronicApp')
.controller('GeneologyController', [
    '$scope',
    '$location',
    'Restful',
    function($scope, $location, Restful) {
        var vm = this;
        vm.drawing = 'Drawing';

        // Restful.get('/binary/json').success(function(data){
        //     console.log(data);
        // }); 
    }
])
.directive('draw', ['Restful', function (Restful) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
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
                    window.addEventListener('DOMMouseScroll', function(){ paper.view.scale(0.9);}, false);
            /** IE/Opera. */
            window.onmousewheel = document.onmousewheel = internalHandler;

            Restful.get('api/binary/json').success(function(response){
                var data = response;

                var group = new paper.Group();
                var x_position_org = 500;
                var y_position_org = 0;
                var x_position = x_position_org;
                var y_position = y_position_org;
                var width = 100;
                var height = 100;

                var parent_node = new paper.Raster('bn/img/p1.png');
                parent_node.position = new paper.Point(x_position + width/2, y_position + height/2);
                parent_node.on('load', function() {
                    this.size = new paper.Size(width, height);    
                });
                group.addChild(parent_node);

                var caption = new paper.PointText(new paper.Point(x_position + width/2, y_position + height + 20));
                caption.justification = 'center';
                caption.fillColor = '#0f72bb';
                caption.shadowColor = new paper.Color(0, 0, 0);
                caption.shadowBlur = 10;
                caption.shadowOffset = new paper.Point(0, 0);
                caption.content = data.username;
                group.addChild(caption);    

                while(data.left !== null){  
                    var path_l = new paper.Path();
                    path_l.strokeColor = '#000';
                    path_l.add(new paper.Point(x_position + width/2, y_position + height));   
                    path_l.add(new paper.Point((x_position + width/2) - 200, (y_position + height/2) + 200));             
                    group.addChild(path_l);

                    data = data.left;

                    x_position = (x_position) - 200;
                    y_position = (y_position + height/2) + 200;


                    var node = new paper.Raster('bn/img/p1.png');
                    node.position = new paper.Point(x_position + width/2, y_position + height/2);
                    node.on('load', function() {
                        this.size = new paper.Size(width, height);    
                    });
                    group.addChild(node);

                    var caption = new paper.PointText(new paper.Point(x_position + width/2, y_position + height + 20));
                    caption.justification = 'center';
                    caption.fillColor = '#0f72bb';
                    caption.shadowColor = new paper.Color(0, 0, 0);
                    caption.shadowBlur = 10;
                    caption.shadowOffset = new paper.Point(0, 0);
                    caption.content = data.username;
                    group.addChild(caption);            
                }

                var path_l = new paper.Path();
                path_l.strokeColor = '#000';
                path_l.add(new paper.Point(x_position + width/2, y_position + height));   
                path_l.add(new paper.Point((x_position + width/2) - 200, (y_position + height/2) + 200));             
                group.addChild(path_l);

                x_position = (x_position) - 200;
                y_position = (y_position + height/2) + 200;

                var add_new_node_l = new paper.Raster('bn/img/add.png');
                add_new_node_l.position = new paper.Point(x_position + width/2, y_position + height/2);
                add_new_node_l.on('load', function() {
                    this.size = new paper.Size(width, height);
                    this.onClick = function(e){
                        alert('Add a new child');
                    }   
                });
                group.addChild(add_new_node_l);



                data = response;
                x_position = x_position_org;
                y_position = y_position_org;

                while(data.right !== null){  
                    var path_r = new paper.Path();
                    path_r.strokeColor = '#000';
                    path_r.add(new paper.Point(x_position + width/2, y_position + height));   
                    path_r.add(new paper.Point((x_position + width/2) + 200, (y_position + height/2) + 200));             
                    group.addChild(path_r);

                    data = data.right;

                    x_position = (x_position) + 200;
                    y_position = (y_position + height/2) + 200;


                    var node = new paper.Raster('bn/img/p1.png');
                    node.position = new paper.Point(x_position + width/2, y_position + height/2);
                    node.on('load', function() {
                        this.size = new paper.Size(width, height);    
                    });
                    group.addChild(node);

                    var caption = new paper.PointText(new paper.Point(x_position + width/2, y_position + height + 20));
                    caption.justification = 'center';
                    caption.fillColor = '#0f72bb';
                    caption.shadowColor = new paper.Color(0, 0, 0);
                    caption.shadowBlur = 10;
                    caption.shadowOffset = new paper.Point(0, 0);
                    caption.content = data.username;
                    group.addChild(caption);            
                }

                var path_l = new paper.Path();
                path_l.strokeColor = '#000';
                path_l.add(new paper.Point(x_position + width/2, y_position + height));   
                path_l.add(new paper.Point((x_position + width/2) + 200, (y_position + height/2) + 200));             
                group.addChild(path_l);

                x_position = (x_position) + 200;
                y_position = (y_position + height/2) + 200;

                var add_new_node_r = new paper.Raster('bn/img/add.png');
                add_new_node_r.position = new paper.Point(x_position + width/2, y_position + height/2);
                add_new_node_r.on('load', function() {
                    this.size = new paper.Size(width, height);
                    this.onClick = function(e){
                        alert('Add a new child');
                    }   
                });
                group.addChild(add_new_node_r);


                paper.view.onMouseDrag = function(event){
                    group.position.x += event.delta.x;
                    group.position.y += event.delta.y;                    
                }
            });
        }
    };
}]);