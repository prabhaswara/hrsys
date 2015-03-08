<!DOCTYPE html>

<html>
    <head>
        <title>Template</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link rel="stylesheet" type="text/css" href="{base_url}style/global_style.css" />
        <link rel="stylesheet" type="text/css" href="{base_url}js/w2ui-1.4.2/w2ui-1.4.2.css" />
        <link rel="stylesheet" type="text/css" href="{base_url}style/notification/box.css" />
        <script type="text/javascript" src="{base_url}js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="{base_url}js/w2ui-1.4.2/w2ui-1.4.2.js"></script>
        <script type="text/javascript" src="{base_url}js/global_js.js"></script>
    </head>
    <body>  
    <center>

        <div style="margin-top: 200px;border:1px solid silver;width: 300px;padding: 50px">
    <?=$message ?>
        <form method="POST">
            
            <table>
                <tr><td><label for="username">Username</label></td><td width="5px">:</td>
                    <td><input type="text" size="20" id="username" name="username"/></td>
                </tr>
                <tr><td><label for="username">Password</label></td><td width="5px">:</td>
                    <td><input type="password" size="20" id="password" name="password"/></td>
                </tr>
            </table>
            <input type="submit" value="Login"/>
      
      
    </form>
        </div>
            </center>
 </body>
</html>



