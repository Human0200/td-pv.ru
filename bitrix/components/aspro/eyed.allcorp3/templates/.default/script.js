if (typeof window.JEyed === 'undefined') {
	window.JEyed = function(result) {
		var _private = {
            inited: false,
			speakTimer: false,
            options: typeof result === 'object' && typeof result.OPTIONS === 'object' ? result.OPTIONS : {},
        };

        Object.defineProperties(this, {
            inited: {
                get: function() {
                    return _private.inited;
                },
                set: function(value) {
                    if (value) {
                        _private.inited = true;
                    }
                }
            },
			speakTimer: {
                get: function() {
                    return _private.speakTimer;
                },
                set: function(value) {
                    _private.speakTimer = value;
                }
            },
        });

        this.result = function(key) {
            if (typeof result === 'object') {
                if (typeof key !== 'undefined') {
                    if (Object.keys(result).indexOf(key) > -1) {
	                    return result[key];
                    }
                }
            }

            return undefined;
        }

        this.options = function(key, value) {
			var that = this;

            if (typeof key !== 'undefined') {
                if (Object.keys(_private.options).indexOf(key) > -1) {
                	if (typeof value !== 'undefined') {
                		if (that.node) {
                			var item = that.node.querySelector('.eyed-panel__item[data-option=' + key + ']');
                			if (item) {
                				var itemValues = Array.prototype.slice.call(item.querySelectorAll('.eyed-panel__item-value'));
								if (itemValues) {
									for (var i in itemValues) {
										BX.removeClass(itemValues[i], 'active');
									}
								}

								var itemValue = item.querySelector('.eyed-panel__item-value[data-option_value="' + value + '"]');
								if (itemValue) {
									_private.options[key] = value;

									if (key === 'SPEAKER') {
										if (value == 0) {
											that.stopSpeak();
										}
									}
									else if (key === 'FONT-SIZE') {
										that.dispatchWindowResize();
									}
									else if (key === 'IMAGES') {
										that.dispatchWindowResize();
									}

									BX.addClass(itemValue, 'active');
								}
                			}
                		}
                	}
					else {
                        return _private.options[key];
                	}
                }
            }

            return undefined;
        }

		this.getClasses = function() {
			var classes = [];

			for (var key in _private.options) {
				if (Object.hasOwnProperty.call(_private.options, key)) {
					var value = _private.options[key];
					if (value == 0) {
						value = 'off';
					}
					else if (value == 1) {
						value = 'on';
					}

					classes.push('eyed--' + key.toLowerCase() + '--' + value.toLowerCase());
				}
			}

			classes.push('eyed');

			return classes;
		}

        this.save = function() {
        	BX.setCookie(
				this.result('COOKIE')['OPTIONS'],
				JSON.stringify(_private.options),
				{
					path: arAsproOptions['SITE_DIR'],
					expires: 355 * 86400 // 1 year
				}
			);

			this.updateBodyClasses();
        }

        var that = this;

		that.init();
	}

	window.JEyed.prototype = {
		node: null,
		textNode: null,
		textRate: 1.1,
        handlers: {},

        init: function() {
			var that = this;

            if (!that.inited) {
                that.inited = true;

                that.node = BX('eyed-panel');
                that.node.eyed = that;

				that.textNode = BX.create({
					tag: 'div',
					props: {'class': 'eyed-panel__speech'},
					style: {'display': 'none'},
					events: {},
					children: {},
					text: '',
					html: '',
				});

                that.bindEvents();

				that.speak(document.title);
            }
        },

        bindEvents: function() {
        	var that = this;

			if (that.node) {
				if (typeof that.onToggleClick !== 'function') {
					// live click on document
					that.onToggleClick = function(e) {
						if (!e) {
							e = window.event;
						}

						var target = e.target || e.srcElement;

						if (
							typeof target !== 'undefined' &&
							target
						) {
							// there is need IE hack for svg target here
							// var toggle = target.closest('.eyed-toggle');

							var toggle = null;
							var parent = target;
							while (parent) {
								if (
									typeof parent.matches !== 'undefined' &&
									parent.matches('.eyed-toggle')
								) {
									toggle = parent;
									break;
								}
								else{
									parent = parent.parentElement || parent.parentNode;
								}
							}

							if (toggle) {
								if (that.isActive()) {
									that.disable();
								}
								else {
									that.activate();
								}
							}
						}
					}
				}
				document.addEventListener('click', that.onToggleClick);

				if (that.getSynth()) {
					that.getSynth().onerror = function(e) {
						that.stopSpeak();
					}
				}
				else {
					if (that.options('SPEAKER')) {
						that.options('SPEAKER', 0);
						that.save();

						var item = that.node.querySelector('.eyed-panel__item[data-option="SPEAKER"]')
						if (item) {
							BX.remove(item);
						}
					}
				}

				if (navigator.userAgent.indexOf('MSIE') !== -1) {
					that.options('COLOR-SCHEME', 'black');
					that.save();

					var item = that.node.querySelector('.eyed-panel__item[data-option="COLOR-SCHEME"]')
					if (item) {
						var itemValues = Array.prototype.slice.call(item.querySelectorAll('.eyed-panel__item-value:not([data-option_value="black"])'));
						if (itemValues) {
							for (var i in itemValues) {
								BX.remove(itemValues[i]);
							}
						}
					}
				}

				that.bindEyedEvents();
			}
        },

        unbindEvents: function() {
			if (typeof this.onToggleClick === 'function') {
				document.removeEventListener('click', this.onToggleClick);
			}

			this.unbindEyedEvents();
        },

        bindEyedEvents: function() {
        	var that = this;

			if (that.node) {
				if (typeof that.onDocClick !== 'function') {
					// live click on document
					that.onDocClick = function(e) {
						if (that.isActive()) {
							if (!e) {
								e = window.event;
							}

							var target = e.target || e.srcElement;

							if (
								typeof target !== 'undefined' &&
								target
							) {
								// there is need IE hack for svg target here
								// var block = target.closest('#eyed-panel');
	
								var panel = null;
								var parent = target;
								while (parent) {
									if (
										typeof parent.matches !== 'undefined' &&
										parent.matches('#eyed-panel')
									) {
										panel = parent;
										break;
									}
									else{
										parent = parent.parentElement || parent.parentNode;
									}
								}

								if (panel) {
									// there is need IE hack for svg target here
									// var itemValue = target.closest('.eyed-panel__item-value');

									var itemValue = null;
									var parent = target;
									while (parent) {
										if (
											typeof parent.matches !== 'undefined' &&
											parent.matches('.eyed-panel__item-value')
										) {
											itemValue = parent;
											break;
										}
										else{
											parent = parent.parentElement || parent.parentNode;
										}
									}

									if (itemValue) {
										BX.PreventDefault(e);

										if (!BX.hasClass(itemValue, 'active')) {
											var item = itemValue.closest('.eyed-panel__item');
											if (item) {
												var key = BX.data(item, 'option');
												var value = BX.data(itemValue, 'option_value').toString();
												if (key.length && value.length) {
													that.options(key, value);
													that.save();
												}
											}
										}
									}
								}
							}
						}
					}
				}
				document.addEventListener('click', that.onDocClick);

				if (that.getSynth()) {
					if (typeof that.onDocMouseDown !== 'function') {
						// live mouse down on document
						that.onDocMouseDown = function(e) {
							if (that.isActive()) {
								if (!e) {
									e = window.event;
								}

								var target = e.target || e.srcElement;

								if (
									typeof target !== 'undefined' &&
									target
								) {
									// there is need IE hack for svg target here
									// var panel = target.closest('#eyed-panel');
		
									var panel = null;
									var parent = target;
									while (parent) {
										if (
											typeof parent.matches !== 'undefined' &&
											parent.matches('#eyed-panel')
										) {
											panel = parent;
											break;
										}
										else{
											parent = parent.parentElement || parent.parentNode;
										}
									}

									if (!panel) {
										if (
											that.isActive() &&
											that.options('SPEAKER') != 0
										) {
											that.stopSpeak();
										}
									}
								}
							}
						}
					}
					document.addEventListener('mousedown', that.onDocMouseDown);

					if (typeof that.onDocMouseUp !== 'function') {
						// live mouse up on document
						that.onDocMouseUp = function(e) {
							if (that.isActive()) {
								if (!e) {
									e = window.event;
								}

								var target = e.target || e.srcElement;

								if (
									typeof target !== 'undefined' &&
									target
								) {
									// there is need IE hack for svg target here
									// var panel = target.closest('#eyed-panel');
		
									var panel = null;
									var parent = target;
									while (parent) {
										if (
											typeof parent.matches !== 'undefined' &&
											parent.matches('#eyed-panel')
										) {
											panel = parent;
											break;
										}
										else{
											parent = parent.parentElement || parent.parentNode;
										}
									}

									if (!panel) {
										setTimeout(function() {
											var text = that.getSelection();
											if (
												typeof text !== 'undefined' &&
												text.length
											) {
												that.speak(text);
											}
											else {
												that.stopSpeak();
											}
										}, 100);
									}
								}
							}
						}
					}
					document.addEventListener('mouseup', that.onDocMouseUp);

					if (typeof that.onDocMouseOver !== 'function') {
						// live mouse enter on document
						that.onDocMouseOver = function(e) {
							if (that.isActive()) {
								if (!e) {
									e = window.event;
								}

								var target = e.target || e.srcElement;
								if (
									typeof target !== 'undefined' &&
									target
								) {
									var link = target.closest('a') || target.closest('.btn') || target.closest('.switcher-title') || target.closest('[data-eyed_speak]') || target.closest('[title]') || target.closest('[data-event="jqm"]');
									if (link) {
										var overTimer = setInterval(function() {
											if (!that.speakTimer) {
												if (overTimer) {
													clearInterval(overTimer);
													overTimer = false;
												}

												var text = that.getNodeText(link);

												if (
													typeof text !== 'undefined' &&
													text.length
												) {
													that.speak(text);
												}
											}
										}, 100);

										var onLinkMouseOut = function() {
											if (overTimer) {
												clearInterval(overTimer);
												overTimer = false;
											}

											link.removeEventListener('mouseout', onLinkMouseOut);
										}

										link.addEventListener('mouseout', onLinkMouseOut);
									}
								}
							}
						}
					}
					document.addEventListener('mouseover', that.onDocMouseOver);
				}

			}
        },

        unbindEyedEvents: function() {
			if (typeof this.onDocClick === 'function') {
				document.removeEventListener('click', this.onDocClick);
			}

			if (typeof this.onDocMouseDown === 'function') {
				document.removeEventListener('mousedown', this.onDocMouseDown);
			}

			if (typeof this.onDocMouseUp === 'function') {
				document.removeEventListener('mouseup', this.onDocMouseUp);
			}

			if (typeof this.onDocMouseOver === 'function') {
				document.removeEventListener('mouseover', this.onDocMouseOver);
			}
        },

		isActive: function() {
			return BX.getCookie(this.result('COOKIE')['ACTIVE']) === 'Y';
		},

        activate: function() {
			var that = this;

			BX.setCookie(
				that.result('COOKIE')['ACTIVE'],
				'Y',
				{
					path: arAsproOptions['SITE_DIR'],
					expires: 355 * 86400 // 1 year
				}
			);

			that.updateBodyClasses();
			that.bindEyedEvents();

			var toggles = Array.prototype.slice.call(document.querySelectorAll('.eyed-toggle'));
			if (toggles) {
				for (var i in toggles) {
					toggles[i].setAttribute('title', BX.message('EA_T_NORMAL_VERSION'));

					if (BX.hasClass(toggles[i], 'footer__eyed')) {
						var title = BX.findChild(toggles[i], {
							tag: 'span',
							class: 'footer-eyed__name'
						}, true);
						if (title) {
							title.innerText = BX.message('EA_T_NORMAL_VERSION');
						}
					} else if (BX.hasClass(toggles[i], 'header-eyed')) {
						var title = BX.findChild(toggles[i], {
							tag: 'span',
							class: 'header-eyed__name'
						}, true);
						if (title) {
							title.innerText = BX.message('EA_T_NORMAL_VERSION');
						}
					}
				}
			}
        },

        disable: function() {
			var that = this;

			BX.setCookie(
				that.result('COOKIE')['ACTIVE'],
				'',
				{
					path: arAsproOptions['SITE_DIR'],
					expires: 355 * 86400 // 1 year
				}
			);

			that.updateBodyClasses();
			that.unbindEyedEvents();

			var toggles = Array.prototype.slice.call(document.querySelectorAll('.eyed-toggle'));
			if (toggles) {
				for (var i in toggles) {
					toggles[i].setAttribute('title', BX.message('EA_T_EYED_VERSION'));

					if (BX.hasClass(toggles[i], 'footer__eyed')) {
						var title = BX.findChild(toggles[i], {
							tag: 'span',
							class: 'footer-eyed__name'
						}, true);
						if (title) {
							title.innerText = BX.message('EA_T_EYED_VERSION');
						}
					} else if (BX.hasClass(toggles[i], 'header-eyed')) {
						var title = BX.findChild(toggles[i], {
							tag: 'span',
							class: 'header-eyed__name'
						}, true);
						if (title) {
							title.innerText = BX.message('EA_T_EYED_VERSION');
						}
					}
				}
			}
        },

		dispatchWindowResize: function() {
			if (
				typeof Event == 'function' ||
				(
					navigator.userAgent.indexOf('MSIE') !== -1 ||
					navigator.appVersion.indexOf('Trident/') > 0
				)
			) {
				var resizeEvent = window.document.createEvent('UIEvents'); 
				resizeEvent.initUIEvent('resize', true, false, window, 0); 
				window.dispatchEvent(resizeEvent);
			}
			else {
				var event = new Event('resize');
				window.dispatchEvent(event);
			}
		},

		updateBodyClasses: function() {
			var that = this;

			var classes = that.getClasses();
			if (classes) {
				var attrClass = document.body.getAttribute('class');
				attrClass = attrClass.replace(/eyed[^\s]*/gi, '');
				attrClass = attrClass.replace(/\s{2,}/gi, ' ');

				if (that.isActive()) {
					for (var key in classes) {
						if (Object.hasOwnProperty.call(classes, key)) {
							attrClass += ' ' + classes[key];
						}
					}
				}

				document.body.setAttribute('class', attrClass);
			}
		},

		refresh: function(){
            var componentAction = 'getEyed';
            var componentName = 'aspro:eyed.allcorp3';
            var sessid = BX.message('bitrix_sessid');
            var lang = BX.message('LANGUAGE_ID');
            var siteId = arAsproOptions.SITE_ID;
            var signedParams = this.result('SIGNED_PARAMS');

            var that = this;
            BX.ajax({
                url: '/bitrix/services/main/ajax.php?mode=ajax&c=' + encodeURIComponent(componentName) +'&action=' + componentAction + '&sessid=' + sessid + '&SITE_ID=' + siteId + '&siteId=' + siteId + '&lang=' + lang + '&signedParameters=' + encodeURIComponent(signedParams) + '&clear_cache_session=Y',
                method: 'POST',
                async: true,
                processData: true,
                scriptsRunFirst: true,
                emulateOnload: true,
                start: true,
                cache: false,
                onsuccess: function(response){
                    if(response.trim().length){
                        if(that.node){
                            that.unbindEvents();
                            that.node.parentElement.insertAdjacentHTML('afterBegin', response);
                            that.node.remove();

                            that.node = BX('eyed-panel');
                            that.node.eyed = that;
                            that.bindEvents();
                        }
                    }
                },
                onfailure: function(){
    
                }
            });
        },

		checkState: function() {
			var toggles = Array.prototype.slice.call(document.querySelectorAll('.eyed-toggle'));
			var togglesInPanel = Array.prototype.slice.call(document.querySelectorAll('.eyed-panel .eyed-toggle'));
			if (toggles.length > togglesInPanel.length) {
				this.enable();
			}
			else {
				this.destroy();
			}
		},

		isEnabled: function() {
			if (this.node) {
				if (this.node.querySelector('.eyed-panel__inner')) {
					return true;
				}
			}

			return false;
		},

		destroy: function() {
			if (this.isEnabled()) {
				this.disable();
				this.unbindEvents();
				
				if (this.node) {
					this.node.innerHTML = '';
				}
			}
		},

		enable: function() {
			if (!this.isEnabled()) {
				this.refresh();
				this.bindEvents();
			}
		},

		getSelection: function() {
			var text = (
				window.getSelection && 
				window.getSelection().toString()
			) ||  (
				document.selection &&
				document.selection.createRange().text
			);

			return typeof text === 'undefined' ? false : this.clearText(text);
		},

		getNodeText: function(node) {
			var text = '';

			if (node) {
				if (node.closest('.header-cart[title]')) {
					var text = this.clearText(node.closest('.header-cart').getAttribute('title').toString().trim());
				}
				else {
					if (
						!BX.hasClass(node, 'developer') &&
						!BX.hasClass(node, 'HEADER')
					) {
						var text = this.clearText(node.innerText.toString().trim());
					}
				}

				if (
					(
						typeof text === 'undefined' ||
						!text.length
					) &&
					BX.data(node, 'eyed-speak')
				) {
					var text = this.clearText(BX.data(node, 'eyed_speak').toString().trim());
				}

				if (
					(
						typeof text === 'undefined' ||
						!text.length
					) &&
					node.getAttribute('title')
				) {
					var text = this.clearText(node.getAttribute('title').toString().trim());
				}

				if (
					(
						typeof text === 'undefined' ||
						!text.length
					) &&
					node.tagName === 'A'
				) {
					var item = node.closest('.grid-list__item') || node.closest('.owl-item');
					if (item) {
						var title = item.querySelector('.switcher-title');
						var text = title.innerText.toString().trim();
					}
				}
			}

			return text;
		},

		clearText: function(text) {
			this.textNode.innerHTML = text;
			text = this.textNode.innerText.replace(' *', '');
			var regex = BX.message('__EA_T_TEXT_REGEX');

			if (regex.length) {
				regex = new RegExp(regex, 'i');

				if (text.match(regex)) {
					return text;
				}
				else {
					text = '';
				}
			}

			return text;
		},

		getTextLang: function(text) {
			return 'ru-RU';
		},

        getSynth: function() {
        	return window.speechSynthesis || window.mozspeechSynthesis || window.webkitspeechSynthesis;
        },

		speak: function(text) {
			var that = this;

			if (
				that.textNode &&
				that.isActive() &&
				that.options('SPEAKER') != 0 &&
				that.getSynth()
			) {
				that.stopSpeak();

				if (
					typeof text !== 'undefined' &&
					text.length
				) {
					text = that.clearText(text);
	
					try {
						var message = new SpeechSynthesisUtterance(text);
						message.lang = that.getTextLang(text);
						message.rate = that.textRate;

						message.onerror = function(e) {
							throw e;
						}

						message.onend = function(e) {
							if (that.speakTimer) {
								clearInterval(that.speakTimer);
								that.speakTimer = false;
							}
						}

						that.getSynth().speak(message);

						that.speakTimer = setInterval(function(){
							if (that.getSynth().paused) {
								that.getSynth().resume();
							}
						}, 100);
					}
					catch (e) {
						console.error(e);

						that.stopSpeak();
					}
				}
			}
		},

		stopSpeak: function() {
			var that = this;

			if (that.speakTimer) {
				clearInterval(that.speakTimer);
				that.speakTimer = false;
			}

			if (that.getSynth()) {
				that.getSynth().cancel();
			}
		},
	}
}