<table id="content">
    <tr>
        <?php echo $this->element('filter', $filter); ?>
        <td id="main">
            <?php
            if (!empty($data)) {
                echo '<div class="action-link">' . $this->Html->link('Create New Dealer', 'show/') . '</div>';
                ?>
                <div id='pagination'>
                    Results per page: <?php echo $this->Paginator->counter('{:start}-{:end} of {:count}');?>
                    &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;
                    <?php
                    echo $this->Paginator->prev(
                        $this->Html->image('nav/arrowleft.gif'),
                        array('escape' => FALSE),
                        null,
                        array('class' => 'prev disabled', 'escape' => FALSE)
                    );
                    echo $this->Paginator->numbers(array('first' => 1, 'last' => 1, 'ellipsis' => ' | ... | '));
                    echo $this->Paginator->next(
                        $this->Html->image('nav/arrowright.gif'),
                        array('escape' => FALSE),
                        null,
                        array('class' => 'prev disabled', 'escape' => FALSE)
                    );?>
                    &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;Show per page:
                    <?php 
                    $cur_params = $this->Paginator->params();
                    $limit = $cur_params['limit'];
                    foreach(array(2, 5, 10, 20, 50, 100, 500) as $l){
                        if($limit == $l){
                            echo '<span style="font-style:italic">'.$l.'</span>';
                        }else{
                            echo $this->Paginator->link($l, array('limit' => $l));
                        }
                        echo '&nbsp;';
                    }
                    ?>
                    </div>
                <?php
                echo '<table cellspacing="1" id="list">';
                $th = array(
                    $this->Paginator->sort('dealer_number', 'Num'),
                    $this->Paginator->sort('name', 'Name'),
                    $this->Paginator->sort('email', 'E-mail'),
                    $this->Paginator->sort('phone', 'Phone'),
                    $this->Paginator->sort('city', 'City'),
                    $this->Paginator->sort('State.name', 'State'),
                    $this->Paginator->sort('zip', 'Zip'),
                    $this->Paginator->sort('Country.name', 'Country'),
                    '&nbsp'
                );
                echo $this->Html->tableHeaders($th);

                foreach ($data as $i => $dealer) {


                    $tr = array(
                        $dealer["Dealer"]["dealer_number"],
                        $this->Html->link($dealer["Dealer"]["name"], 'show/' . $dealer["Dealer"]["id"]),
                        $dealer["Dealer"]["email"],
                        $dealer["Dealer"]["phone"],
                        $dealer["Dealer"]["city"],
                        $dealer["State"]["abbreviation"],
                        $dealer["Dealer"]["zip"],
                        $dealer["Country"]["name"],
                        '<a href=' . $this->Html->url('/dealers/delete_dealer/' . $dealer['Dealer']['id']) . ' onclick="return makeSure(\'' . $dealer['Dealer']['dealer_number'] . '\')">' . $this->Html->image('btn_delete.gif') . '</a>'
                    );
                    echo $this->Html->tableCells($tr, null, array('class' => "on"));
                }
                echo '<table>';
            } else {
                echo '<b>No Results.</b>';
            }
            ?>

        </td>
    </tr>
</table>

<script language="javascript">
    function makeSure(num)
    {
        return confirm("Delete dealer number " + num + " from the database?\nThis action can not be undone.");
    }
</script>
<?php //die();?>