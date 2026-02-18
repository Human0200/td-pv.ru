readyDOM(() => {
	BX.bindDelegate(document, 'click', { class: '_vk-video' }, function () {
		const src = this.dataset.url;
		if (!src) return;

		const nodeIframe = BX.create('iframe', {
			attrs: {
				height: '100%',
				width: '100%',
				allow: 'autoplay; encrypted-media; fullscreen; picture-in-picture;',
				frameborder: "0",
				webkitAllowFullScreen: '',
				mozallowfullscreen: '',
				allowFullScreen: '',
				src,
			},
		});

		const nodeParent = this.parentNode;

		nodeParent.innerHTML = '';
		nodeParent.appendChild(nodeIframe);
	});
})