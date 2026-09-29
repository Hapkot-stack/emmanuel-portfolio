<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Emmanuel Tokpah | Software Developer')</title>
  <meta name="description" content="@yield('description','Emmanuel Tokpah — Software Developer, Information Systems Student, trading systems builder, and business technology professional in Kigali, Rwanda.')">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @vite(['resources/css/app.css'])
  @if(($sectionPreview ?? null) || ($isSectionOnlyPreview ?? false))
  <style>
    .section-only-preview .page-bg,
    .section-only-preview .nav,
    .section-only-preview .mmenu,
    .section-only-preview .footer,
    .section-only-preview .chat-root {
      display: none !important;
    }

    .section-only-preview #app>main {
      padding-top: 0 !important;
    }
  </style>
  @endif
  <script>
    (function() {
      if (localStorage.getItem('theme') === 'light')
        document.documentElement.classList.remove('dark');
      else
        document.documentElement.classList.add('dark');
    })();
  </script>
</head>

<body @class(['section-only-preview'=> ($sectionPreview ?? null) || ($isSectionOnlyPreview ?? false)])>

  <div class="page-bg"></div>

  <div id="app"
    x-data="{
    isDark: localStorage.getItem('theme')!=='light',
    sc: false,
    mo: false,
    tog(){ this.isDark=!this.isDark; localStorage.setItem('theme',this.isDark?'dark':'light'); document.documentElement.classList.toggle('dark',this.isDark); }
  }"
    x-init="window.addEventListener('scroll',()=>{ sc=window.scrollY>40; },{passive:true})">

    <!-- NAVBAR -->
    <nav class="nav" :class="sc?'scrolled':''">
      <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
          <span class="bk">&lt;</span>ET<span class="bk">/&gt;</span>
        </a>
        <div class="nav-links">
          <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home')     ?'on':'' }}">Home</a>
          <a href="{{ route('projects') }}" class="nav-link {{ request()->routeIs('projects*')?'on':'' }}">Projects</a>
          <a href="{{ route('resume') }}" class="nav-link {{ request()->routeIs('resume')   ?'on':'' }}">Resume</a>
          <a href="{{ route('cv.center') }}" class="nav-link {{ request()->routeIs('cv.*')     ?'on':'' }}">CV Center</a>
        </div>
        <div class="nav-acts">
          <button @click="tog()" class="theme-btn" title="Toggle theme">
            <svg x-show="isDark" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#facc15" stroke-width="2">
              <circle cx="12" cy="12" r="5" />
              <line x1="12" y1="1" x2="12" y2="3" />
              <line x1="12" y1="21" x2="12" y2="23" />
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
              <line x1="1" y1="12" x2="3" y2="12" />
              <line x1="21" y1="12" x2="23" y2="12" />
            </svg>
            <svg x-show="!isDark" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
          </button>
          <a href="{{ route('home') }}#contact" class="hire">Hire Me</a>
        </div>
        <button class="hbtn" @click="mo=!mo" aria-label="Menu">
          <span class="hbar" :style="mo?'transform:rotate(45deg) translate(5px,5px)':''"></span>
          <span class="hbar" :style="mo?'opacity:0':''"></span>
          <span class="hbar" :style="mo?'transform:rotate(-45deg) translate(5px,-5px)':''"></span>
        </button>
      </div>
      <div class="mmenu" :class="mo?'open':''" @click.outside="mo=false">
        <a href="{{ route('home') }}" @click="mo=false" class="mlink">Home</a>
        <a href="{{ route('projects') }}" @click="mo=false" class="mlink">Projects</a>
        <a href="{{ route('resume') }}" @click="mo=false" class="mlink">Resume</a>
        <a href="{{ route('cv.center') }}" @click="mo=false" class="mlink">CV Center</a>
        <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem .5rem .25rem;border-top:1px solid var(--bd);margin-top:.5rem">
          <button @click="tog()" class="theme-btn">
            <svg x-show="isDark" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#facc15" stroke-width="2">
              <circle cx="12" cy="12" r="5" />
              <line x1="12" y1="1" x2="12" y2="3" />
              <line x1="12" y1="21" x2="12" y2="23" />
            </svg>
            <svg x-show="!isDark" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
          </button>
          <a href="{{ route('home') }}#contact" class="hire" style="font-size:.8rem">Hire Me</a>
        </div>
      </div>
    </nav>

    <!-- CONTENT -->
    <main style="padding-top:64px">@yield('content')</main>

    <!-- FOOTER -->
    <footer class="footer">
      <div class="wrap">
        <div class="footer-in">
          <span class="flogo"><span class="bk">&lt;</span>ET<span class="bk">/&gt;</span></span>
          <p class="ftxt">Built with Laravel &bull; <strong style="color:var(--t)">Emmanuel Tokpah</strong> &copy; {{ date('Y') }}</p>
          <div class="flinks">
            <a href="{{ route('cv.center') }}" class="flink">Download CV</a>
          </div>
        </div>
      </div>
    </footer>

    <!-- BACK TO TOP -->
    <button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
      </svg>
    </button>

  </div><!-- end alpine wrapper -->

  <!-- CHAT WIDGET — pure vanilla JS -->
  <div id="chat-root" class="chat-root">
    <button id="ctog" class="chat-bub">
      <svg id="cico" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5-1-5z" />
      </svg>
      <svg id="cclx" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:none">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
      <span class="chat-ping"></span>
    </button>

    <div id="cpanel" class="chat-panel">
      <div class="chat-hd">
        <div class="chat-av">AI</div>
        <div style="flex:1;min-width:0">
          <div class="chat-htitle">Portfolio Assistant</div>
          <div class="chat-hsub">Online &bull; Ask me anything</div>
        </div>
        <button id="cxbtn" class="chat-xbtn">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div id="cmsgs" class="chat-msgs">
        <div class="mbot">
          <div class="mav">ET</div>
          <div class="bbot">Hi! 👋 I'm Emmanuel's assistant.<br>Ask about his <strong>skills</strong>, <strong>projects</strong>, or <strong>experience</strong>.</div>
        </div>
      </div>

      <div class="chat-sugg">
        <button class="sugg" data-q="Who is Emmanuel?">Who is Emmanuel?</button>
        <button class="sugg" data-q="What projects has he built?">Projects</button>
        <button class="sugg" data-q="How to download his CV?">Download CV</button>
        <button class="sugg" data-q="How to contact Emmanuel?">Contact</button>
        <button class="sugg" data-q="What are his main skills?">Skills</button>
      </div>

      <div class="chat-inp">
        <input id="cinp" type="text" placeholder="Type your question…" class="cinput">
        <button id="csnd" class="csend">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <script>
    // Back to top
    window.addEventListener('scroll', function() {
      var b = document.getElementById('btt');
      if (b) {
        if (window.scrollY > 400) b.classList.add('on');
        else b.classList.remove('on');
      }
    }, {
      passive: true
    });

    // Scroll reveal
    (function() {
      var els = document.querySelectorAll('.reveal');
      if (!('IntersectionObserver' in window)) {
        els.forEach(function(e) {
          e.classList.add('vis');
        });
        return;
      }
      var obs = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
          if (e.isIntersecting) {
            e.target.classList.add('vis');
            obs.unobserve(e.target);
          }
        });
      }, {
        threshold: 0.08,
        rootMargin: '0px 0px -20px 0px'
      });
      els.forEach(function(e) {
        obs.observe(e);
      });
    })();

    // Skill/progress bars
    (function() {
      var bars = document.querySelectorAll('.pfill[data-w],.pfill2[data-w]');
      if (!('IntersectionObserver' in window)) {
        bars.forEach(function(b) {
          b.style.width = b.dataset.w + '%';
        });
        return;
      }
      var obs = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
          if (e.isIntersecting) {
            setTimeout(function() {
              e.target.style.width = e.target.dataset.w + '%';
            }, 150);
            obs.unobserve(e.target);
          }
        });
      }, {
        threshold: 0.3
      });
      bars.forEach(function(b) {
        b.style.width = '0%';
        obs.observe(b);
      });
    })();

    // Stat counters
    (function() {
      var els = document.querySelectorAll('[data-count]');
      if (!els.length) return;
      var obs = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
          if (!e.isIntersecting) return;
          var el = e.target,
            target = parseInt(el.dataset.count),
            start = performance.now(),
            dur = 1200;

          function upd(now) {
            var p = Math.min((now - start) / dur, 1);
            el.textContent = Math.round(p * target);
            if (p < 1) requestAnimationFrame(upd);
            else el.textContent = target;
          }
          requestAnimationFrame(upd);
          obs.unobserve(el);
        });
      }, {
        threshold: 0.5
      });
      els.forEach(function(el) {
        obs.observe(el);
      });
    })();

    // Typed text
    (function() {
      var el = document.getElementById('typed');
      if (!el) return;
      var raw = el.getAttribute('data-phrases');
      var phrases;
      try {
        phrases = JSON.parse(raw);
      } catch (ex) {
        return;
      }
      if (!phrases || !phrases.length) return;
      var pi = 0,
        ci = 0,
        del = false;

      function tick() {
        var cur = phrases[pi];
        el.textContent = del ? cur.slice(0, --ci) : cur.slice(0, ++ci);
        if (!del && ci === cur.length) {
          setTimeout(function() {
            del = true;
            tick();
          }, 2000);
          return;
        }
        if (del && ci === 0) {
          del = false;
          pi = (pi + 1) % phrases.length;
        }
        setTimeout(tick, del ? 42 : 78);
      }
      setTimeout(tick, 900);
    })();

    // Chat widget
    (function() {
      var ctog = document.getElementById('ctog');
      var cxbtn = document.getElementById('cxbtn');
      var panel = document.getElementById('cpanel');
      var cico = document.getElementById('cico');
      var cclx = document.getElementById('cclx');
      var msgs = document.getElementById('cmsgs');
      var inp = document.getElementById('cinp');
      var snd = document.getElementById('csnd');
      var csrf = document.querySelector('meta[name="csrf-token"]');
      var open = false,
        busy = false;

      function openChat() {
        open = true;
        panel.style.display = 'flex';
        cico.style.display = 'none';
        cclx.style.display = 'block';
        msgs.scrollTop = msgs.scrollHeight;
        setTimeout(function() {
          inp.focus();
        }, 80);
      }

      function closeChat() {
        open = false;
        panel.style.display = 'none';
        cico.style.display = 'block';
        cclx.style.display = 'none';
      }
      ctog.addEventListener('click', function(e) {
        e.stopPropagation();
        open ? closeChat() : openChat();
      });
      cxbtn.addEventListener('click', function(e) {
        e.stopPropagation();
        closeChat();
      });
      document.addEventListener('click', function(e) {
        var root = document.getElementById('chat-root');
        if (open && root && !root.contains(e.target)) closeChat();
      });
      inp.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          doSend();
        }
      });
      snd.addEventListener('click', function(e) {
        e.stopPropagation();
        doSend();
      });
      document.querySelectorAll('.sugg').forEach(function(b) {
        b.addEventListener('click', function(e) {
          e.stopPropagation();
          sendMsg(b.dataset.q);
        });
      });

      function doSend() {
        var t = inp.value.trim();
        if (!t || busy) return;
        inp.value = '';
        sendMsg(t);
      }

      async function sendMsg(text) {
        if (!text || busy) return;
        addMsg('u', esc(text));
        showTyping();
        try {
          var r = await fetch('/chat', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf ? csrf.content : ''
            },
            body: JSON.stringify({
              message: text
            })
          });
          var d = await r.json();
          hideTyping();
          addMsg('b', d.reply || 'Sorry, I could not process that.');
        } catch (er) {
          hideTyping();
          addMsg('b', 'Connection error. Please try again.');
        }
      }

      function addMsg(role, html) {
        var row = document.createElement('div');
        if (role === 'u') {
          row.className = 'musr';
          row.innerHTML = '<div class="busr">' + html + '</div>';
        } else {
          row.className = 'mbot';
          row.innerHTML = '<div class="mav">ET</div><div class="bbot">' + html + '</div>';
        }
        msgs.appendChild(row);
        msgs.scrollTop = msgs.scrollHeight;
      }

      function showTyping() {
        busy = true;
        var row = document.createElement('div');
        row.id = 'trow';
        row.className = 'mbot';
        row.innerHTML = '<div class="mav">ET</div><div class="bbot"><div style="display:flex;gap:4px;align-items:center"><span class="tdot" style="animation-delay:0ms"></span><span class="tdot" style="animation-delay:180ms"></span><span class="tdot" style="animation-delay:360ms"></span></div></div>';
        msgs.appendChild(row);
        msgs.scrollTop = msgs.scrollHeight;
      }

      function hideTyping() {
        busy = false;
        var r = document.getElementById('trow');
        if (r) r.remove();
      }

      function esc(s) {
        return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
      }
    })();
  </script>
</body>

</html>