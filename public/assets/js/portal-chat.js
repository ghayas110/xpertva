/* Operator side of the website chat: polls the open thread and the sidebar,
   sends replies, and raises an OS notification when a visitor writes in
   while the operator is looking at another tab. */
(function () {
  'use strict';

  var console_ = document.getElementById('chat-console');
  var thread   = document.getElementById('chat-thread');
  if (!console_ || !thread) return;

  var log       = document.getElementById('chat-log');
  var form      = document.getElementById('chat-reply-form');
  var input     = document.getElementById('chat-reply');
  var sendBtn   = document.getElementById('chat-reply-send');
  var resolve   = document.getElementById('chat-resolve');
  var threadsEl = document.getElementById('chat-threads');
  var totalEl   = document.getElementById('chat-unread-total');

  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
  var messagesUrl = thread.dataset.messagesUrl;
  var replyUrl    = thread.dataset.replyUrl;
  var closeUrl    = thread.dataset.closeUrl;
  var lastId = 0;

  // Seed lastId from what the server already rendered.
  if (log) {
    var rendered = log.querySelectorAll('[data-mid]');
    if (rendered.length) lastId = parseInt(rendered[rendered.length - 1].dataset.mid, 10) || 0;
  }

  function headers(json) {
    var h = { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' };
    if (json) h['Content-Type'] = 'application/json';
    return h;
  }

  function esc(el, text) { el.textContent = text; return el; }

  function bubble(m) {
    var row = document.createElement('div');
    row.dataset.mid = m.id;
    row.className = 'flex ' + (m.sender === 'agent' ? 'justify-end'
                    : (m.sender === 'system' ? 'justify-center' : 'justify-start'));

    if (m.sender === 'system') {
      var sys = document.createElement('p');
      sys.className = 'text-xs text-slate-400 text-center max-w-md';
      esc(sys, m.body);
      row.appendChild(sys);
      return row;
    }

    var box = document.createElement('div');
    box.className = 'max-w-[75%] rounded-2xl px-4 py-2.5 ' +
      (m.sender === 'agent'
        ? 'bg-indigo-600 text-white rounded-br-sm'
        : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-100 rounded-bl-sm');

    var p = document.createElement('p');
    p.className = 'text-sm whitespace-pre-wrap break-words';
    esc(p, m.body);

    var meta = document.createElement('p');
    meta.className = 'text-[10px] mt-1 ' + (m.sender === 'agent' ? 'text-indigo-200' : 'text-slate-400');
    esc(meta, (m.author ? m.author + ' · ' : '') + (m.time || ''));

    box.appendChild(p);
    box.appendChild(meta);
    row.appendChild(box);
    return row;
  }

  function atBottom() {
    return log.scrollHeight - log.scrollTop - log.clientHeight < 80;
  }

  function notify(m) {
    if (document.visibilityState === 'visible') return;
    if (!('Notification' in window) || Notification.permission !== 'granted') return;
    try {
      new Notification('Website chat', { body: m.body.slice(0, 120), tag: 'xv-chat' });
    } catch (e) { /* some browsers block constructing these outside a SW */ }
  }

  function pollThread() {
    if (!messagesUrl) return;
    fetch(messagesUrl + '?after=' + lastId, { headers: headers(false) })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(r); })
      .then(function (data) {
        var stick = atBottom();
        (data.messages || []).forEach(function (m) {
          if (m.id <= lastId) return;
          lastId = m.id;
          log.appendChild(bubble(m));
          if (m.sender === 'visitor') notify(m);
        });
        if (stick) log.scrollTop = log.scrollHeight;
      })
      .catch(function () { /* transient; next tick retries */ });
  }

  function pollThreads() {
    var url = console_.dataset.threadsUrl;
    if (!url) return;
    fetch(url, { headers: headers(false) })
      .then(function (r) { return r.ok ? r.json() : Promise.reject(r); })
      .then(function (data) {
        if (totalEl) {
          totalEl.textContent = data.total_unread;
          totalEl.classList.toggle('hidden', !data.total_unread);
        }
        var badge = document.getElementById('nav-chat-unread');
        if (badge) {
          badge.textContent = data.total_unread;
          badge.classList.toggle('hidden', !data.total_unread);
        }
      })
      .catch(function () {});
  }

  if (form) {
    var autosize = function () {
      input.style.height = 'auto';
      input.style.height = Math.min(input.scrollHeight, 128) + 'px';
    };
    input.addEventListener('input', autosize);
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); form.requestSubmit(); }
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var text = input.value.trim();
      if (!text || !replyUrl) return;
      sendBtn.disabled = true;
      fetch(replyUrl, { method: 'POST', headers: headers(true), body: JSON.stringify({ message: text }) })
        .then(function (r) { return r.ok ? r.json() : Promise.reject(r); })
        .then(function (data) {
          input.value = '';
          autosize();
          if (data.message && data.message.id > lastId) {
            lastId = data.message.id;
            log.appendChild(bubble(data.message));
            log.scrollTop = log.scrollHeight;
          }
        })
        .catch(function () { alert('That reply did not send. Check your connection and try again.'); })
        .finally(function () { sendBtn.disabled = false; input.focus(); });
    });
  }

  if (resolve && closeUrl) {
    resolve.addEventListener('click', function () {
      resolve.disabled = true;
      fetch(closeUrl, { method: 'POST', headers: headers(true) })
        .then(function (r) { return r.ok ? r.json() : Promise.reject(r); })
        .then(function () { resolve.textContent = 'Resolved'; pollThread(); pollThreads(); })
        .catch(function () { resolve.disabled = false; });
    });
  }

  if (log) log.scrollTop = log.scrollHeight;

  setInterval(pollThread, 5000);
  setInterval(pollThreads, 10000);
  pollThreads();
})();
