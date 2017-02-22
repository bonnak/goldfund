function zoomIn()
{
	// if (paper.view.zoom < 2)
	// {
	// 	paper.view.zoom = paper.view.zoom * 2;
	// }

	paper.view.scale(1.1);
}

function zoomOut()
{
	// if (paper.view.zoom > 0.1)
	// {
	// 	paper.view.zoom = paper.view.zoom / 2;
	// }

	paper.view.scale(0.9);
}

function onMouseScroll(event)
{
	if (event.delta > 0)
		zoomIn();
	else
		zoomOut();
}

function setupMouseWheel()
{
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
			if (typeof onMouseScroll != 'undefined')
				onMouseScroll({delta:delta});
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
}

$(function()
{
	setupMouseWheel();
	$('#zoom_in').on('click', function()
		{
			zoomIn();
		});
	$('#zoom_out').on('click', function()
		{
			zoomOut();
		});
});