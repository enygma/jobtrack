<h1><?php echo $position->title; ?></h1>
<hr />
<table class="position-desc">
	<tr>
		<td class="position-label">Location</td>
		<td><?php echo $position->location; ?></td>
	</tr>
	<tr>
		<td class="position-label">Added</td>
		<td><?php echo date('F m, Y',$position->created_at); ?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td class="position-label" valign="top">Summary</td>
		<td><?php echo nl2br($position->summary); ?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td class="position-label" valign="top">Contact</td>
		<td>
			<?php echo $position->contact_name.'<br/>'
			.'<a href="mailto:'.$position->contact_email.'?subject='.$position->title.'">'
			.$position->contact_email.'</a><br/>'
			.$position->contact_phone.'<br/>';
			?>
		</td>
	</tr>
	<tr>
		<td class="position-label">Tagged with</td>
		<td>
			<?php 
			$tags = array();
			foreach($position->tags as $tag) {
				$tags[] = '<a href="/positions/tag/'.$tag->tag.'">'.$tag->tag.'</a>';
			}
			echo implode(',',$tags);
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<br/><br/>
			<?php echo Form::button(array(
				'class'=>'btn','type'=>'button','value'=>'Edit',
				'id'=>'edit-btn','name'=>$position->id)); ?>
		</td>
	</tr>
</table>