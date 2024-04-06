const mix = require('laravel-mix');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// START
mix
	// Configurations
	.options({
		postCss: [
			require('autoprefixer')
		]
	})
	.webpackConfig({
		resolve: {
			alias: {
				jquery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.min.js'),
				jQuery: path.resolve(__dirname, 'node_modules/jquery/dist/jquery.min.js')
			}
		},
		devtool: 'inline-source-map'
	})
	.sourceMaps()
	.disableNotifications()

	// JavaScript
	.js('resources/js/app.js', 'public/js')
	.js('resources/js/custom/components/navbar-dynamic.js', 'public/js/custom/components')

	// JS Libs
	// .js('resources/js/libs/slick.js', 'public/js/libs')

	// JS Utilities
	.copy('resources/js/util/', 'public/js/util')

	// SASS
	.sass('resources/scss/app.scss', 'public/css')

	// SASS Libs
	// .sass('resources/scss/libs/slick.scss', 'public/css/libs')

	// SASS Utilities
	.sass('resources/scss/util/animations.scss', 'public/css/util')
	.sass('resources/scss/util/custom-scrollbar.scss', 'public/css/util')
	.sass('resources/scss/util/custom-switch.scss', 'public/css/util')
	.sass('resources/scss/util/highlight-fragment.scss', 'public/css/util')
	.sass('resources/scss/util/image-input.scss', 'public/css/util')
	.sass('resources/scss/util/text-counter.scss', 'public/css/util')

	// WIDGETS
	// Cards
	.sass('resources/scss/widget/card-widget.scss', 'public/css/widget')
	// Pagination
	.js('resources/js/widget/paginator-widget.js', 'public/js/widget')

	// LAYOUTS
	// Public Layout
	.js('resources/js/views/layouts/public.js', 'public/views/layouts/public')
	.sass('resources/scss/views/layouts/public.scss', 'public/views/layouts/public')

	// Auth Layout
	.js('resources/js/views/layouts/auth.js', 'public/views/layouts/auth')
	.sass('resources/scss/views/layouts/auth.scss', 'public/views/layouts/auth')

	// Admin Layout
	.js('resources/js/views/layouts/admin.js', 'public/views/layouts/admin')
	.sass('resources/scss/views/layouts/admin.scss', 'public/views/layouts/admin')

	// INCLUDES
	// Lock View
	.sass('resources/scss/views/includes/lock-view.scss', 'public/views/includes/lock-view')
	.js('resources/js/views/includes/lock-view.js', 'public/views/includes/lock-view')

	// VIEWS
	// Discussions
	.js('resources/js/views/discussions/show-text-editor.js', 'public/views/discussions')

	// Login Page
	.js('resources/js/views/login.js', 'public/views/login')
	.sass('resources/scss/views/login.scss', 'public/views/login')

	// Register Page
	.js('resources/js/views/register.js', 'public/views/register')

	// Verification Page
	.js('resources/js/views/authenticated/verification.js', 'public/views/authenticated/verification')

	// ADMIN VIEWS
	// Lost and Found Page
	// - Create
	.js('resources/js/views/authenticated/admin/lost-and-found/create.js', 'public/views/authenticated/admin/lost-and-found')

	// Settings Page
	// .js('resources/js/views/admin/settings.js', 'public/views/admin/settings')

    // ENDING
    ;
