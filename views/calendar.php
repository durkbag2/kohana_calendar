<?php defined('SYSPATH') OR die('No direct access allowed.');

$today = ($month == date('n')) ? date('j') : false;

$month = Arr::get($_GET, 'month', date('n', Arr::get($_GET, 'ts', date('n'))));
$year= Arr::get($_GET, 'year', date('Y', Arr::get($_GET, 'ts', date('Y'))));

?>

<div class="table month">
	<?php foreach ($weeks as $week): ?>
	<div class="row">
		<?php foreach ($week as $day):
			list($number, $current, $data, $events) = $day;
			$output = NULL;
			$classes = array();
			$day_start = mktime(0, 0, 0, $month, $number, $year);

			if (is_array($data)) {
				$classes = $data['classes'];
				if ( ! empty($data['output'])) {
					$output = '<ul class="output"><li>'.implode('</li><li>', $data['output']).'</li></ul>';
				}
			}
		?>
		<div class="droppable-m col-m<?php echo $current ? ($number == $today ? ' current' : '') : ' alt'?>" data-timestamp="<?php echo $day_start ?>">
			<?php if (count($events) > 0): ?>
				<div class="users">
				<?php foreach ($events as $event):
					$start_period = date('a', $event['timestamp']);
					$end_period = date('a', $event['end_timestamp']);
				?>
					<a>
						<img src="<?php echo Photo::as_path($event['user']['id'], 'photo-mini', Photo::AVATAR) ?>" alt="client" />
						<div class="tooltip" style="display: none;" data-event-id="<?php echo $event['id'] ?>" data-user-id="<?php echo $event['user']['id'] ?>" data-timestamp="<?php echo $event['timestamp'] ?>" data-end-timestamp="<?php echo $event['end_timestamp'] ?>" data-date="<?php echo $day_start ?>">
							<p class="header"><?php echo User::name($event['user']) ?></p>
							<p>Start time:</p>
							<input type="textbox" class="start-time" size="5" maxlength="5" value="<?php echo date('g:i', $event['timestamp']) ?>"><input name="start-time-period<?php echo $event['id'] ?>" type="radio" value="am" <?php if ($start_period == 'am') echo 'checked="checked"' ?>>am<input name="start-time-period<?php echo $event['id'] ?>" type="radio" value="pm" <?php if ($start_period == 'pm') echo 'checked="checked"' ?>>pm
							<p>End time:</p>
							<input type="textbox" class="end-time" size="5" maxlength="5" value="<?php echo date('g:i', $event['end_timestamp']) ?>"><input name="end-time-period<?php echo $event['id'] ?>" type="radio" value="am" <?php if ($end_period == 'am') echo 'checked="checked"' ?>>am<input name="end-time-period<?php echo $event['id'] ?>" type="radio" value="pm" <?php if ($end_period == 'pm') echo 'checked="checked"' ?>>pm
							<span class="action update">update</span>
							<span class="action remove">remove</span>
							<span class="arrow"></span>
						</div>
					</a>
				<?php endforeach ?>
					<div class="cl">&nbsp;</div>
				</div>
			<?php endif ?>
			<span class="view">view date</span><span class="day"><?php echo $number ?></span>
		</div>
		<?php endforeach ?>
	</div>
	<?php endforeach ?>
</div>
