/* XpertVA public site: motion + interaction layer.
   Every animation here is motivated: reveals establish reading order,
   the pan turns three case studies into one horizontal story,
   counters give the proof numbers weight, previews respond to intent. */
(function () {
  'use strict';

  var root = document.documentElement;
  root.classList.remove('no-js');

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var hasGSAP = typeof window.gsap !== 'undefined';
  var gsap = window.gsap;

  if (hasGSAP && window.ScrollTrigger) gsap.registerPlugin(window.ScrollTrigger);
  if (!hasGSAP || REDUCED) root.classList.add('no-motion');
  root.classList.add('is-ready');

  /* Smooth scrolling. Motivated: the pinned case pan and the parallax band both
     read as one continuous movement instead of a stack of discrete jumps.
     Disabled entirely under reduced motion so the native scroll takes over. */
  var lenis = null;
  if (typeof window.Lenis === 'function' && hasGSAP && !REDUCED) {
    lenis = new window.Lenis({ duration: 1.05, smoothWheel: true, touchMultiplier: 1.6 });
    lenis.on('scroll', function () {
      if (window.ScrollTrigger) window.ScrollTrigger.update();
    });
    gsap.ticker.add(function (time) { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);
  }

  /* In page anchors need to go through Lenis once it owns the scroll position. */
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a[href^="#"]');
    if (!a) return;
    var id = a.getAttribute('href');
    if (!id || id === '#') return;
    var target = document.querySelector(id);
    if (!target) return;
    e.preventDefault();
    if (lenis) lenis.scrollTo(target, { offset: -90 });
    else target.scrollIntoView({ behavior: REDUCED ? 'auto' : 'smooth' });
  });

  var on = function (el, ev, fn, opts) { if (el) el.addEventListener(ev, fn, opts); };
  var all = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };

  /* ---------------------------------------------------------------- header */
  (function header() {
    var head = document.querySelector('.site-head');
    if (!head) return;
    var sentinel = document.createElement('div');
    sentinel.setAttribute('aria-hidden', 'true');
    sentinel.style.cssText = 'position:absolute;top:0;left:0;width:1px;height:8px;pointer-events:none';
    document.body.prepend(sentinel);
    new IntersectionObserver(function (entries) {
      head.classList.toggle('is-stuck', !entries[0].isIntersecting);
    }).observe(sentinel);
  })();

  /* ------------------------------------------------------- overlay + modals */
  function makePanel(el) {
    if (!el) return null;
    var lastFocus = null;
    function open() {
      lastFocus = document.activeElement;
      el.classList.add('is-open');
      el.removeAttribute('aria-hidden');
      document.body.style.overflow = 'hidden';
      if (lenis) lenis.stop();
      var f = el.querySelector('a, button, input, textarea');
      if (f) f.focus();
    }
    function close() {
      el.classList.remove('is-open');
      el.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      if (lenis) lenis.start();
      if (lastFocus) lastFocus.focus();
    }
    on(el, 'keydown', function (e) {
      if (e.key === 'Escape') { close(); return; }
      if (e.key !== 'Tab') return;
      var items = all('a[href], button:not([disabled]), input, textarea, select', el)
        .filter(function (n) { return n.offsetParent !== null; });
      if (!items.length) return;
      var first = items[0], last = items[items.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });
    all('[data-close]', el).forEach(function (b) { on(b, 'click', close); });
    on(el, 'click', function (e) { if (e.target === el) close(); });
    return { open: open, close: close };
  }

  var panels = {};
  all('[data-panel]').forEach(function (el) { panels[el.getAttribute('data-panel')] = makePanel(el); });
  all('[data-open]').forEach(function (btn) {
    on(btn, 'click', function (e) {
      e.preventDefault();
      var p = panels[btn.getAttribute('data-open')];
      if (p) p.open();
    });
  });
  // Close the nav overlay when a link inside it is followed.
  all('.overlay a[href]').forEach(function (a) {
    on(a, 'click', function () { var p = panels['menu']; if (p) p.close(); });
  });

  /* --------------------------------------------------------------- marquee */
  all('.marquee__track').forEach(function (track) {
    if (REDUCED || track.dataset.cloned) return;
    track.dataset.cloned = '1';
    track.innerHTML += track.innerHTML; // second copy makes the -50% loop seamless
  });

  /* ------------------------------------------------------- hero line reveal */
  if (hasGSAP && !REDUCED) {
    var lines = all('.reveal-line > span');
    if (lines.length) {
      gsap.set(lines, { yPercent: 115 });
      gsap.to(lines, { yPercent: 0, duration: 1.1, ease: 'expo.out', stagger: 0.08, delay: 0.1 });
    }
    var heroBits = all('[data-hero-in]');
    if (heroBits.length) {
      gsap.fromTo(heroBits,
        { opacity: 0, y: 18 },
        { opacity: 1, y: 0, duration: 0.9, ease: 'expo.out', stagger: 0.09, delay: 0.45 });
    }
  } else {
    all('.reveal-line > span').forEach(function (s) { s.style.transform = 'none'; });
    all('[data-hero-in]').forEach(function (s) { s.style.opacity = 1; });
  }

  /* ------------------------------------------------- heading word stagger */
  /* Motivated: headings resolve word by word, so the eye lands on the first
     phrase before the rest arrives. Skipped when motion is off. */
  function splitWords(el) {
    if (el.dataset.split) return;
    el.dataset.split = '1';
    var html = el.innerHTML;
    // Preserve explicit line breaks, split the rest on whitespace.
    var parts = html.split(/(<br\s*\/?>)/i);
    el.innerHTML = parts.map(function (chunk) {
      if (/^<br/i.test(chunk)) return chunk;
      return chunk.split(/(\s+)/).map(function (w) {
        if (!w.trim()) return w;
        return '<span class="split-word"><span>' + w + '</span></span>';
      }).join('');
    }).join('');
  }

  if (hasGSAP && window.ScrollTrigger && !REDUCED) {
    all('[data-split-heading]').forEach(function (h) {
      splitWords(h);
      var words = all('.split-word > span', h);
      gsap.set(words, { yPercent: 110 });
      gsap.to(words, {
        yPercent: 0, duration: 0.95, ease: 'expo.out', stagger: 0.045,
        scrollTrigger: { trigger: h, start: 'top 86%', once: true }
      });
    });
  }

  /* ------------------------------------------------------- media reveals */
  if (hasGSAP && window.ScrollTrigger && !REDUCED) {
    all('.reveal-media').forEach(function (box) {
      var img = box.querySelector('img, video');
      var tl = gsap.timeline({ scrollTrigger: { trigger: box, start: 'top 88%', once: true } });
      tl.to(box, { clipPath: 'inset(0 0 0% 0)', duration: 1.05, ease: 'expo.out' });
      if (img) tl.fromTo(img, { scale: 1.16 }, { scale: 1, duration: 1.4, ease: 'expo.out' }, 0);
    });
  }

  /* -------------------------------------------------------- scroll reveals */
  var animated = all('[data-anim]');
  if (hasGSAP && window.ScrollTrigger && !REDUCED) {
    animated.forEach(function (el) {
      var delay = parseFloat(el.getAttribute('data-anim-delay') || 0);
      gsap.fromTo(el,
        { opacity: 0, y: 26 },
        {
          opacity: 1, y: 0, duration: 0.85, ease: 'expo.out', delay: delay,
          scrollTrigger: { trigger: el, start: 'top 88%', once: true }
        });
    });
  } else {
    animated.forEach(function (el) { el.classList.add('is-in'); el.style.opacity = 1; });
  }

  /* -------------------------------------------------------------- counters */
  (function counters() {
    var els = all('[data-count]');
    if (!els.length) return;
    var run = function (el) {
      var target = parseFloat(el.getAttribute('data-count'));
      var decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
      var prefix = el.getAttribute('data-prefix') || '';
      var suffix = el.getAttribute('data-suffix') || '';
      var fmt = function (v) {
        return prefix + v.toLocaleString('en-US', {
          minimumFractionDigits: decimals, maximumFractionDigits: decimals
        }) + suffix;
      };
      if (REDUCED || !hasGSAP) { el.textContent = fmt(target); return; }
      el.textContent = fmt(0);
      var obj = { v: 0 };
      gsap.to(obj, {
        v: target, duration: 1.6, ease: 'expo.out',
        onUpdate: function () { el.textContent = fmt(obj.v); }
      });
    };
    var io = new IntersectionObserver(function (entries, o) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        run(en.target); o.unobserve(en.target);
      });
    }, { threshold: 0.4 });
    els.forEach(function (el) { io.observe(el); });
  })();

  /* ------------------------------------------- capability index previews */
  (function capIndex() {
    var wrap = document.querySelector('[data-cindex]');
    if (!wrap) return;
    var rows = all('[data-cindex-key]', wrap);
    var imgs = all('[data-cindex-img]', wrap);
    if (!rows.length || !imgs.length) return;
    var show = function (key) {
      imgs.forEach(function (img) {
        img.classList.toggle('is-active', img.getAttribute('data-cindex-img') === key);
      });
    };
    show(rows[0].getAttribute('data-cindex-key'));
    rows.forEach(function (row) {
      var key = row.getAttribute('data-cindex-key');
      on(row, 'mouseenter', function () { show(key); });
      on(row, 'focus', function () { show(key); });
    });
  })();

  /* ------------------------------------------------- horizontal case pan */
  (function pan() {
    var section = document.querySelector('[data-pan]');
    if (!section) return;
    var track = section.querySelector('.pan__track');
    if (!track) return;

    if (!hasGSAP || !window.ScrollTrigger || REDUCED) {
      section.classList.add('pan--static');
      return;
    }
    var mm = gsap.matchMedia();
    mm.add('(min-width: 1024px) and (prefers-reduced-motion: no-preference)', function () {
      section.classList.remove('pan--static');
      var distance = function () { return track.scrollWidth - window.innerWidth; };
      var tween = gsap.to(track, {
        x: function () { return -distance(); },
        ease: 'none',
        scrollTrigger: {
          trigger: section,
          start: 'top top',
          end: function () { return '+=' + distance(); },
          pin: true,
          scrub: 1,
          invalidateOnRefresh: true
        }
      });
      return function () { tween.scrollTrigger && tween.scrollTrigger.kill(); tween.kill(); };
    });
    mm.add('(max-width: 1023px)', function () {
      section.classList.add('pan--static');
    });
  })();

  /* ------------------------------------------------------------- parallax */
  /* Slow drift on band photography. Motivated: it separates two dense text
     sections and signals that the page is still moving under the reader. */
  (function parallax() {
    var bands = all('[data-parallax]');
    if (!bands.length || !hasGSAP || !window.ScrollTrigger || REDUCED) return;
    bands.forEach(function (band) {
      var img = band.querySelector('img');
      if (!img) return;
      gsap.fromTo(img,
        { yPercent: -8, scale: 1.12 },
        {
          yPercent: 8, scale: 1.12, ease: 'none',
          scrollTrigger: { trigger: band, start: 'top bottom', end: 'bottom top', scrub: true }
        });
    });
  })();

  /* ------------------------------------------------------ masonry balance */
  /* CSS multi column fills top to bottom and leaves the three columns ending at
     wildly different heights. This distributes tiles into real columns, always
     into whichever column is currently shortest, so they finish close to level.
     Heights come from each tile's declared --ar, so no image needs to load first. */
  var masonry = (function () {
    var grid = document.querySelector('.masonry');
    if (!grid) return null;

    var tiles = all('.tile', grid);
    if (!tiles.length) return null;

    // Keep the original order so filtering and re-layout stay deterministic.
    tiles.forEach(function (t, i) { t.dataset.order = i; });

    var colCount = function () {
      var w = window.innerWidth;
      return w >= 1100 ? 3 : (w >= 700 ? 2 : 1);
    };

    var current = 0;

    function layout() {
      var n = colCount();
      var visible = tiles.filter(function (t) { return !t.classList.contains('is-hidden'); });

      if (n === 1) {
        grid.classList.remove('is-balanced');
        all('.masonry__col', grid).forEach(function (c) { c.remove(); });
        visible.sort(function (a, b) { return a.dataset.order - b.dataset.order; })
               .forEach(function (t) { grid.appendChild(t); });
        current = 1;
        return;
      }

      var cols = [];
      var heights = [];
      var frag = document.createDocumentFragment();
      for (var i = 0; i < n; i++) {
        var col = document.createElement('div');
        col.className = 'masonry__col';
        cols.push(col);
        heights.push(0);
        frag.appendChild(col);
      }

      // Column width only matters as a shared scale factor, so relative
      // ratios are enough to decide placement.
      visible.sort(function (a, b) { return a.dataset.order - b.dataset.order; })
        .forEach(function (tile) {
          var ar = parseFloat(getComputedStyle(tile).getPropertyValue('--ar')) || 1;
          var shortest = heights.indexOf(Math.min.apply(null, heights));
          cols[shortest].appendChild(tile);
          heights[shortest] += ar;
        });

      all('.masonry__col', grid).forEach(function (c) { c.remove(); });
      grid.appendChild(frag);
      grid.classList.add('is-balanced');
      current = n;

      // Greedy packing lands within a few percent. This last pass lets the
      // bottom tile of each short column absorb the remainder, so all three
      // columns finish exactly level.
      requestAnimationFrame(function () {
        cols.forEach(function (c) {
          c.style.minHeight = '';
          if (c.lastElementChild) c.lastElementChild.style.flexGrow = '';
        });
        var tallest = Math.max.apply(null, cols.map(function (c) {
          return c.getBoundingClientRect().height;
        }));
        if (!isFinite(tallest) || tallest <= 0) return;
        cols.forEach(function (c) {
          if (!c.lastElementChild) return;
          c.style.minHeight = tallest + 'px';
          c.lastElementChild.style.flexGrow = '1';
        });
        if (window.ScrollTrigger) window.ScrollTrigger.refresh();
      });

      if (window.ScrollTrigger) window.ScrollTrigger.refresh();
    }

    layout();

    var raf;
    window.addEventListener('resize', function () {
      cancelAnimationFrame(raf);
      raf = requestAnimationFrame(function () {
        if (colCount() !== current) layout(); else layout();
      });
    });

    return { layout: layout };
  })();

  /* --------------------------------------------------------- work filters */
  (function filters() {
    var bar = document.querySelector('[data-filters]');
    if (!bar) return;
    var tiles = all('[data-cat]');
    var count = document.querySelector('[data-filter-count]');
    var empty = document.querySelector('[data-filter-empty]');

    var apply = function (cat) {
      var shown = 0;
      tiles.forEach(function (t) {
        var match = cat === 'All' || t.getAttribute('data-cat') === cat;
        t.classList.toggle('is-hidden', !match);
        if (match) shown++;
      });
      if (count) count.textContent = shown;
      if (empty) empty.hidden = shown !== 0;
      if (hasGSAP && !REDUCED) {
        gsap.fromTo(tiles.filter(function (t) { return !t.classList.contains('is-hidden'); }),
          { opacity: 0, y: 14 },
          { opacity: 1, y: 0, duration: 0.5, ease: 'expo.out', stagger: 0.015, overwrite: true });
      }
      if (masonry) masonry.layout();
      if (window.ScrollTrigger) window.ScrollTrigger.refresh();
    };

    all('.chip', bar).forEach(function (chip) {
      on(chip, 'click', function () {
        all('.chip', bar).forEach(function (c) { c.setAttribute('aria-pressed', 'false'); });
        chip.setAttribute('aria-pressed', 'true');
        apply(chip.getAttribute('data-cat-filter'));
      });
    });
    if (count) count.textContent = tiles.length;
  })();

  /* Layout shifts from late fonts and images invalidate trigger positions. */
  if (hasGSAP && window.ScrollTrigger) {
    window.addEventListener('load', function () { window.ScrollTrigger.refresh(); });
    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(function () { window.ScrollTrigger.refresh(); });
    }
  }

  /* -------------------------------------------------- reading progress bar */
  /* Motivated: on a long article this is the only signal of how much is left. */
  (function readingBar() {
    var bar = document.querySelector('[data-reading-bar] span');
    var body = document.getElementById('article-body');
    if (!bar || !body || !hasGSAP || !window.ScrollTrigger) return;
    if (REDUCED) { bar.parentNode.remove(); return; }
    window.ScrollTrigger.create({
      trigger: body,
      start: 'top 80%',
      end: 'bottom bottom',
      onUpdate: function (self) { bar.style.width = (self.progress * 100).toFixed(1) + '%'; }
    });
  })();

  /* -------------------------------------------------- form submit feedback */
  all('form[data-async-feedback]').forEach(function (form) {
    on(form, 'submit', function () {
      var btn = form.querySelector('[type="submit"]');
      if (!btn || btn.dataset.busy) return;
      btn.dataset.busy = '1';
      btn.dataset.label = btn.textContent;
      btn.textContent = 'Sending...';
      btn.disabled = true;
    });
  });
})();
