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
    <?=$message ?>
        <form method="POST">
      <label for="username">Username:</label>
      <input type="text" size="20" id="username" name="username"/>
      <br/>
      <label for="password">Password:</label>
      <input type="password" size="20" id="passowrd" name="password"/>
      <br/>
      <input type="submit" value="Login"/>
    </form>
 </body>
</html>



