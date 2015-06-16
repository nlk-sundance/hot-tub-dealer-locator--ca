<table id="content">
    <tr>
        <?php echo $this->element('filter', $filter); ?>
        <td id="main">
            <form method="post" action="<?php echo $this->Html->url('/dealers/exportcustom_view'); ?>" id="form-export">
                <table>
                    <tr>
                        <td class="form-label">Filename:</td>
                        <td class="form-data">
                            <input type="text" maxlength="100" size="50" name="filename"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Format:</td>
                        <td class="form-data">
                            <select name="format">
                                <option value="xls">xls</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="form-bottom">
                    <input type="submit" value="Generate" />
                </div>
            </form>
        </td>
    </tr>
</table>