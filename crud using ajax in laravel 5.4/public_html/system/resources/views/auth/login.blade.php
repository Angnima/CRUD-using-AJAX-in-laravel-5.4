<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Invoice Management | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{url('admin/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('admin/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{url('admin/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/animate.css')}}">
    <link rel="stylesheet" href="{{url('admin/css/bootstrap.min.css')}}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        .icheckbox_square-blue.focus[aria-checked="false"] {
            background-position: -24px 0;
        }

        body {
            height: 100%;
            width: 100%;
            padding: 100px;
            background-size:cover !important;
            background-image: url({{asset('admin/login-bg.jpg')}}) !important;
        }

        .login-box {
            margin: 0 auto;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.75);
        }

        .login-logo a:focus {
            text-decoration: underline;
        }
    </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Invoice</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @if ($errors->has('Auth'))
            <div class="alert alert-danger alert-dismissable fade in animated bounceInLeft">
                <button class="close" data-dismiss="alert"><i class="fa fa-close"></i></button>
                <i class="fa fa-warning"></i>
                <span>{{$errors->first('Auth')}}</span>
            </div>
        @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login.auth') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-xs-8">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>

            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

            </div>
            <a class="btn btn-link" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 3.1.1 -->
<script src="{{url('admin/plugins/jQuery/jquery-3.1.1.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('admin/js/bootstrap.min.js')}}"></script>

