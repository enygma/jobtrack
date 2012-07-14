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
			$tagList = array();
			$tagLinks = array();
			foreach($position->tags as $tag){ if(!empty($tag->tag)){ $tagList[] = $tag->tag; }}

			foreach($tagList as $tag) {
				$tagLinks[] = '<a href="/positions/tagged/'.$tag.'">'.$tag.'</a>';
			}
			echo implode(', ',$tagLinks);
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<br/><br/>
			<?php echo Form::button(array(
				'class'=>'btn','type'=>'button','value'=>'Edit',
				'id'=>'edit-btn','name'=>$position->id)); ?>

			<?php echo Form::button(array(
				'class'=>'btn','type'=>'button','value'=>'Delete',
				'id'=>'delete-btn','name'=>$position->id)); ?>
		</td>
	</tr>
	<tr><td>&nbsp<br/></td></tr>
	<tr>
		<td class="position-label">Related Applicants (By Tags)</td>
	</tr>
	<tr>
		<td>
			<?php echo Form::hidden('positionTags',implode('+',$tagList)); ?>
			<div id="relatedApplicants"></div>
		</td>
	</tr>
</table>