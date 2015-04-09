<script>
    jQuery(document).ready(function($){
        var jhtdla = $('<a>')
            .attr('href','#hidden-states')
            .attr('class','show_hide')
            .html('Dealers');

        $('.hidden-states').hide();
        jhtdla.click(function(){
            $(".hidden-states").slideToggle();
        });

        /*if ( $('#menu-item-4002').size() > 0 ) {
            jhtdla.appendTo('#menu-item-4002').siblings().hide();
        } else {*/
            $('<li />').appendTo('#menu-footer-line-1').append(jhtdla).addClass('last').prev().removeClass('last');
        //}
    });
</script>
<div id="hidden-states" class="hidden-states" style="display: none">
    <?php if (strpos($_SERVER['HTTP_HOST'], '.ca') !== false) {?>
        <h2>Canadian Cities</h2>
        <ul class="colLists">
            <?php 
            $i = 1;
            $lastCity = count($popular_ca_cities)-1;
            $pop_ca_cities_length = ceil(count($popular_ca_cities)/4);

            foreach($popular_ca_cities as $key => $s){
                $stateUrl = str_replace(' ', '-', strtolower($s['State']['name'].'-'.$s['State']['abbreviation']));
                if($i == 1){
                    echo '<li><ul class="colList">';
                }
                echo '<li>'; 
                echo $this->Html->link($s['Dealer']['city'], '/'.$stateUrl.'/'.$s['Dealer']['slug'], array('title' => $s['Dealer']['city'].' Hot Tubs'));
                echo '</li>';

                if($i == $pop_ca_cities_length){
                    echo '</ul></li>';
                    $i = 1;
                    continue;
                }elseif($key == $lastCity){
                    echo '</ul></li></ul>';
                    break;
                }
                $i++;
            }
            ?>
        <h2>Search by Canadian Province</h2>
        <ul class="colLists">
            <?php 
            $i = 1;
            $lastProv = count($provList)-1;
            $prov_length = ceil(count($provList)/4);

            foreach($provList as $key => $s){
                $provUrl = str_replace(' ', '-', strtolower($s['State']['name'].'-'.$s['State']['abbreviation']));
                if($i == 1)
                    echo '<li><ul class="colList">';

                echo '<li>'; 
                echo $this->Html->link($s['State']['name'], '/'.$provUrl.'/', array('title' => 'Hot Tubs in '.$s['State']['name']));
                echo '</li>';

                if($i == $prov_length){
                    echo '</ul></li>';
                    $i = 1;
                    continue;
                }elseif($key == $lastProv){
                    echo '</ul></li></ul>';
                    break;
                }
                $i++;
            }
            ?>
    <?php }else{?>
        <h2>Popular Cities</h2>
        <ul class="colLists">
            <li>
                <ul class="colList">
                    <li><?php echo $this->Html->link('Denver', '/colorado-co/hot-tubs-highlands-ranch/', array('title' => 'Denver Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('Oklahoma City', '/oklahoma-ok/hot-tubs-oklahoma-city/', array('title' => 'Oklahoma City Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('Elmhurst', '/illinois-il/hot-tubs-downers-grove/', array('title' => 'Elmhurst Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('Philadelphia', '/new-jersey-nj/hot-tubs-cherry-hill/', array('title' => 'Philadelphia Hot Tubs'));?></li>
                </ul>
            </li>
            <li>
                <ul class="colList">
                    <li><?php echo $this->Html->link('Greensboro', '/north-carolina-nc/hot-tubs-greensboro/', array('title' => 'Greensboro Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('Pittsburgh', '/pennsylvania-pa/hot-tubs-pittsburgh/', array('title' => 'Pittsburgh Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('Hartford - New Haven', '/connecticut-ct/hot-tubs-avon/', array('title' => 'Hartford - New Haven Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('San Diego', '/california-ca/hot-tubs-san-diego/', array('title' => 'San Diego Hot Tubs'));?></li>
                </ul>
            </li>
            <li>
                <ul class="colList">
                    <li><?php echo $this->Html->link('Irvine', '/california-ca/hot-tubs-santa-ana/', array('title' => 'Irvine Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('San Jose', '/california-ca/hot-tubs-san-jose/', array('title' => 'San Jose Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('Las Vegas', '/nevada-nv/hot-tubs-las-vegas/', array('title' => 'Las Vegas Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('Seattle', '/washington-wa/hot-tubs-seattle/', array('title' => 'Seattle Hot Tubs'));?></li>
                </ul>
            </li>
            <li>
                <ul class="colList">
                    <li><?php echo $this->Html->link('Minneapolis - Saint Paul', '/minnesota-mn/hot-tubs-lakeville/', array('title' => 'Minneapolis - Saint Paul Hot Tubs'));?></li>
                    <li><?php echo $this->Html->link('St. Louis', '/missouri-mo/hot-tubs-st-louis/', array('title' => 'St. Louis Hot Tubs'));?></li>
                </ul>
            </li>
        </ul>
        <h2>Search by State</h2>
        <ul class="colLists">
            <?php 
            $i = 1;
            $lastState = count($stateList)-1;
            foreach($stateList as $key => $s){
                $stateUrl = str_replace(' ', '-', strtolower($s['State']['name'].'-'.$s['State']['abbreviation']));
                if($i == 1){
                    echo '<li><ul class="colList">';
                }
                echo '<li>'; 
                echo $this->Html->link($s['State']['name'], '/'.$stateUrl.'/', array('title' => 'Hot Tubs in '.$s['State']['name']));
                echo '</li>';

                if($i == 13){
                    echo '</ul></li>';
                    $i = 1;
                    continue;
                }elseif($key == $lastState){
                    echo '</ul></li></ul>';
                    break;
                }
                $i++;
            }
            ?>
    <?php }?>
</div>