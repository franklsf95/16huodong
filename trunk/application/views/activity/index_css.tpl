<style type="text/css">
#waterfall {
	list-style-type: none;
	position: relative;
	margin: 0;
}

#waterfall li {
	width: 260px;
	box-shadow: 0 1px 3px rgba(34, 25, 25, .4);
	-moz-box-shadow: 0 1px 3px rgba(34,25,25,.4);
	-webkit-box-shadow: 0 1px 3px rgba(34, 25, 25, .4);
	filter: progid:DXImageTransform.Microsoft.Shadow(color = #adacac,direction = 135,strength = 2);
	/*display: none; /** Hide items initially to avoid a flicker effect **/
	  cursor: pointer;
	padding: 10px;
}

.wm-item img {
  width: 260px;
}

#waterfall ali:nth-child(3n) {
height: 175px;
}

#waterfall ali:nth-child(4n-3) {
padding-bottom: 30px;
}

#waterfall ali:nth-child(5n) {
height: 250px;
}

.toolbox {
	height: 100px;
	margin-bottom: 20px;
}

.accordion-toggle {
	font-size: 18px;
	line-height: 24px;
}
</style>