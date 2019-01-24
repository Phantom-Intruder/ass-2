<h2>List of items</h2>

<?php
$this->table->set_heading('Title',
    'URL',
    'Price',
    'Priority');

echo $this->table->generate($items);