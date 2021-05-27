<?php include(ROOT_DIR.'/views/layouts/header.php') ?>

<div class="container">
	<h1>Dashboard</h1>
		<?php if (!empty($dashboardMetrics)): ?>
			<div class="dashboard-metrics">
				<table border="1">
					<th>Event Name</th><th>Count</th>
				<?php foreach ($dashboardMetrics as $eventName => $count): ?>
					<tr><td><?php echo $eventName; ?></td><td><?php echo $count; ?></td></tr>
				<?php endforeach; ?>
				</table>
			</div>
		<?php endif; ?>
	<?php endif; ?>

</div><!-- .container -->

<?php include(ROOT_DIR.'/views/layouts/footer.php') ?>
