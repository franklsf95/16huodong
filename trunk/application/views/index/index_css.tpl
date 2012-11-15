<style type="text/css">

.bx-next {
	position:absolute;
	top:40%;
	right:-50px;
	z-index:999;
	width: 30px;
	height: 30px;
	text-indent: -999999px;
	background: url({$config.asset}/img/gray_next.png) no-repeat 0 -30px;
}

.bx-prev {
	position:absolute;
	top:40%;
	left:-50px;
	z-index:999;
	width: 30px;
	height: 30px;
	text-indent: -999999px;
	background: url({$config.asset}/img/gray_prev.png) no-repeat 0 -30px;
}

.bx-next:hover,
.bx-prev:hover {
	background-position: 0 0;
}

.slider-item {
	float: left;
	max-width: 270px;
	height: 190px;
	margin: 0 30px;
	text-align: center;
}

.slider-item img {
  max-width: 270px;
  height: 150px;
}

.timestamp {
	font-family: 'Monaco, Menlo, Consolas, "Courier New", monospace';
	font-size: 12px;
	color: #DD1144;
	float: right;
}
</style>