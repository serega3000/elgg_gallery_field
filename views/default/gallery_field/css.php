/*<style>*/

.gallery-field-images-list .images .image{
	margin: 10px;
}
.gallery-field-images-list.collapsed .images .image{
	display: inline-block;
	vertical-align:top;
	margin-right: 5px;
}
.gallery-field-images-list.collapsed .images .image a{
	display: inline-block;
	width: 200px;
	height: 140px;
}
.gallery-field-images-list.collapsed .images a.deleting img{
	opacity: 0.5;
}
.gallery-field-images-list.collapsed .images a.deleting{
	background: red;
}
.gallery-field-images-list .clear{
	clear: both;
}
.gallery-field-images-list.collapsed .images{
	height: 180px;
	overflow-x: scroll;
	overflow-y: hidden;
	white-space: nowrap;
}

.gallery-field-images-list.collapsed .images .dragger{
	width: auto;
	margin-top: 5px;
}
.gallery-field-images-list .image_full img{
	width: 100%;
	margin-top: 10px;
}
.gallery-field-images-list.collapsed .images a:focus{
	outline: 2px solid #5097CF;
}
.gallery-field-images-list .editor{
	margin-top: 10px;
}