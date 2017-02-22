var group = new Group();
var parent_node = new Raster('bn/img/p.png');
parent_node.position = new Point(500, 50);
parent_node.on('load', function() {
	this.size = new Size(100, 100);

	var path = new Path();
	path.strokeColor = '#000';
	path.add(new Point(500, 100)); 	
	path.add(new Point(500, 150)); 

	var path_l = new Path();
	path_l.strokeColor = '#000';
	path_l.add(new Point(500, 150)); 
	path_l.add(new Point(250, 150)); 
	path_l.add(new Point(250, 200));

	var child_l = new Raster('bn/img/p.png');
	child_l.position = new Point(250, 250);
	child_l.on('load', function() {
		child_l.size = new Size(100, 100);
	});

	var path_r = new Path();
	path_r.strokeColor = '#000';
	path_r.add(new Point(500, 150)); 
	path_r.add(new Point(750, 150)); 
	path_r.add(new Point(750, 200));

	var child_r = new Raster('bn/img/add.png');
	child_r.position = new Point(750, 250);
	child_r.on('load', function() {
		this.size = new Size(100, 100);

		this.onClick = function(e){
			alert('Add a new child');
		}
	});

	group.addChild(child_l);
	group.addChild(child_r);
	group.addChild(path);
	group.addChild(path_l);
	group.addChild(path_r);
});


group.addChild(parent_node);

function onMouseDrag(event)
{
	//wasDragging = true;
	// parent_node.position += event.delta;
	// child_l.position += event.delta;
	// child_r.position += event.delta;

	group.position += event.delta;
}


