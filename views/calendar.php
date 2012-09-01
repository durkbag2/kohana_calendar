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

			if (is_array($data)) {
				$classes = $data['classes'];
				if ( ! empty($data['output'])) {
					$output = '<ul class="output"><li>'.implode('</li><li>', $data['output']).'</li></ul>';
				}
			}
		?>
		<div class="col-m<?php echo $current ? ($number == $today ? ' current' : '') : ' alt'?>" data-timestamp="<?php echo mktime(0, 0, 0, $month, $number, $year)?>">
			<?php if (count($events) > 0): ?>
				<div class="users">
				<?php foreach ($events as $event): ?>
					<a>
						<img src="<?php echo Photo::as_path($event['user']['id'], 'photo-mini', Photo::AVATAR) ?>" alt="client" />
						<div class="tooltip">
							<p>appointment: <?php echo date('g:ia', $event['timestamp']) ?> - <?php echo date('g:ia', $event['end_timestamp'])?></p>
							<span class="arrow"></span>
						</div>
					</a>
				<?php endforeach ?>
					<div class="cl">&nbsp;</div>
				</div>
			<?php endif ?>
			<span class="day"><?php echo $number ?></span>
		</div>
		<?php endforeach ?>
	</div>
	<?php endforeach ?>
</div>
