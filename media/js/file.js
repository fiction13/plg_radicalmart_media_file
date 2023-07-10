/*
 * @package   plg_radicalmart_media_file
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

"use strict";

window.RadicalMartFieldGalleryFile = {
	select(element) {
		let container = element.closest('[radicalmart-field-gallery="container"]');
		if (container) {
			let data = Joomla.selectedMediaFile;
			if (data && data.path) {
				let url = Joomla.getOptions('system.paths').baseFull + "index.php?option=com_media&task=api.files&url=true&path="
					+ data.path + "&mediatypes=0&" + Joomla.getOptions('csrf.token') + "=1&format=json";
				fetch(url, {
					method: 'GET',
					headers: {
						'Content-Type': 'application/json'
					}
				}).then(function (response) {
					response.json().then((result) => {
						if (result.data.length > 0) {
							let media = result.data[0];
							if (media.url) {
								let paths = Joomla.getOptions('system.paths'),
									rootFull = paths.rootFull,
									parts = media.url.split(rootFull);
								if (parts.length > 1) {
									let src = parts[1];
									let modal = Joomla.Modal.getCurrent();
									if (modal) {
										modal.close();
									}

									let template = window.RadicalMartFieldGallery.getTypeTemplate(container, 'file');
									if (template) {
										template.querySelector('input[data-name*="[type]"]').value = 'file';
										template.querySelector('input[data-name*="[src]"]').setAttribute('value', src);

										let preview = template.querySelector('[radicalmart-field-gallery="preview"]');
										if (preview) {
											preview.setAttribute('src', media.url);
										}

										window.RadicalMartFieldGallery.appendItem(container, template);
									}
								}
							}
						}
					})
				})
			}
		}
	}
}

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('[radicalmart-field-gallery="container"]').forEach((container) => {
		let modal = container.querySelector('[id*="_modal_type_file"]');
		if (modal) {
			modal.addEventListener('shown.bs.modal', (event) => {
				let iframe = event.target.querySelector('iframe');
				Joomla.Modal.setCurrent(event.target);
				if (iframe) {
					iframe.addEventListener('load', () => {
						let iframeWindow = iframe.contentWindow;
						if (iframeWindow) {
							iframeWindow.Joomla.Modal.setCurrent(event.target);
						}
					});
				}
			});
		}
	});
});
