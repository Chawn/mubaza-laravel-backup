<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<a href="{{ action('OrderController@getCreateCart') }}" class="btn btn-success">Create cart</a>
{{ dd(\Session::get('cart-id')) }}
</body>
</html>