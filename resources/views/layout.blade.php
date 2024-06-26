<!DOCTYPE html>
<html lang="en">

<head>
    @isset($css)
     <link rel="stylesheet" href="{{asset('assets')}}/front/css/{{$css}}" />
    @endisset
    @isset($css1)
    <link rel="stylesheet" href="{{asset('assets')}}/front/css/{{$css1}}" />
   @endisset
    <x-front.header title={{$title}} />
</head>

<body>

    <x-front.bodyheader title={{$title}} />

    @include($page)

    <x-front.bodyfooter />

    <x-front.footer :js="$js ?? []" />
</body>

</html>