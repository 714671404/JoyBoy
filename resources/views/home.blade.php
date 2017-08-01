@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">欢迎进入</div>

                <div class="panel-body" id="content">
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        window.onload = home();
        function home()
        {
            urlHome(5);
        }
        function urlHome(second)
        {
            var second = parseInt(second);
            var content = document.getElementById('content');
            content.innerHTML = second + ' 秒后跳转首页';
            second --;
            if (second < 0) {
                window.location.href = '/';
            }
            setTimeout("urlHome('"+second+"')", 1000);
        }
    </script>
@endsection
