<!DOCTYPE html>
<html lang="en">
<head>
    <title>Novi Builder</title>

    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <!-- Stylesheets-->
    <link rel="stylesheet" href="{{asset('admin/page/css/style.css')}}">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,900%7CRoboto:500,400,100,300,600' rel='stylesheet' type='text/css'>
</head>
<body>

<input type="text" id="website_id" value="website_{{$website_id}}">

<div id="builder"></div>

<!-- Emmet -->
<script src="{{asset('admin/page/js/code-editor/emmet.js')}}"></script>
<script src="{{asset('admin/page/js/code-editor/ace/ace.js')}}"></script>
<script src="{{asset('admin/page/js/code-editor/ace/ext-emmet.js')}}"></script>

<script type="application/javascript">
    var isCookieEnabled, scriptTag, id;
    isCookieEnabled = navigator.cookieEnabled;
    id = "";
    scriptTag = document.createElement("script");

    if (isCookieEnabled) {
        if (getCookie("justupdated")) {
            id = "?" + new Date().getTime();
        }
    }

    scriptTag.setAttribute("src", "{{asset('admin/page/js/builder.min.js')}}" + id);
    document.body.appendChild(scriptTag);

    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
</script>
</body>
</html>