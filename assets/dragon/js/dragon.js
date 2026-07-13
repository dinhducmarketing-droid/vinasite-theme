/* Dragon Law Firm – front-end behaviour. Vanilla JS, no dependencies.
 * Progressive enhancement: everything degrades gracefully without JS. */
(function () {
  'use strict';
  var doc = document;
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  doc.documentElement.classList.add('js');

  function on(el, ev, fn) { if (el) el.addEventListener(ev, fn); }
  function $(sel, ctx) { return (ctx || doc).querySelector(sel); }
  function $all(sel, ctx) { return Array.prototype.slice.call((ctx || doc).querySelectorAll(sel)); }

  /* ---------- Sticky header ---------- */
  (function stickyHeader() {
    var bar = $('#dragon-bar');
    var spacer = $('#dragon-header-spacer');
    if (!bar || !spacer) return;
    var threshold = 160;
    function onScroll() {
      if (window.scrollY > threshold) {
        if (!bar.classList.contains('is-stuck')) {
          spacer.style.height = bar.offsetHeight + 'px';
          bar.classList.add('is-stuck');
          spacer.classList.add('is-active');
        }
      } else {
        bar.classList.remove('is-stuck');
        spacer.classList.remove('is-active');
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  })();

  /* ---------- Desktop mega menu (hover + keyboard) ---------- */
  (function megaMenu() {
    var items = $all('.dragon-has-mega');
    items.forEach(function (li) {
      var link = $('a[aria-haspopup]', li);
      var closeTimer;
      function open() { clearTimeout(closeTimer); li.classList.add('is-open'); if (link) link.setAttribute('aria-expanded', 'true'); }
      function close() { li.classList.remove('is-open'); if (link) link.setAttribute('aria-expanded', 'false'); }
      on(li, 'mouseenter', open);
      on(li, 'mouseleave', function () { closeTimer = setTimeout(close, 150); });
      on(link, 'focus', open);
      on(li, 'focusout', function (e) { if (!li.contains(e.relatedTarget)) close(); });
      on(link, 'keydown', function (e) {
        if (e.key === 'Escape') { close(); link.focus(); }
      });
    });
    on(doc, 'keydown', function (e) {
      if (e.key === 'Escape') items.forEach(function (li) { li.classList.remove('is-open'); var l = $('a[aria-haspopup]', li); if (l) l.setAttribute('aria-expanded', 'false'); });
    });
  })();

  /* ---------- Off-canvas mobile menu ---------- */
  (function offcanvas() {
    var burger = $('#dragon-burger');
    var panel = $('#dragon-offcanvas');
    var overlay = $('#dragon-overlay');
    var closeBtn = $('#dragon-offcanvas-close');
    if (!burger || !panel || !overlay) return;
    function open() {
      panel.classList.add('is-open'); overlay.hidden = false;
      requestAnimationFrame(function () { overlay.classList.add('is-open'); });
      panel.setAttribute('aria-hidden', 'false'); burger.setAttribute('aria-expanded', 'true');
      doc.body.classList.add('dragon-menu-open');
      var first = $('a, button', panel); if (first) first.focus();
    }
    function close() {
      panel.classList.remove('is-open'); overlay.classList.remove('is-open');
      panel.setAttribute('aria-hidden', 'true'); burger.setAttribute('aria-expanded', 'false');
      doc.body.classList.remove('dragon-menu-open');
      setTimeout(function () { overlay.hidden = true; }, 280);
      burger.focus();
    }
    on(burger, 'click', open);
    on(closeBtn, 'click', close);
    on(overlay, 'click', close);
    on(doc, 'keydown', function (e) { if (e.key === 'Escape' && panel.classList.contains('is-open')) close(); });
    $all('[data-dragon-close-menu]', panel).forEach(function (a) { on(a, 'click', close); });
    // Collapsible submenus for the WordPress menu (inject a caret toggle next to
    // each parent link; the link itself still navigates).
    var caretSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>';
    $all('.dragon-offcanvas__nav .menu-item-has-children', panel).forEach(function (li) {
      var sub = li.querySelector(':scope > .sub-menu');
      if (!sub) return;
      var btn = doc.createElement('button');
      btn.type = 'button';
      btn.className = 'dragon-oc-caret';
      btn.setAttribute('aria-expanded', 'false');
      btn.setAttribute('aria-label', 'Mở rộng danh mục con');
      btn.innerHTML = caretSvg;
      li.insertBefore(btn, sub);
      on(btn, 'click', function () {
        var open = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', String(!open));
        sub.classList.toggle('is-open', !open);
      });
    });
    // Legacy hardcoded toggles (fallback markup).
    $all('.dragon-offcanvas__toggle', panel).forEach(function (btn) {
      on(btn, 'click', function () {
        var sub = doc.getElementById(btn.getAttribute('aria-controls'));
        var open = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', String(!open));
        if (sub) sub.classList.toggle('is-open', !open);
      });
    });
  })();

  /* ---------- Hero slider ---------- */
  (function slider() {
    var root = $('[data-dragon-slider]');
    if (!root) return;
    var slides = $all('.dragon-hero__slide', root);
    var dots = $all('[data-dragon-dot]', root);
    var pauseBtn = $('[data-dragon-pause]', root);
    if (slides.length < 2) { if (pauseBtn) pauseBtn.style.display = 'none'; return; }
    var index = 0, timer = null, playing = !reduceMotion;
    var DELAY = 6000;

    function show(i) {
      slides.forEach(function (s, n) {
        var active = n === i;
        s.classList.toggle('is-active', active);
        if (active) { s.removeAttribute('aria-hidden'); } else { s.setAttribute('aria-hidden', 'true'); }
      });
      dots.forEach(function (d, n) {
        d.classList.toggle('is-active', n === i);
        d.setAttribute('aria-selected', String(n === i));
      });
      index = i;
    }
    function next() { show((index + 1) % slides.length); }
    function start() { if (!playing) return; stop(); timer = setInterval(next, DELAY); }
    function stop() { if (timer) { clearInterval(timer); timer = null; } }
    function setPlaying(p) {
      playing = p;
      if (pauseBtn) {
        pauseBtn.setAttribute('aria-label', p ? 'Tạm dừng trình chiếu' : 'Tiếp tục trình chiếu');
        pauseBtn.innerHTML = p
          ? '<svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><rect x="6" y="5" width="4" height="14" fill="currentColor"/><rect x="14" y="5" width="4" height="14" fill="currentColor"/></svg>'
          : '<svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 5l12 7-12 7z" fill="currentColor"/></svg>';
      }
      if (p) start(); else stop();
    }

    dots.forEach(function (d) {
      on(d, 'click', function () { show(parseInt(d.getAttribute('data-dragon-dot'), 10)); if (playing) start(); });
    });
    on(pauseBtn, 'click', function () { setPlaying(!playing); });
    on(root, 'mouseenter', stop);
    on(root, 'mouseleave', function () { if (playing) start(); });
    on(root, 'focusin', stop);
    on(root, 'focusout', function () { if (playing) start(); });
    doc.addEventListener('visibilitychange', function () { if (doc.hidden) stop(); else if (playing) start(); });

    setPlaying(!reduceMotion);
    show(0);
  })();

  /* ---------- FAQ accordion ---------- */
  (function faq() {
    $all('.dragon-faq__q').forEach(function (btn) {
      on(btn, 'click', function () {
        var panel = doc.getElementById(btn.getAttribute('aria-controls'));
        var open = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', String(!open));
        if (panel) panel.hidden = open;
      });
    });
  })();

  /* ---------- Problem selector → form ---------- */
  (function problems() {
    var map = { 'hinh-su': 'hinh-su', 'dat-dai': 'dat-dai', 'hon-nhan': 'hon-nhan', 'doanh-nghiep': 'doanh-nghiep', 'hop-dong': 'hop-dong', 'dan-su': 'dan-su' };
    $all('[data-dragon-problem]').forEach(function (btn) {
      on(btn, 'click', function () {
        var key = btn.getAttribute('data-dragon-problem');
        var select = $('#dragon-area');
        if (select) {
          var val = map[key] || 'khac';
          if ($('option[value="' + val + '"]', select)) select.value = val;
        }
        var form = $('#dragon-consultation');
        if (form) form.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
        var nameField = $('#dragon-name');
        if (nameField) setTimeout(function () { nameField.focus(); }, reduceMotion ? 0 : 500);
      });
    });
  })();

  /* ---------- Legal-knowledge category tabs (client-side filter) ---------- */
  (function legalTabs() {
    var root = $('#dragon-legal');
    if (!root) return;
    var tabs = $all('.dragon-tabs[role="tablist"] .dragon-tab', root);
    var grid = $('#dragon-legal-grid', root);
    if (!tabs.length || !grid) return;
    var cards = $all('.dragon-postcard', grid);
    var empty = $('#dragon-legal-empty', root);

    function apply(filter) {
      var shown = 0;
      cards.forEach(function (card) {
        var cats = (card.getAttribute('data-cats') || '').split(/\s+/);
        var match = filter === '*' || cats.indexOf(filter) > -1;
        card.hidden = !match;
        if (match) shown++;
      });
      if (empty) empty.hidden = shown !== 0;
    }

    tabs.forEach(function (tab) {
      on(tab, 'click', function () {
        tabs.forEach(function (t) { t.setAttribute('aria-selected', 'false'); });
        tab.setAttribute('aria-selected', 'true');
        apply(tab.getAttribute('data-filter'));
      });
    });
  })();

  /* ---------- YouTube facade (Video / Truyền hình) ---------- */
  (function videoFacade() {
    $all('.vs-video__frame').forEach(function (btn) {
      on(btn, 'click', function () {
        var id = btn.getAttribute('data-yt');
        if (!id) return;
        var ifr = doc.createElement('iframe');
        ifr.className = 'vs-video__iframe';
        ifr.src = 'https://www.youtube.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0';
        ifr.title = btn.getAttribute('aria-label') || 'Video';
        ifr.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
        ifr.setAttribute('allowfullscreen', '');
        ifr.setAttribute('loading', 'lazy');
        btn.replaceWith(ifr);
      });
    });
  })();

  /* ---------- Consultation form (AJAX) ---------- */
  (function consultForm() {
    var form = $('#dragon-consult-form');
    if (!form || !window.DragonAjax) return;
    var status = $('#dragon-form-status');
    var submit = $('button[type="submit"]', form);
    on(form, 'submit', function (e) {
      e.preventDefault();
      status.className = 'dragon-form__status';
      status.textContent = '';
      if (!form.checkValidity()) { form.reportValidity(); return; }
      submit.classList.add('is-loading');
      var data = new FormData(form);
      data.append('action', 'dragon_consultation');
      fetch(DragonAjax.url, { method: 'POST', body: data, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          submit.classList.remove('is-loading');
          status.textContent = res.message;
          status.classList.add(res.success ? 'is-ok' : 'is-err');
          if (res.success) { form.reset(); status.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' }); }
        })
        .catch(function () {
          submit.classList.remove('is-loading');
          status.textContent = 'Có lỗi kết nối. Vui lòng thử lại hoặc gọi điện cho chúng tôi.';
          status.classList.add('is-err');
        });
    });
    // Reflect no-JS fallback redirect result.
    var params = new URLSearchParams(window.location.search);
    if (params.get('dragon_sent') === '1') { status.textContent = 'Cảm ơn bạn! Yêu cầu đã được gửi.'; status.classList.add('is-ok'); }
  })();

  /* ---------- Reveal on scroll ---------- */
  (function reveal() {
    var els = $all('.dragon-reveal');
    if (!els.length) return;
    if (reduceMotion || !('IntersectionObserver' in window)) {
      els.forEach(function (el) { el.classList.add('is-visible'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });
    els.forEach(function (el) { io.observe(el); });
  })();

})();
