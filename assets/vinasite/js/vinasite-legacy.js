/**
 * VinaSite legacy slider – autoplay + dots + arrows cho [ux_slider] shim.
 * Thuần vanilla JS, không phụ thuộc thư viện.
 */
(function () {
	'use strict';

	function initSlider(el) {
		var track = el.querySelector('.vs-slider__track');
		if (!track) return;

		// Loại slide rỗng (thẻ <p> trống do wpautop sinh ra).
		Array.prototype.slice.call(track.children).forEach(function (c) {
			if (!c.textContent.trim() && !c.querySelector('img,iframe,video')) c.remove();
		});

		var slides = Array.prototype.slice.call(track.children);
		if (slides.length < 2) {
			el.classList.add('vs-slider--single');
			return;
		}

		var dotsWrap = el.querySelector('.vs-slider__dots');
		var dots = [];
		if (dotsWrap) {
			slides.forEach(function (s, i) {
				var b = document.createElement('button');
				b.type = 'button';
				b.setAttribute('aria-label', 'Slide ' + (i + 1));
				if (i === 0) b.classList.add('is-active');
				b.addEventListener('click', function () { stop(); go(i); });
				dotsWrap.appendChild(b);
			});
			dots = Array.prototype.slice.call(dotsWrap.children);
		}

		var idx = 0;
		var timer = parseInt(el.getAttribute('data-timer') || '0', 10);
		var handle = null;
		var scrollDebounce = null;

		function go(i) {
			idx = (i + slides.length) % slides.length;
			track.scrollTo({ left: slides[idx].offsetLeft - track.offsetLeft, behavior: 'smooth' });
			mark();
		}
		function mark() {
			dots.forEach(function (d, k) { d.classList.toggle('is-active', k === idx); });
		}
		function tick() {
			handle = setTimeout(function () { go(idx + 1); tick(); }, timer);
		}
		function stop() {
			if (handle) clearTimeout(handle);
			timer = 0;
		}

		track.addEventListener('scroll', function () {
			clearTimeout(scrollDebounce);
			scrollDebounce = setTimeout(function () {
				var i = Math.round(track.scrollLeft / track.clientWidth);
				idx = Math.max(0, Math.min(slides.length - 1, i));
				mark();
			}, 90);
		});

		var prev = el.querySelector('.vs-slider__arrow--prev');
		var next = el.querySelector('.vs-slider__arrow--next');
		if (prev) prev.addEventListener('click', function () { stop(); go(idx - 1); });
		if (next) next.addEventListener('click', function () { stop(); go(idx + 1); });

		if (timer >= 1000) {
			tick();
			el.addEventListener('mouseenter', function () { if (handle) clearTimeout(handle); });
			el.addEventListener('mouseleave', function () { if (timer >= 1000) { clearTimeout(handle); tick(); } });
		}
	}

	function boot() {
		// Dọn <p> rỗng + <br> do wpautop chèn làm hỏng lưới flex (cột bị rớt hàng).
		Array.prototype.slice.call(document.querySelectorAll('.vs-ux-row > br, .vs-slider__track > br')).forEach(function (b) { b.remove(); });
		Array.prototype.slice.call(document.querySelectorAll('.vs-ux-row > p, .vs-ux-col > p, .vs-slider__track > p')).forEach(function (p) {
			if (!p.textContent.trim() && !p.querySelector('img,iframe,video,a')) p.remove();
		});
		Array.prototype.slice.call(document.querySelectorAll('.vs-slider')).forEach(initSlider);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
