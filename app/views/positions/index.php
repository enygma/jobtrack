<div class="row">
	<div class="span8">
		<div id="position-form">
			<?php echo Form::open(array('action'=>'/positions/index')); ?>

			<h3>Position Detail</h3>
			<label for="title">Title:</label>
			<?php echo Form::input('title',
				((isset($position->title)) ? $position->title : ''),array('class'=>'input-xlarge')); ?>

			<label for="location">Location</label>
			<?php echo Form::input('location',
				((isset($position->location)) ? $position->location : ''),array('class'=>'input-xlarge')); ?>

			<label for="summary">Summary</label>
			<?php echo Form::textarea('summary',
				((isset($position->summary)) ? $position->summary : ''),array('cols'=>40,'rows'=>10,
					'class'=>'input-xlarge','style'=>'width:700px')); ?>

			<h3>Contact Information</h3>
			<label for="contact_name">Contact Name</label>
			<?php echo Form::input('contact_name',
				((isset($position->contact_name)) ? $position->contact_name : '')); ?>

			<label for="contact_email">Contact Email</label>
			<?php echo Form::input('contact_email',
				((isset($position->contact_email)) ? $position->contact_email : '')); ?>

			<label for="contact_phone">Contact Phone</label>
			<?php echo Form::input('contact_phone',
				((isset($position->contact_phone)) ? $position->contact_phone : '')); ?>

			<label for="tagged-with">Tagged wth</label>
			<?php 
				$tagList = array();
				if (isset($position->tags)) {
					foreach($position->tags as $tag) {
						$tagList[] = $tag->tag;
					}
				}
				echo Form::input('tagged_with',implode(',',$tagList)); ?>
				<br/><br/>

			<?php echo Form::hidden('position_id',
				(isset($position->id)) ? $position->id : ''); ?>

			<?php echo Form::button('Submit','submit',array('class'=>'btn','id'=>'submit-position')); ?>

			<?php echo Form::close(); ?>
		</div>
	</div>
</div>