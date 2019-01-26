<h2>List of items</h2>
<br/>
<?php echo "<strong>List by: </strong>" .html_escape($firstName)?>
<br/>
<?php echo "<strong>List Name </strong>" .html_escape($wishList->listName)?>
<br/>
<?php echo "<strong>List Description </strong>" .html_escape($wishList->description)?>
<br/><br/>
<?php
$this->table->set_heading('Title',
    'URL',
    'Price',
    'Priority');

echo $this->table->generate($items);