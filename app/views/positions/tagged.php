<h2>
	Positions tagged with
	<?php 
		$tagList = array();
		foreach($tagged as $tag) { $tagList[]=$tag; } 
		echo '"'.implode('" or "',$tagList).'"';

		echo Form::hidden('tagList',implode('+',$tagList));
	?>
</h2>

<div class="row">
	<div class="span12">
		<table id="positionList" class="table table-zebra">
		<tr>
			<th>Title</th>
			<th>Location</th>
			<th>Created</th>
			<th>Matching Tag(s)</th>
		</tr>
		<tbody id="taggedWith"></tbody>
		</table>
	</div>
</div>