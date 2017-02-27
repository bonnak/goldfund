axios.get('/binary/json').then(function(response){
    var data = response.data;

    var group = new Group();
	var x_position_org = 500;
	var y_position_org = 0;
	var x_position = x_position_org;
	var y_position = y_position_org;
	var width = 100;
	var height = 100;

	var parent_node = new Raster('bn/img/p1.png');
	parent_node.position = new Point(x_position + width/2, y_position + height/2);
	parent_node.on('load', function() {
		this.size = new Size(width, height);	
	});
	group.addChild(parent_node);

	var caption = new PointText(new Point(x_position + width/2, y_position + height + 20));
	caption.justification = 'center';
	caption.fillColor = '#0f72bb';
	caption.shadowColor = new Color(0, 0, 0);
    caption.shadowBlur = 10;
    caption.shadowOffset = new Point(0, 0);
	caption.content = data.username;
	group.addChild(caption);	

    while(data.left !== null){  
    	var path_l = new Path();
		path_l.strokeColor = '#000';
		path_l.add(new Point(x_position + width/2, y_position + height)); 	
		path_l.add(new Point((x_position + width/2) - 200, (y_position + height/2) + 200)); 			
		group.addChild(path_l);

    	data = data.left;

		x_position = (x_position) - 200;
		y_position = (y_position + height/2) + 200;


		var node = new Raster('bn/img/p1.png');
		node.position = new Point(x_position + width/2, y_position + height/2);
    	node.on('load', function() {
			this.size = new Size(width, height);	
		});
		group.addChild(node);

		var caption = new PointText(new Point(x_position + width/2, y_position + height + 20));
		caption.justification = 'center';
		caption.fillColor = '#0f72bb';
		caption.shadowColor = new Color(0, 0, 0);
	    caption.shadowBlur = 10;
	    caption.shadowOffset = new Point(0, 0);
		caption.content = data.username;
		group.addChild(caption);   		    
    }

    var path_l = new Path();
	path_l.strokeColor = '#000';
	path_l.add(new Point(x_position + width/2, y_position + height)); 	
	path_l.add(new Point((x_position + width/2) - 200, (y_position + height/2) + 200)); 			
	group.addChild(path_l);

    x_position = (x_position) - 200;
	y_position = (y_position + height/2) + 200;

	var add_new_node_l = new Raster('bn/img/add.png');
	add_new_node_l.position = new Point(x_position + width/2, y_position + height/2);
	add_new_node_l.on('load', function() {
		this.size = new Size(width, height);
		this.onClick = function(e){
			alert('Add a new child');
		}	
	});
	group.addChild(add_new_node_l);



	data = response.data;
	x_position = x_position_org;
	y_position = y_position_org;

	while(data.right !== null){  
    	var path_r = new Path();
		path_r.strokeColor = '#000';
		path_r.add(new Point(x_position + width/2, y_position + height)); 	
		path_r.add(new Point((x_position + width/2) + 200, (y_position + height/2) + 200)); 			
		group.addChild(path_r);

    	data = data.right;

		x_position = (x_position) + 200;
		y_position = (y_position + height/2) + 200;


		var node = new Raster('bn/img/p1.png');
		node.position = new Point(x_position + width/2, y_position + height/2);
    	node.on('load', function() {
			this.size = new Size(width, height);	
		});
		group.addChild(node);

		var caption = new PointText(new Point(x_position + width/2, y_position + height + 20));
		caption.justification = 'center';
		caption.fillColor = '#0f72bb';
		caption.shadowColor = new Color(0, 0, 0);
	    caption.shadowBlur = 10;
	    caption.shadowOffset = new Point(0, 0);
		caption.content = data.username;
		group.addChild(caption);   		    
    }

    var path_l = new Path();
	path_l.strokeColor = '#000';
	path_l.add(new Point(x_position + width/2, y_position + height)); 	
	path_l.add(new Point((x_position + width/2) + 200, (y_position + height/2) + 200)); 			
	group.addChild(path_l);

    x_position = (x_position) + 200;
	y_position = (y_position + height/2) + 200;

	var add_new_node_r = new Raster('bn/img/add.png');
	add_new_node_r.position = new Point(x_position + width/2, y_position + height/2);
	add_new_node_r.on('load', function() {
		this.size = new Size(width, height);
		this.onClick = function(e){
			alert('Add a new child');
		}	
	});
	group.addChild(add_new_node_r);


	view.onMouseDrag = function(event){
		group.position += event.delta;
	}
});

// var group = new Group();
// var x_position = 0;
// var y_position = 0;
// var width = 100;
// var height = 100;
// var parent_node = new Raster('bn/img/p.png');
// parent_node.position = new Point(x_position + width/2, y_position + height/2);
// parent_node.on('load', function() {
// 	this.size = new Size(width, height);

// 	var path_l = new Path();

// 	path_l.strokeColor = '#000';
// 	path_l.add(new Point(x_position + width/2, y_position + height)); 	
// 	path_l.add(new Point((x_position + width/2) - 200, (y_position + height/2) + 200)); 

// 	var child_l = new Raster('bn/img/p.png');
// 	child_l.position = new Point((x_position + width/2) - 200, (y_position + height) + 200);
// 	child_l.on('load', function() {
// 		child_l.size = new Size(width, height);
// 	});


// 	x_position = (x_position) - 200;
// 	y_position = (y_position + height/2) + 200;
// 	width = 100;
// 	height = 100;

// 	var path_l2 = new Path();

// 	path_l2.strokeColor = '#000';
// 	path_l2.add(new Point(x_position + width/2, y_position + height)); 	
// 	path_l2.add(new Point((x_position + width/2) - 200, (y_position + height/2) + 200)); 

// 	var child_l2 = new Raster('bn/img/p.png');
// 	child_l2.position = new Point((x_position + width/2) - 200, (y_position + height) + 200);
// 	child_l2.on('load', function() {
// 		child_l2.size = new Size(width, height);
// 	});




// 	// var path_r = new Path();
// 	// path_r.strokeColor = '#000';
// 	// path_r.add(new Point(x_position, 100));  	
// 	// path_r.add(new Point(750, 200)); 

// 	// var child_r = new Raster('bn/img/add.png');
// 	// child_r.position = new Point(750, 250);
// 	// child_r.on('load', function() {
// 	// 	this.size = new Size(100, 100);

// 	// 	this.onClick = function(e){
// 	// 		alert('Add a new child');
// 	// 	}
// 	// });

// 	group.addChild(child_l);	
// 	group.addChild(path_l);
// 	group.addChild(child_l2);	
// 	group.addChild(path_l2);
// 	//group.addChild(child_r);
// 	//group.addChild(path_r);
// });


//group.addChild(parent_node);

// function onMouseDrag(event)
// {
// 	group.position += event.delta;
// }


