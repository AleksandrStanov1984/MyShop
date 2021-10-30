<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<td class="text-left"><?php echo $text_goal['label']; ?></td>
				<td class="text-left"><?php echo $text_goal['category']; ?></td>
				<td class="text-left"><?php echo $text_goal['action']; ?></td>
				<td class="text-left"><?php echo $text_goal['element']; ?></td>
				<td class="text-left"><?php echo $text_goal['event']; ?></td>
				<td class="text-left"><?php echo $text_goal['value']; ?></td>
				<td class="text-right"></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($goals as $goal) { ?>
			<tr class="goal_data" data-goal-id="<?php echo $goal['goal_id']; ?>" data-action="<?php echo $goal['action']; ?>" data-label="<?php echo $goal['label']; ?>" data-category="<?php echo $goal['category']; ?>" data-element="<?php echo $goal['element']; ?>" data-event="<?php echo $goal['event']; ?>" data-value="<?php echo $goal['value']; ?>">
				<td class="text-left"><span title="<?php echo $goal['label']; ?>"><?php echo $goal['label']; ?></span></td>
				<td class="text-left"><span title="<?php echo $goal['category']; ?>"><?php echo $goal['category']; ?></span></td>
				<td class="text-left"><span><i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" data-original-title="<?php echo $text_copy_to_clipboard['action']; ?>"></i> <?php echo $goal['action']; ?></span></td>
				<td class="text-left"><span><?php echo $goal['element']; ?></span></td>
				<td class="text-left"><span><?php echo $goal['event']; ?></span></td>
				<td class="text-left"><span><?php echo $goal['value']; ?> <?php echo $currency_default; ?></span></td>
				<td class="text-right">
					<a class="btn btn-primary goal_edit" data-toggle="tooltip" data-original-title="<?php echo $button_edit; ?>"><i class="fa fa-pencil"></i></a>
					<a class="btn btn-danger goal_delete" data-toggle="tooltip" data-original-title="<?php echo $button_remove; ?>"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					<?php if($goals_pages > 1) { ?>
					<nav>
						<ul class="pagination">
							<?php if($goals_page > 1) { ?>
							<li><a href="#" aria-label="Previous" data-page="<?php echo $goals_page - 1; ?>"><span aria-hidden="true">&laquo;</span></a></li>
							<?php } ?>
							<?php for($page=1; $page <= $goals_pages; $page++ ) { ?>
							<li <?php if($page == $goals_page) { ?>class="active"<?php } ?>><a href="#" data-page="<?php echo $page; ?>"><?php echo $page; ?></a></li>
							<?php } ?>
							<?php if($goals_page < $goals_pages) { ?>
							<li><a href="#" aria-label="Next" data-page="<?php echo $goals_page + 1; ?>"><span aria-hidden="true">&raquo;</span></a></li>
							<?php } ?>
						</ul>
					</nav>
					<?php } ?>
					<span class="goals-results"><?php echo $results; ?></span>
				</td>
				<td class="text-right">
					<a class="btn btn-primary goal_add" data-toggle="tooltip" data-original-title="<?php echo $button_add; ?>"><i class="fa fa-plus"></i></a>
				</td>
			</tr>
		</tfoot>
	</table>
</div>