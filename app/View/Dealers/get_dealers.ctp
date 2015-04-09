<?php if(is_array($dealers)):?>
    <ul><?php foreach($dealers as $dealer): ?><li><?php echo $dealer['Dealer']['dealer_number'].' :: '.$dealer['Dealer']['name']; ?></li><?php endforeach; ?></ul>
<?php endif;?>