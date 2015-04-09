<style type="text/css">

    div.auto_complete {
        position         :absolute;
        width            :250px;
        background-color :white;
        border           :1px solid #888;
        margin           :0px;
        padding          :0px;
    }

    li.selected { background-color: #ffb; }

</style>
<table id="content">
    <tr>
        <?php echo $this->element('filter', $filter); ?>
        <td id="main">
            <?php echo $this->element('dealer_tabs');?>

            <table>
                <tr>
                    <td width="400" valign="top">
                        <?php
                        if (!empty($zipError)){
                            echo '<div class="form-error-text">' . $zipError . '</div>';
                        }
                        ?>
                        <?php if (!empty($zips)){ ?>
                            <table id="list">

                                <th width="4%"><input type="checkbox" id="main-toggle" value="" onclick="toggleAll('list', this.checked)"></th>
                                <th>Zip Code</th>
                                <th>Remove</th>

                                <?php foreach ($zips as $i => $zipcode){ ?>
                                    <tr class="<?php echo ($i % 2) ? 'on' : ''; ?>">
                                        <td align="center"><input type="checkbox" value="<?php echo $zipcode['DealersZipcode']['zipcode']; ?>" class="list-item" id="<?php echo $zipcode['DealersZipcode']['zipcode']; ?>"></td>
                                        <td align="center">
                                            <?php echo $zipcode['DealersZipcode']['zipcode']; ?>
                                        </td>
                                        <td align="center">
                                            <a href="<?php echo $this->Html->url('delete_zip/' . $data["Dealer"]["id"] . '/' . $zipcode['DealersZipcode']['zipcode']) ?>" onclick="return makeSure('<?php echo $zipcode['DealersZipcode']['zipcode']; ?>')">Remove</a>
                                        </td>
                                    </tr>        
                                <?php } ?>

                            </table>
                        <?php }else{ ?>
                            <strong>No zip codes assigned</strong>
                        <?php } ?>
                    </td>
                    <td valign="top">
                        <table width="340">
                            <tr>
                                <td class="form-labal">Enter zipcodes below. Separate by commas.</td>
                            </tr>
                            <tr>    
                                <td class="form-data">
                                    <form method="post" action="<?php echo $this->Html->url('/dealers/zip/' . $data['Dealer']['id']); ?>">
                                        <textarea rows="10" cols="34" name="data[Dealer][zip]"/></textarea><br/>
                                        <input type="submit" value=" Add ">
                                    </form>        
                                </td>    
                            </tr>

                            <?php if (!empty($zips)){ ?>                 
                                <tr>
                                    <td><hr/></td>
                                </tr>
                                <tr>
                                    <td class="form-data">
                                        Other actions: 
                                        <select id="other-actions" onchange="changeAction()">
                                            <option></option>
                                            <option value="export">Show selected zipcodes as a list</option>
                                            <option value="copy">Copy selected zipcodes to another dealer</option>
                                            <option value="remove">Remove selected zipcodes</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="form-data">
                                        <div id="export">
                                            <textarea id="export-zips" rows="10" cols="34"></textarea>
                                        </div>
                                        <div id="copy">
                                            <p>Enter the dealer number or part of the name.  Select the dealer from the list, then press copy.
                                            <form action="<?php echo $this->Html->url('/dealers/copy_zipcodes'); ?>" method="POST">
                                                <input name="data[Dealer][auto]"  id="Dealer_auto" autocomplete="off" value="" type="text" size="55"/>
                                                <div  id="Dealer_autoComplete" class="auto_complete"></div>
                                                <script type="text/javascript">
                                                    new Ajax.Autocompleter('Dealer_auto', 'Dealer_autoComplete', '../get_dealers', {asynchronous:true, evalScripts:true});
                                                </script>
                                                <br/>
                                                <input type="hidden" id="copy-zipcodes" name="data[Dealer][zipcodes]" value="" />
                                                <input type="hidden" name="data[Dealer][source]" value="<?php echo $data['Dealer']['id']; ?>" />
                                                <input type="submit" onClick="copySelectedZipcodes()" value="Copy"/>
                                                <input type="button" onClick="cancelAction(); return false;" value="Cancel"/>
                                            </form>
                                        </div>
                                        <div id="remove">
                                            <p><strong>Are you sure you want to remove the selected zipcodes?</strong></p><br/>
                                            <form action="<?php echo $this->Html->url('/dealers/delete_many_zips/' . $data['Dealer']['id']); ?>" method="POST">
                                                <input type="hidden" id="remove-zipcodes" name="data[Zipcode][remove]" value="">
                                                <input type="submit" onClick="setRemoveIds()" value="Yes"/>
                                                <input type="button" onClick="cancelAction(); return false;" value="No"/>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
            </table>
        </td>
    </tr>
</table>

<div id="test"></div>
<script language="javascript">

    function toggleAll(id, check)
    {
        var boxes = document.getElementById(id)
        boxes = boxes.getElementsByTagName('input');
        var i = boxes.length;
        while(i--) 
        { 
            if(Element.hasClassName(boxes[i], 'list-item'))
                boxes[i].checked = check;
        }
    }
    function makeSure(zip)
    {
        return confirm("Remove zipcode " + zip + "?");
    }
    function changeAction()
    {
        var sel = $('other-actions');
        if(!sel) return;
        if(sel.options[sel.selectedIndex].value == "export")
        {
            $('export').style.display="block";
            $('copy').style.display="none";
            $('remove').style.display="none";
            $('export-zips').value = getSelectedZips();
        }
        else if(sel.options[sel.selectedIndex].value == "copy")
        {
            $('export').style.display="none";
            $('copy').style.display="block";
            $('remove').style.display="none";
            $('copy-zipcodes').value = getSelectedZips();
        }
        else if(sel.options[sel.selectedIndex].value == "remove")
        {
            $('export').style.display="none";
            $('copy').style.display="none";
            $('remove').style.display="block";
            setRemoveIds();
        }
        else
        {
            $('export').style.display="none";
            $('copy').style.display="none";
            $('remove').style.display="none";
        }
    }
    function getSelectedZips()
    {
        var boxes = $('list')
        boxes = boxes.getElementsByTagName('input');
        var i = 0;
        var results = '';
    
        while(i++ < boxes.length) 
        {    
            if(Element.hasClassName(boxes[i], 'list-item') && boxes[i].checked)
            {
                var zip = boxes[i].id;
                if (results) results += ', ';
                results += zip;
            }
        }
        return results;
    }
    function getSelectedZipsAsTable()
    {
        var boxes = $('list')
        boxes = boxes.getElementsByTagName('input');
        var i = 0;
        var results = '';
    
        while(i++ < boxes.length) 
        {    
            if(Element.hasClassName(boxes[i], 'list-item') && boxes[i].checked)
            {
                var zip = boxes[i].id;
                results += '<tr><td>' + zip + '</td></tr>';
            }
        }
        if (results) results = '<table id="export-table">' + results + '</table>';
        return results;
    }
    function copySelectedZipcodes()
    {
        $('copy-zipcodes').value = getSelectedZips();
    
    }
    function setRemoveIds()
    {
        var boxes = $('list')
        boxes = boxes.getElementsByTagName('input');
        var i = 0;
        var results = '';
    
        while(i++ < boxes.length) 
        {    
            if(Element.hasClassName(boxes[i], 'list-item') && boxes[i].checked)
            {
                var zipID = boxes[i].value;
                if (results) results += ', ';
                results += zipID;
            }
        }
        $('remove-zipcodes').value = results;
    
    }
    function cancelAction()
    {
    
        var sel = $('other-actions').selectedIndex = 0;
        changeAction();
    }
    changeAction();
</script>