/*!
 * Loading overlay v1.0.0
 * https://github.com/windel07/loading-overlay.jquery
 *
 * Copyright (c) 2022 windel07
 */

(function ($) {
	$.fn.loadingOverlay = function (status = true, options = {}) {
		var settings = $.extend(
			{
				icon: null,
				backgroundColor: 'rgba(255,255,255,0.85)',
			},
			options
		);

		const loadingEl = $(this);
		const loadingOverlay = $(`<div class="loading__overlay"></div>`);
		const loadingIcon = $('<span class="loading__icon"></span>');

		loadingOverlay.css({
			backgroundColor: settings.backgroundColor || 'rgba(255,255,255,0.85)',
			position: ['HTML', 'BODY'].includes(loadingEl.prop('tagName'))
				? 'fixed'
				: 'absolute',
		});

		if (settings.icon)
			loadingIcon.css({
				backgroundImage: `url(${settings.icon})`,
			});

		loadingIcon.appendTo(loadingOverlay);

		if (status) {
			loadingEl.addClass('loading').prepend(loadingOverlay);
		} else {
			loadingEl.removeClass('loading');

			if (loadingEl.children().eq(0).hasClass('loading__overlay'))
				loadingEl.children().eq(0).remove();
		}
	};
})(jQuery);
