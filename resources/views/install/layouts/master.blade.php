{{--
 * Brain Train - Find the job you love!
 * Copyright (c) Brain Train Kenya. All Rights Reserved
 *
 * Website: http://www.braintrainke.com
 *
 * CODED WITH LOVE
 * ---------------
 * 	@author : Wanekeya Sam
 *  Title   : Full-stack Developer
 * 	created	: 31 August, 2017
 *	version : 1.0
 * 	website : https://www.wanekeyasam.co.ke
 *	Email   : contact@wanekeyasam.co.ke
--}}
<!DOCTYPE html>
<html lang="{{ (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en' }}">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex,nofollow"/>
	<meta name="googlebot" content="noindex">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::asset('assets/ico/apple-touch-icon-144x144.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::asset('assets/ico/apple-touch-icon-114x114.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::asset('assets/ico/apple-touch-icon-72x72.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ URL::asset('assets/ico/apple-touch-icon-57x57.png') }}">
	<link rel="shortcut icon" href="{{ URL::asset('assets/ico/favicon.png') }}">
	<title>@yield('title')</title>
	
	@yield('before_styles')
	
	<link href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/style/default.css') . '?v=' . time() }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset('assets/css/owl.carousel.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/owl.theme.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('assets/css/flags/flags.css') }}" rel="stylesheet">
	
	@yield('after_styles')

    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script>
		paceOptions = {
			elements: true
		};
	</script>
	<script src="{{ URL::asset('assets/js/pace.min.js') }}"></script>
</head>
<body>
<div id="wrapper">

	@section('header')
		@include('install.layouts.inc.header')
	@show

	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<h1 class="text-center title-1" style="text-transform: none; margin: 50px 0 20px; font-weight: bold;">{{ trans('messages.installation') }}</h1>

				@include('install._steps')

				@if (count($errors) > 0)
					<div class="alert alert-danger alert-noborder" style="margin-top: 25px;">
						@foreach ($errors->all() as $key => $error)
							<p class="text-semibold">{!! $error !!}</p>
						@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>

	<div class="main-container">
		<div class="container">
			<div class="section-content">
				<div class="col-md-12 inner-box">
					@yield('content')
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				@section('footer')
					@include('install.layouts.inc.footer')
				@show
			</div>
		</div>
	</div>

</div>

@yield('before_scripts')

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"> </script> -->
<script src="{{ URL::asset('assets/js/jquery/1.10.1/jquery-1.10.1.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
	$(document).ready(function () {
		/* Select Boxes */
		$(".selecter").select2({
			language: '<?php echo (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en'; ?>',
			dropdownAutoWidth: 'true',
			/*minimumResultsForSearch: Infinity*/
		});
	});
</script>

@yield('after_scripts')

<script>
<?php
    $tracking_code = config('settings.tracking_code');
    $tracking_code = preg_replace('#<script(.*?)>(.*?)</script>#is', '$2', $tracking_code);
    echo $tracking_code . "\n";
?>
</script>
</body>
</html>