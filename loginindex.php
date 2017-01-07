<p>
	<a href="add.php">Add New Book</a>
</p>
<dl>
	<dt>Read Books</dt><dd><?php out(readbooknum()) ?></dd>
</dl>
<ul>
	<?php foreach (recentbooks(10) as $b) { ?>
	<li>
		<dl>
			<dt>title</dt><dd><?php out($b['title']); ?></dd>
			<dt>author</dt><dd><?php out($b['author']); ?></dd>
			<dt>price</dt><dd><?php out($b['price']); ?></dd>
		</dl>

	</li>
	<?php } ?>
</ul>

