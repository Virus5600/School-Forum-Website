<div style="font-family: 'Arial'; margin: 0; max-width: 100%; width: 100%">
	<div style="height: 5rem; background-color: #A41F34; padding: 5px; display: flex;">
		<img src="{{ App\Models\Settings::getFile('web-logo') }}" style="height: auto; margin-left: auto; margin-right: 1rem; border-radius: 50%; background-color: white; padding: .125rem;">
		<h1 style="color: white; margin-top: auto; margin-bottom: auto; margin-right: auto;">{{ App\Models\Settings::getValue('web-name') }}</h1>
	</div>

	<div style="display: flex; flex-direction: column;">
		<div style="width: 75%; margin-left: auto; margin-right: auto;">
			<h1>@yield('title')</h1>

			@yield('content')
		</div>
	</div><br>

	<div style="height: 2.5rem; background-color: #A41F34; text-align: center; padding: 5px;">
		<p style="color: #F7F2E9; font-size: smaller; text-align: center; width: 100%;">
			This is a system-generated email. Please do not reply.
		</p>
	</div>
</div>
