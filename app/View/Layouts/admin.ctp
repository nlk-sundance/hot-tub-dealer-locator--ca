<html>
<head>
    <title>Sundance Spas&reg; Dealer Locator</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <?php
    echo $this->Html->css('base', null, array('inline' => TRUE));
    echo $this->Html->script('prototype', array('inline' => TRUE));
    echo $this->Html->script('scriptaculous', array('inline' => TRUE));
    ?>
</head>

<body>

<!-- START: Header -->
<div id="logout">[<?php echo $this->Html->link('Logout', '/dealers/logout');?>] </div>
<div id="banner">Sundance Spas&reg; Dealer Locator</div>
<?php
    $nav = array();
    if(isset($tabOn)){
        $nav[$tabOn] = 'on';
    }
    if(!isset($nav['dealers'])){
        $nav['dealers'] = '';
    }
    if(!isset($nav['users'])){
        $nav['users'] = '';
    }
?>

<div id="navigation">
    <?php if($this->Session->read('login.group_id') == 1){?>
        <?php echo $this->Html->link('Dealers', '/dealers/index', array('class' => $nav['dealers']));?>&nbsp;|&nbsp;
        <?php echo $this->Html->link('Pending ('.$pending_num.')', '/dealers/pending', array('class' => $nav['dealers']));?>&nbsp;|&nbsp;
        <?php echo $this->Html->link('Export', '/dealers/export', array('class' => $nav['dealers']));?>
        <!--a href="<?php //echo BASEDIR;?>/dealers/index" class="<?php //echo $nav['dealers'];?>">Dealers</a>&nbsp;|&nbsp;
        <a href="<?php //echo BASEDIR;?>/dealers/export" class="<?php //echo $nav['dealers'];?>">Export</a-->
    <?php }else echo '&nbsp;';?>
</div>
<!-- END: Header -->

<TABLE WIDTH="1027" CELLPADDING="0" CELLSPACING="0" BORDER="0">
    <TR>
        <td>
        <!-- BEGIN TEMPLATE -->
            <DIV CLASS="text4">
            <!-- START: Middle -->
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
                <?php //echo $cakeDebug;?>
                <?php echo $this->element('sql_dump'); ?>
            <!-- END: Middle -->
            </div>  
        <!-- END TEMPLATE -->
        </TD>
    </TR>
</TABLE>

<table id="frame">
    <tr>
        <td valign="top" id="header"></td>
    </tr>
    <tr>
        <td valign="top" id="middle">
        <!-- START: Middle -->
            <?php #if (isset($this->controller->Session)) $this->controller->Session->flash(); ?>
            <?php #echo $content_for_layout?>
            <?php #echo $cakeDebug;?>
        <!-- END: Middle -->
      </td>
    </tr>
    <tr>
        <td valign="top" id="footer">
        <!-- START: Footer -->
            Copyright &#169; Sundance Spas. All Rights Reserved.
        <!-- END: Footer -->
        </td>
    </tr>
</table>

</body>
</html>