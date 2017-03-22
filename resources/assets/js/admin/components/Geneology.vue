<template>
	<md-card>
		<div class="body">
			<div class="search">
				  <input type="text" 
                        class="form-control" 
                        placeholder="Username" 
                        v-model="search_query" 
                        @keyup="searchData">
				  <span class="input-group-addon"><i class="fa fa-search"></i></span>				
			</div>
            <div class="row graph-geneology">
                <div class="col-md-3 block">
                    <img class="p-note-img" src="/bn/img/p.png"/>
                    <span class="caption">InActive</span>
                </div>
                <div class="col-md-3 block">
                    <img class="p-note-img" src="/bn/img/p1.png"/>
                    <span class="caption">Basic</span>
                </div>
                <div class="col-md-3 block">
                    <img class="p-note-img" src="/bn/img/p2.png"/>
                    <span class="caption">Gold</span>
                </div>
                <div class="col-md-3 block">
                    <img class="p-note-img" src="/bn/img/p3.png"/>
                    <span class="caption">Platinum</span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <canvas v-geneology-graph="data_graph" style="width: 100%"></canvas>
                </div>
            </div>
        </div>
	</md-card>
</template>

<script>
import _ from 'lodash'
import Api from '../api/Api'

export default{
	data(){
		return {
			data_graph: null,
			search_query: ''
		}
	},

	created(){
		this.loadData();
	},

	methods: {
		loadData(query = ''){
			Api.get('geneology/json' + (query != '' ? ('?query=' + query) : ''))
            .then((response) => {
	            this.data_graph = response.data;
	        });
		},

		searchData: _.debounce(function () {
            this.loadData(this.search_query);
        }, 500)
	},

	directives: {
	  geneologyGraph: {
	    bind: (el, binding, vnode) => {
	    	var internalHandler = (event) => {
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
	    },

	    update: (el, binding, vnode) => {
	    	var treeValue = binding.value;
            var data = treeValue;
            var path;

            paper.setup(el);     
            var group = new paper.Group();

            if(treeValue === '') return;

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

            var rect = new paper.Path.Rectangle((x_position + width/2) - 200/2, (y_position + height/2) - 200/ 2, 200, 200); 
            rect.strokeColor = 'black';
            group.addChild(rect); 

            while(data.left !== null){  
                var path_l = new paper.Path();
                path_l.strokeColor = '#000';
                path_l.add(new paper.Point(x_position + width/2, y_position + height + 200/4));   
                path_l.add(new paper.Point((x_position + width/2) - x_gap, (y_position + height/2) + y_gap - 200/4));             
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

                var rect = new paper.Path.Rectangle((x_position + width/2) - 200/2, (y_position + height/2) - 200/ 2, 200, 200); 
                rect.strokeColor = 'black';
                group.addChild(rect);          
            }



            data = treeValue;
            x_position = x_position_org;
            y_position = y_position_org;

            while(data.right !== null){  
                var path_r = new paper.Path();
                path_r.strokeColor = '#000';
                path_r.add(new paper.Point(x_position + width/2, y_position + height + 200/4));   
                path_r.add(new paper.Point((x_position + width/2) + x_gap, (y_position + height/2) + y_gap - 200/4));             
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

                var rect = new paper.Path.Rectangle((x_position + width/2) - 200/2, (y_position + height/2) - 200/ 2, 200, 200); 
                rect.strokeColor = 'black';
                group.addChild(rect);        
            }

            paper.view.scale(0.4);


            paper.view.onMouseDrag = function(event){
                group.position.x += event.delta.x;
                group.position.y += event.delta.y;                    
            }
	    }
	  }
	}
	
}
</script>

<style lang="scss" scoped>
.row{
	margin: 0;
}

.body{
	padding: 10px;

	.graph-geneology{
		position: absolute;
		width: 300px;
		z-index: 1;
		padding: 5px;
		border-radius: 5px;
		margin: 0;


		.block{
			width: 70px;

			.p-note-img{
				width: 100%;
			}

			.caption{
				display: inline-block;
				text-align: center;
				width: 100%;
				font-size: 12px;
			}
		}
	}

	.search{
        position: absolute;
	    display: flex;
        width: 223px;
        align-items: center;
        justify-content: flex-end;
        right: 35px;
        z-index: 1;

        input{
            border-radius: 20px;
        }

        span{
            border: none;
            background: transparent;
            padding: 0 0 0 5px;
            font-size: 22px;
            display: inline-block;
        }
	}
}
</style>