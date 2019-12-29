<?php

$itemsId = Array(':content_id=>', ':product_id=>', ':title=>', ':date=>', ':volume=>');
$itemsReview = Array(':count=>', ':average=>');
$itemsURL = Array(':URL=>', ':large=>');
$itemsDelivery = Array(':type=>', ':price=>');
$itemsActress = Array(':id=>', ':name=>');
$itemsDirector = Array(':id=>', ':name=>');
$itemsLabel = Array(':id=>', ':name=>');
$itemsType = Array(':service_code', ':service_name=>', ':floor_code=>', ':floor_name=>', ':category_name=>');
$itemsGenre = Array(':id=>', ':name=>');

$file = new SplFileObject('readdata.csv'); 
$file->setFlags(SplFileObject::READ_CSV); 
foreach ($file as $line) {
  //終端の空行を除く処理　空行の場合に取れる値は後述
  if(is_null($line[0]){
    $records[] = $line;
  }
} 



// for($i=0, $i<10, )
// foreach ($itemsId as $item){
       
// }