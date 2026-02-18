readyDOM(() => {
	BX.bindDelegate(document, 'click', { class: '_rutube-video' }, function () {
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

		nodeIframe.addEventListener('load', function() {
			this.contentWindow.postMessage(
				JSON.stringify({
					type: "player:play",
					data: {},
				}),
				"*"
			)
		});

		const nodeParent = this.parentNode;

		nodeParent.innerHTML = '';
		nodeParent.appendChild(nodeIframe);
	});
})