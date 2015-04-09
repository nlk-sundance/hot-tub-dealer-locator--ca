<html>

    <head>
        <title>Sundance Spas&reg; Dealer Locator</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <?php echo $this->Html->css("base", null, array('inline' => TRUE)); ?>
    </head>

    <body>

        <table height="100%" border="0" cellspacing="0" width="100%">
            <tr>
                <td id="content">
                    <div align="center">
                        <?php
                        if (isset($errormsg)) {
                            echo "<h3>$errormsg</h3><br />";
                        }
                        ?>
                        <h3>Login</h3>
                        <?php echo $this->Form->create('', array('action' => 'login', 'type' => 'post'));?>
                        <!--form method="post" action="<?php //echo $html->url('/dealers/login'); ?>"-->
                            <table cellpadding="20" id="box">
                                <tr>
                                    <td>
                                        <table align="center">
                                            <tr>
                                                <td>Username:</td>
                                                <td><input type="text" name="username" maxlength="45"></td>
                                            </tr>
                                            <tr>
                                                <td>Password:</td>
                                                <td><input type="password" name="password" maxlength="45"></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="submit" value=" Login "></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        <?php //echo $this->Form->end();?>
                        <script language="javascript">
                            document.forms[0].username.focus();
                        </script>
                    </div><p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p align="center">
                        This site is optimized for Microsoft Internet Explorer 6.0 or above.<br>
                        1024x768 resolution or better is recommended.<br><br>
                    </p>
                </td>
            </tr>
        </table>

    </body>
</html>