<?php
require_once 'Opinion.php';

// load tweets. 



$op = new Opinion();

//the loaded datasets are the lighter ones, 
//preprocessed the same way te adquired tweets will be.
$op->addToIndex('import/data/neu1.txt', 'neutral');
$op->addToIndex('import/data/neg1.txt', 'negative');
$op->addToIndex('import/data/pos1.txt', 'positive');

?>
