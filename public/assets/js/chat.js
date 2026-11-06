/* XpertVA website chat widget.
   The visitor is anonymous. Their conversation token lives in localStorage so a
   refresh keeps the thread; the token is the only credential, so it is never
   put in a URL that might end up in a referrer or a log. */
(function () {
  'use strict';

  var root = document.getElementById('chat-widget');
  if (!root) return;

  var STORE = 'xv-chat-token';
  var panel   = document.getElementById('chat-panel');
  var toggle  = document.getElementById('chat-toggle');
  var closeEl = document.getElementById('chat-close');
  var body    = document.getElementById('chat-body');
  var form    = document.getElementById('chat-form');
  var input   = document.getElementById('chat-input');
  var send    = document.getElementById('chat-send');
  var intro   = document.getElementById('chat-intro');
  var quick   = document.getElementById('chat-quick');
  var errEl   = document.getElementById('chat-err');
  var dot     = document.getElementById('chat-dot');
  var iconOpen  = root.querySelector('.chat__bubble-open');
  var iconClose = root.querySelector('.chat__bubble-close');
  var wa      = document.getElementById('chat-wa');

  var startUrl = root.dataset.start;
  var token    = null;
  var lastId   = 0;
  var timer    = null;
  var open     = false;

  wa.href = root.dataset.wa;

  try { token = localStorage.getItem(STORE); } catch (e) { token = null; }

  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

  /* Pull a fresh token from the server. Covers two real cases: the page HTML
     went stale while the tab sat open, and the meta tag is missing entirely
     because an older layout is still deployed. */
  function refreshToken() {
    return fetch('/chat/token', {
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      credentials: 'same-origin',
      cache: 'no-store'
    })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(r); })
      .then(function (d) {
        if (d && d.token) {
          csrf = d.token;
          var meta = document.querySelector('meta[name="csrf-token"]');
          if (meta) meta.content = csrf;
        }
        return csrf;
      });
  }

  function rawPost(url, payload) {
    return fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'X-Requested-With': 'XMLHttpRequest'
      },
      credentials: 'same-origin',
      body: JSON.stringify(payload)
    });
  }

  /* One automatic retry with a fresh token if the session rejected this one. */
  function post(url, payload) {
    var attempt = function () {
      return rawPost(url, payload).then(function (r) {
        if (r.status === 419) {
          return refreshToken().then(function () {
            return rawPost(url, payload).then(readJson);
          });
        }
        return readJson(r);
      });
    };
    return csrf ? attempt() : refreshToken().then(attempt);
  }

  function readJson(r) {
    return r.json().catch(function () { return {}; }).then(function (data) {
      if (!r.ok) {
        var msg = data && data.message ? data.message : 'Something went wrong. Please try again.';
        if (r.status === 429) msg = 'That is a lot of messages at once. Give it a moment.';
        if (r.status === 419) msg = 'Your session expired. Please send that again.';
        if (r.status === 404) { forget(); msg = 'That conversation expired. Send your message again to start a new one.'; }
        throw new Error(msg);
      }
      return data;
    });
  }

  function forget() {
    token = null; lastId = 0;
    try { localStorage.removeItem(STORE); } catch (e) {}
  }

  function showError(message) {
    errEl.textContent = message;
    errEl.hidden = false;
    setTimeout(function () { errEl.hidden = true; }, 6000);
  }

  function atBottom() {
    return body.scrollHeight - body.scrollTop - body.clientHeight < 60;
  }

  function scrollDown() { body.scrollTop = body.scrollHeight; }

  /* textContent everywhere: message bodies are visitor and operator input. */
  function render(m) {
    if (m.id && m.id <= lastId) return;
    if (m.id) lastId = m.id;

    var el = document.createElement('div');
    el.className = 'chat__msg chat__msg--' +
      (m.sender === 'visitor' ? 'me' : (m.sender === 'system' ? 'sys' : 'them'));

    var p = document.createElement('p');
    p.textContent = m.body;
    el.appendChild(p);

    if (m.sender !== 'system') {
      var meta = document.createElement('span');
      meta.className = 'chat__meta';
      meta.textContent = (m.author ? m.author + ' · ' : '') + (m.time || '');
      el.appendChild(meta);
    }

    var stick = atBottom();
    body.appendChild(el);
    if (stick || m.sender === 'visitor') scrollDown();

    if (!open && m.sender !== 'visitor') dot.hidden = false;
  }

  function typing(on) {
    var existing = body.querySelector('.chat__typing');
    if (on) {
      if (existing) return;
      var t = document.createElement('div');
      t.className = 'chat__typing';
      t.innerHTML = '<i></i><i></i><i></i>';
      body.appendChild(t);
      scrollDown();
    } else if (existing) {
      existing.remove();
    }
  }

  function poll() {
    if (!token) return;
    fetch('/chat/' + encodeURIComponent(token) + '/poll?after=' + lastId, {
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(readJson)
      .then(function (data) { (data.messages || []).forEach(render); })
      .catch(function () { /* transient network trouble; the next tick retries */ });
  }

  function startPolling() {
    stopPolling();
    if (token) timer = setInterval(poll, 5000);
  }
  function stopPolling() { if (timer) { clearInterval(timer); timer = null; } }

  function setOpen(next) {
    open = next;
    panel.hidden = !open;
    toggle.setAttribute('aria-expanded', String(open));
    iconOpen.hidden = open;
    iconClose.hidden = !open;
    if (open) {
      dot.hidden = true;
      scrollDown();
      input.focus();
      poll();
      startPolling();
    } else {
      // Closed: check far less often, just enough for the unread dot.
      stopPolling();
      if (token) timer = setInterval(poll, 45000);
    }
  }

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      stopPolling();
    } else if (token) {
      poll();
      if (open) startPolling();
      else timer = setInterval(poll, 45000);
    }
  });

  toggle.addEventListener('click', function () { setOpen(!open); });
  closeEl.addEventListener('click', function () { setOpen(false); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && open) setOpen(false);
  });

  quick.addEventListener('click', function (e) {
    var b = e.target.closest('button[data-q]');
    if (!b) return;
    input.value = b.getAttribute('data-q');
    input.focus();
    autosize();
  });

  function autosize() {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 112) + 'px';
  }
  input.addEventListener('input', autosize);

  // Enter sends, Shift+Enter makes a new line.
  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      form.requestSubmit();
    }
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var text = input.value.trim();
    if (!text) return;

    send.disabled = true;
    input.value = '';
    autosize();
    render({ sender: 'visitor', body: text, time: '' });
    typing(true);

    var done = function () { send.disabled = false; typing(false); };

    if (!token) {
      var name  = (document.getElementById('chat-name')  || {}).value || '';
      var email = (document.getElementById('chat-email') || {}).value || '';
      post(startUrl, {
        name: name.trim() || null,
        email: email.trim() || null,
        message: text,
        page: location.pathname
      }).then(function (data) {
        token = data.token;
        try { localStorage.setItem(STORE, token); } catch (err) {}
        body.innerHTML = '';
        lastId = 0;
        (data.messages || []).forEach(render);
        if (intro) intro.hidden = true;
        if (quick) quick.hidden = true;
        startPolling();
        done();
      }).catch(function (err) { showError(err.message); done(); });
      return;
    }

    post('/chat/' + encodeURIComponent(token) + '/send', { message: text })
      .then(function (data) {
        if (data.message && data.message.id) lastId = Math.max(lastId, data.message.id);
        done();
        poll();
      })
      .catch(function (err) { showError(err.message); done(); });
  });

  // Returning visitor: pull the thread so the widget opens where they left off.
  if (token) {
    if (intro) intro.hidden = true;
    if (quick) quick.hidden = true;
    fetch('/chat/' + encodeURIComponent(token) + '/poll?after=0', {
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(readJson)
      .then(function (data) {
        if (!data.messages || !data.messages.length) return;
        body.innerHTML = '';
        data.messages.forEach(render);
        startPolling();
      })
      .catch(function () { forget(); });
    timer = setInterval(poll, 45000);
  }
})();
