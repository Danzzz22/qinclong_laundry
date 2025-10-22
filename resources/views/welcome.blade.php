<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Qinclong Laundry | Premium Laundry Experience</title>

  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>

  <style>
    /* ===== Reset ringkas & guard anti scroll horizontal ===== */
    html { scroll-behavior: smooth; }
    html, body { overflow-x: hidden; }
    img { display:block; max-width:100%; height:auto; }

    /* ===== Brand / Global ===== */
    .gradient-text{
      background: linear-gradient(90deg,#FFD35B,#A8E8F9,#F5A201);
      background-size:220% 100%;
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
      animation:gt 9s ease-in-out infinite;
    }
    @keyframes gt{0%{background-position:0%}50%{background-position:100%}100%{background-position:0%}}

    .blob{position:absolute;border-radius:50%;filter:blur(80px);opacity:.55;pointer-events:none}
    .pattern{
      background-image:
        radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px),
        radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
      background-size: 26px 26px, 52px 52px; background-position:0 0,13px 13px;
    }
    .parallax{will-change: transform; transform: translate3d(0,0,0)}

    .tilt{transform:perspective(1000px) rotateX(0) rotateY(0) translateZ(0);transition:transform .25s ease, box-shadow .25s ease}
    .tilt:hover{transform:perspective(1000px) rotateX(1.2deg) rotateY(-1.2deg) translateY(-4px);box-shadow:0 22px 40px rgba(0,0,0,.14)}

    .btn-primary{
      background:linear-gradient(90deg,#F5A201,#FFBA42); color:#013C58; font-weight:800;
      transition:transform .2s ease, box-shadow .2s ease;
    }
    .btn-primary:hover{transform:translateY(-2px); box-shadow:0 16px 28px rgba(245,162,1,.28)}
    .btn-outline{border:2px solid #A8E8F9; color:#A8E8F9; font-weight:800; transition:all .2s ease}
    .btn-outline:hover{background:#A8E8F9; color:#013C58}
    .focus-ring:focus{outline:none; box-shadow:0 0 0 3px rgba(168,232,249,.65)}

    .nav-link{position:relative}
    .nav-link::after{content:"";position:absolute;left:0;bottom:-6px;height:2px;width:0;background:#FFBA42;transition:width .25s ease}
    .nav-link:hover::after{width:100%}

    .scrollbar-hide::-webkit-scrollbar{display:none}
    .scrollbar-hide{-ms-overflow-style:none;scrollbar-width:none}

    .glow-border{position:relative; border-radius:1rem; background:#fff;}
    .glow-border::before{
      content:""; position:absolute; inset:-1px; border-radius:1.05rem;
      background: conic-gradient(from 180deg at 50% 50%, #FFD35B, #A8E8F9, #F5A201, #FFD35B);
      filter: blur(12px); opacity:.65; z-index:-1;
    }
    svg.wave{display:block}

    /* ===== Our Services – efek slider & kartu ===== */
    .scroll-fade{position:absolute;top:0;bottom:0;width:70px;pointer-events:none;z-index:15}
    .scroll-fade.left{left:0;background:linear-gradient(90deg,#ffffff,rgba(255,255,255,0))}
    .scroll-fade.right{right:0;background:linear-gradient(270deg,#ffffff,rgba(255,255,255,0))}

    .service-card{position:relative;perspective:1000px;transform-style:preserve-3d}
    .service-card .spotlight{
      position:absolute;inset:0;opacity:0;transition:opacity .25s ease;pointer-events:none;
      background: radial-gradient(160px 160px at 50% 40%, rgba(1,60,88,.06), transparent 60%);
    }
    .service-card:hover .spotlight{opacity:1}
    .service-card .sheen{
      position:absolute;inset:0;pointer-events:none;
      background:linear-gradient(120deg, transparent 40%, rgba(255,255,255,.35) 50%, transparent 60%);
      transform:translateX(-120%);transition:transform .8s ease;
    }
    .service-card:hover .sheen{transform:translateX(120%)}
    .service-card .accent{
      position:absolute;left:0;bottom:-1px;height:2px;width:0;
      background:linear-gradient(90deg,#F5A201,#FFD35B,#A8E8F9);transition:width .6s ease;
    }
    .service-card:hover .accent{width:100%}

    /* ===== Testimonials – kartu kaca tipis + aksen ===== */
    .testi-card{position:relative;border-radius:1rem;background:#fff;box-shadow:0 8px 22px rgba(1,60,88,.10);transition:transform .25s ease,box-shadow .25s ease}
    .testi-card:hover{transform:translateY(-4px);box-shadow:0 18px 36px rgba(1,60,88,.16)}
    .testi-accent{height:4px;background:linear-gradient(90deg,#F5A201,#FFD35B,#A8E8F9)}

    /* ===== Location – anti “noda putih” & hover halus ===== */
    #lokasi{background:#A8E8F9;}
    .loc-card{
      position:relative;border-radius:12px;background:#fff;
      transform:perspective(900px) rotateX(0) rotateY(0) translateY(0);
      transition:transform .25s ease, box-shadow .25s ease;
    }
    .loc-card:hover{transform:translateY(-4px); box-shadow:0 24px 48px rgba(1,60,88,.18)}
    .loc-card .accent{position:absolute;left:0;top:0;height:3px;width:0;background:linear-gradient(90deg,#F5A201,#FFD35B,#A8E8F9);transition:width .5s ease}
    .loc-card:hover .accent{width:100%}
    .loc-card .shine{position:absolute;inset:-1px;pointer-events:none;opacity:0;transition:opacity .25s ease;
      background:radial-gradient(160px 160px at 50% 40%, rgba(255,255,255,.28), transparent 62%)}
    .loc-card:hover .shine{opacity:1}

    .map-frame{ position:relative; border-radius:.75rem; overflow:hidden; }
    .map-frame::before{ content:""; display:block; padding-top:56.25%; } /* 16:9 */
    .map-frame > iframe{ position:absolute; inset:0; width:100%; height:100%; border:0; }

    /* ===== Footer premium ===== */
    .footer{background:#013C58;color:#A8E8F9}
    .footer h3{color:#FFBA42;font-weight:800;margin-bottom:.75rem}
    .footer a{transition:color .2s ease}
    .footer a:hover{color:#FFD35B}
    .footer .icon{
      width:44px;height:44px;border-radius:9999px;display:inline-flex;align-items:center;justify-content:center;
      background:rgba(168,232,249,.08);border:1px solid rgba(168,232,249,.18)
    }
    .subscribe{
      display:flex;gap:.5rem;align-items:center;background:#fff;border-radius:.75rem;padding:.35rem .35rem .35rem .9rem;
      box-shadow:0 10px 26px rgba(1,60,88,.20)
    }
    .subscribe input{flex:1;min-width:0;border:0;outline:0;color:#013C58}
    .subscribe button{background:#F5A201;color:#013C58;font-weight:800;border-radius:.65rem;padding:.6rem 1rem}
    .backtop{
      position:fixed;right:1.25rem;bottom:1.25rem;width:44px;height:44px;border-radius:9999px;
      display:none;align-items:center;justify-content:center;background:#FFBA42;color:#013C58;font-weight:900;
      box-shadow:0 10px 24px rgba(245,162,1,.35);z-index:60
    }
    .backtop.show{display:flex}

    /* ========== FOOTER Animated (Pure CSS, No JS) ========== */
.footer-anim{
  position:relative;
  overflow:hidden;            /* cegah scrollbar mendatar */
  background:#013C58;         /* base color (backup) */
  isolation:isolate;          /* biar blending aman */
}

/* background dekoratif lembut yang berputar */
.footer-anim::before{
  content:"";
  position:absolute; inset:-40%;
  background:
    radial-gradient(50% 50% at 20% 20%, rgba(255,211,91,.08), transparent 60%),
    radial-gradient(40% 40% at 80% 30%, rgba(168,232,249,.10), transparent 65%),
    radial-gradient(36% 36% at 30% 80%, rgba(255,186,66,.08), transparent 62%);
  animation:footerSpin 42s linear infinite;
  z-index:0;
}
@keyframes footerSpin{ to{ transform:rotate(360deg); } }

/* garis aksen berjalan di paling atas footer */
.footer-anim::after{
  content:"";
  position:absolute; left:0; top:0; height:3px; width:100%;
  background:linear-gradient(90deg,#F5A201,#FFD35B,#A8E8F9,#F5A201);
  background-size:200% 100%;
  animation:footerAccent 6s linear infinite;
  opacity:.95;
}
@keyframes footerAccent{
  0%{background-position:0% 0}
  100%{background-position:200% 0}
}

/* judul kolom: underline muncul saat hover kolom */
.footer-col{ position:relative; }
.footer-title{ position:relative; display:inline-block; }
.footer-col:hover .footer-title::after{
  width:100%;
}
.footer-title::after{
  content:""; position:absolute; left:0; bottom:-6px; height:2px; width:0;
  background:#FFD35B; transition:width .35s ease;
}

/* tautan navigasi: underline slide + warna naik */
.nav-links a{
  position:relative; color:#A8E8F9; transition:color .2s ease;
}
.nav-links a:hover{ color:#FFD35B; }
.nav-links a::after{
  content:""; position:absolute; left:0; bottom:-4px; height:2px; width:0;
  background:#FFD35B; transition:width .25s ease;
}
.nav-links a:hover::after{ width:100%; }

/* ikon sosmed: lift + glow */
.social a{
  transition: transform .25s ease, text-shadow .25s ease, color .25s ease;
  color:#A8E8F9;
}
.social a:hover{
  transform:translateY(-4px) scale(1.06);
  color:#FFD35B;
  text-shadow:0 10px 24px rgba(255,211,91,.35);
}

/* form subscribe: input focus glow + tombol dengan sheen */
.input-subscribe{
  background:#fff; border:1px solid #e5e7eb; /* ring-gray-200 */
  transition: box-shadow .2s ease, border-color .2s ease;
}
.input-subscribe:focus{
  outline:none;
  border-color:rgba(168,232,249,.65);
  box-shadow:0 0 0 3px rgba(168,232,249,.45);
}

.btn-subscribe{
  position:relative; background:#F5A201; border:0;
  transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
}
.btn-subscribe:hover{
  transform:translateY(-1px);
  box-shadow:0 12px 24px rgba(245,162,1,.25);
  filter:saturate(1.05);
}
/* efek sapuan cahaya di tombol */
.btn-subscribe::before{
  content:""; position:absolute; inset:0; pointer-events:none;
  background:linear-gradient(120deg, transparent 35%, rgba(255,255,255,.45) 50%, transparent 65%);
  transform:translateX(-120%);
  transition:transform .85s ease;
}
.btn-subscribe:hover::before{ transform:translateX(120%); }

/* small safety: jangan biarkan elemen footer bikin scroll horizontal */
.footer-anim *{ max-width:100%; }

/* ====== Footer Content Add-ons ====== */

/* CTA bar */
.footer-cta{
  position:relative; z-index:1; margin-bottom: .5rem;
}
.cta-box{
  position:relative; border-radius: .875rem;
  background: linear-gradient(90deg, rgba(255,211,91,.18), rgba(168,232,249,.15));
  border:1px solid rgba(255,255,255,.18);
  box-shadow: 0 12px 28px rgba(0,0,0,.12), inset 0 1px 0 rgba(255,255,255,.12);
  padding-top: 1rem; padding-bottom: 1rem;
  backdrop-filter: blur(6px);
}

/* badge keunggulan */
.badge{
  display:inline-block; font-size:.75rem; line-height:1;
  padding:.45rem .6rem; border-radius:999px;
  color:#013C58; background:#FFF9E8; border:1px solid #FFE7B5;
}

/* kontak */
.contact-list .contact-item{ display:flex; gap:.6rem; align-items:flex-start; }
.contact-item i{ margin-top:.15rem; color:#FFD35B; }
.link-quiet{ color:#D7F3FB; text-decoration:none; border-bottom:1px dashed transparent; transition:.2s; }
.link-quiet:hover{ color:#FFD35B; border-bottom-color:#FFD35B; }

/* jam operasional */
.hours{ display:grid; gap:.4rem; }
.hours li{ display:flex; justify-content:space-between; font-size:.95rem; color:#E6FAFF; }
.hours li span:first-child{ color:#A8E8F9; }

/* payments */
.payments{ display:flex; align-items:center; gap:.65rem; color:#E6FAFF; opacity:.9; }
.payments i{ font-size:1.8rem; }

/* nav */
.nav-links a{
  position:relative; color:#A8E8F9; transition:color .2s ease;
}
.nav-links a:hover{ color:#FFD35B; }
.nav-links a::after{
  content:""; position:absolute; left:0; bottom:-4px; height:2px; width:0;
  background:#FFD35B; transition:width .25s ease;
}
.nav-links a:hover::after{ width:100%; }

  </style>
</head>

<body class="font-sans antialiased bg-white text-gray-800">

  <!-- NAVBAR -->
  <nav x-data="{ open:false, solid:false }"
       x-init="window.addEventListener('scroll',()=> solid = window.scrollY > 10)"
       :class="solid ? 'bg-[#013C58]/90 backdrop-blur shadow-sm' : 'bg-transparent'"
       class="fixed inset-x-0 top-0 z-50 transition-all duration-300" aria-label="Primary">
    <div class="max-w-7xl mx-auto h-16 px-6 flex items-center justify-between">
      <a href="#home" class="text-2xl font-extrabold text-[#FFD35B] tracking-wide focus-ring">Qinclong Laundry</a>

      <!-- Desktop -->
      <div class="hidden md:flex items-center gap-8 font-medium text-[#A8E8F9]">
        <a href="#home" class="nav-link hover:text-[#FFBA42] focus-ring">Home</a>
        <a href="#about" class="nav-link hover:text-[#FFBA42] focus-ring">About</a>
        <a href="#layanan" class="nav-link hover:text-[#FFBA42] focus-ring">Services</a>
        <a href="#choose" class="nav-link hover:text-[#FFBA42] focus-ring">Why Us</a>
        <a href="#testimoni" class="nav-link hover:text-[#FFBA42] focus-ring">Testimonials</a>
        <a href="#lokasi" class="nav-link hover:text-[#FFBA42] focus-ring">Location</a>
      </div>

      <!-- Right (auth / cta) -->
      <div class="hidden md:block">
        @guest
          <a href="{{ route('login') }}" class="btn-primary px-5 py-2 rounded-lg shadow focus-ring">Get Started</a>
        @endguest
        @auth
        <div x-data="{ m:false }" class="relative" @click.away="m=false">
          <button @click="m=!m" :aria-expanded="m" aria-haspopup="menu"
            class="w-10 h-10 rounded-full bg-[#FFBA42] text-[#013C58] font-bold flex items-center justify-center hover:ring-2 hover:ring-[#F5A201] focus-ring"
            title="Account">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </button>
          <div x-cloak x-show="m" x-transition class="absolute right-0 mt-3 w-48 bg-white border rounded-xl shadow-lg z-50">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
              <button type="submit" class="w-full text-left block px-4 py-2 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
        @endauth
      </div>

      <!-- Mobile toggle -->
      <button @click="open=!open" class="md:hidden text-[#A8E8F9] focus-ring" aria-label="Toggle menu">
        <i class="fa-solid fa-bars text-xl"></i>
      </button>
    </div>

    <!-- Mobile menu -->
    <div x-cloak x-show="open" x-transition class="md:hidden bg-[#013C58]/95 backdrop-blur border-t border-white/10">
      <div class="px-6 py-4 flex flex-col gap-3 text-[#A8E8F9]">
        <a @click="open=false" href="#home" class="hover:text-[#FFBA42]">Home</a>
        <a @click="open=false" href="#about" class="hover:text-[#FFBA42]">About</a>
        <a @click="open=false" href="#layanan" class="hover:text-[#FFBA42]">Services</a>
        <a @click="open=false" href="#choose" class="hover:text-[#FFBA42]">Why Us</a>
        <a @click="open=false" href="#testimoni" class="hover:text-[#FFBA42]">Testimonials</a>
        <a @click="open=false" href="#lokasi" class="hover:text-[#FFBA42]">Location</a>
        @guest
          <a href="{{ route('login') }}" class="btn-primary text-center px-5 py-2 rounded-lg mt-2">Get Started</a>
        @endguest
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section id="home" class="relative min-h-screen flex items-center justify-center text-center pt-20 overflow-hidden text-white">
    <div class="absolute inset-0 bg-gradient-to-br from-[#013C58] via-[#00537A] to-[#2E9CA0]"></div>
    <div class="absolute inset-0 pattern opacity-40"></div>

    <!-- Parallax blobs -->
    <div class="blob w-[28rem] h-[28rem] bg-[#FFD35B]/30 top-8 left-6 parallax" data-parallax-speed="0.2"></div>
    <div class="blob w-[32rem] h-[32rem] bg-[#F5A201]/25 -bottom-20 -right-10 parallax" data-parallax-speed="-0.15"></div>

    <!-- Floating icons -->
    <div class="absolute inset-0 pointer-events-none">
      <i class="fa-solid fa-shirt text-white/15 text-7xl parallax" style="top:18%; left:8%; position:absolute" data-parallax-speed="0.35"></i>
      <i class="fa-solid fa-soap text-white/15 text-6xl parallax" style="bottom:15%; left:14%; position:absolute" data-parallax-speed="-0.25"></i>
      <i class="fa-solid fa-wind text-white/15 text-6xl parallax" style="top:22%; right:12%; position:absolute" data-parallax-speed="0.28"></i>
      <i class="fa-solid fa-bolt text-white/15 text-6xl parallax" style="bottom:18%; right:10%; position:absolute" data-parallax-speed="-0.22"></i>
    </div>

    <div class="relative z-10 max-w-3xl px-6" data-aos="zoom-in">
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
        Welcome to <span class="gradient-text">Qinclong Laundry</span>
      </h1>
      <p class="mt-4 text-lg text-white/90">Laundry modern—jemput & antar cepat, hasil rapi, wangi, dan ramah lingkungan.</p>
      <div class="mt-6 flex justify-center gap-4">
        <a href="{{ route('order.redirect') }}" class="btn-primary px-7 py-3 rounded-xl shadow focus-ring">🚀 Order Now</a>
        <a href="#layanan" class="btn-outline px-7 py-3 rounded-xl focus-ring">See Services</a>
      </div>

      <div class="mt-8 flex flex-wrap justify-center gap-6 text-white/85">
        <div class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-[#FFD35B]"></i><span>Garansi Kepuasan</span></div>
        <div class="flex items-center gap-2"><i class="fa-solid fa-truck-fast text-[#FFD35B]"></i><span>Pick-up/Delivery Cepat</span></div>
        <div class="flex items-center gap-2"><i class="fa-solid fa-leaf text-[#FFD35B]"></i><span>Eco-Friendly</span></div>
      </div>

      <a href="#about" class="inline-flex items-center gap-2 mt-10 text-white/80 hover:text-white focus-ring">
        <i class="fa-solid fa-circle-arrow-down animate-bounce"></i> Scroll to explore
      </a>
    </div>
  </section>

  <!-- ABOUT -->
  <section id="about" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
      <div data-aos="fade-right">
        <h2 class="text-3xl font-extrabold text-[#013C58]">Tentang Qinclong</h2>
        <p class="mt-3 text-gray-600">
          Kami hadir untuk menyederhanakan rutinitas cuci Anda dengan standar premium,
          pengemasan rapi, dan pengantaran tepat waktu. Fokus kami: kualitas, higienitas, dan kenyamanan.
        </p>
        <ul class="mt-5 space-y-3 text-gray-700">
          <li class="flex gap-3 items-start"><i class="fa-solid fa-circle-check text-[#F5A201] mt-1"></i> Quality check berlapis di setiap tahap.</li>
          <li class="flex gap-3 items-start"><i class="fa-solid fa-circle-check text-[#F5A201] mt-1"></i> Opsi express untuk kebutuhan mendesak.</li>
          <li class="flex gap-3 items-start"><i class="fa-solid fa-circle-check text-[#F5A201] mt-1"></i> Bahan & cairan pembersih aman untuk keluarga.</li>
        </ul>
        <a href="#layanan" class="inline-block mt-6 btn-primary px-6 py-3 rounded-xl focus-ring">Jelajahi Layanan</a>
      </div>

      <div class="relative" data-aos="fade-left">
        <div class="absolute -inset-4 bg-gradient-to-tr from-[#A8E8F9]/45 to-[#FFD35B]/40 rounded-3xl blur-xl"></div>
        <div class="relative glow-border rounded-2xl p-6 shadow-xl tilt">
          <div class="grid grid-cols-2 gap-4">
            <div class="rounded-xl bg-[#013C58] text-white p-5 flex flex-col justify-between">
              <div class="text-3xl"><i class="fa-solid fa-truck-fast"></i></div>
              <div>
                <p class="font-semibold">Cepat</p>
                <p class="text-xs text-white/80">Pickup & Delivery</p>
              </div>
            </div>
            <div class="rounded-xl bg-white border p-5">
              <div class="w-12 h-12 rounded-full bg-[#F5A201] text-white flex items-center justify-center mb-3"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
              <p class="font-semibold text-[#013C58]">Premium Care</p>
              <p class="text-xs text-gray-500">Packing rapi, wangi tahan lama</p>
            </div>
            <div class="rounded-xl bg-white border p-5">
              <div class="w-12 h-12 rounded-full bg-[#00537A] text-white flex items-center justify-center mb-3"><i class="fa-solid fa-leaf"></i></div>
              <p class="font-semibold text-[#013C58]">Eco Friendly</p>
              <p class="text-xs text-gray-500">Aman untuk kulit sensitif</p>
            </div>
            <div class="rounded-xl bg-[#FFFAF0] border border-[#FFE7B5] p-5">
              <div class="w-12 h-12 rounded-full bg-[#FFD35B] text-[#013C58] flex items-center justify-center mb-3"><i class="fa-solid fa-bolt"></i></div>
              <p class="font-semibold text-[#013C58]">Express</p>
              <p class="text-xs text-gray-700">Selesai dalam hitungan jam*</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES -->
  <section id="layanan" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <h2 class="text-3xl font-extrabold text-[#013C58] mb-3 text-center" data-aos="fade-up">Our Services</h2>
    <p class="text-center text-gray-600 mb-10" data-aos="fade-up" data-aos-delay="100">
      Pilih layanan sesuai kebutuhan—per kg, express, hingga care khusus.
    </p>

    <div class="relative" x-data="{ el:null }" x-init="el = $refs.track">
      <!-- arrows -->
      <button @click="el.scrollBy({left:-320,behavior:'smooth'})"
              class="hidden md:flex absolute -left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-[#013C58] text-white items-center justify-center shadow hover:bg-[#00537A] transition focus-ring"
              aria-label="Scroll left">
        <i class="fa-solid fa-chevron-left"></i>
      </button>
      <button @click="el.scrollBy({left:320,behavior:'smooth'})"
              class="hidden md:flex absolute -right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-[#013C58] text-white items-center justify-center shadow hover:bg-[#00537A] transition focus-ring"
              aria-label="Scroll right">
        <i class="fa-solid fa-chevron-right"></i>
      </button>

      <div class="scroll-fade left"></div>
      <div class="scroll-fade right"></div>

      <!-- track -->
      <div x-ref="track" tabindex="0" class="flex overflow-x-auto gap-6 snap-x snap-mandatory scrollbar-hide px-1 relative z-10">
        @foreach($services as $index => $service)
          @php
            $n        = strtolower($service->name ?? '');
            $isNewest = isset($latestId) && $service->id === $latestId;
            $isNew    = isset($newCutoff) && $service->created_at && $service->created_at->gt($newCutoff);
          @endphp

          <article class="service-card group relative snap-center min-w-[300px] bg-white rounded-2xl border border-gray-200 shadow-md hover:shadow-2xl transition-transform transform-gpu"
                   data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
            <div class="spotlight"></div>
            <span class="sheen"></span>
            <span class="accent"></span>

            <div class="relative overflow-hidden rounded-t-2xl">
              {{-- PENTING: pakai accessor image_url --}}
              <img src="{{ $service->image_url }}" alt="{{ $service->name }}"
                   class="w-full h-48 object-cover transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">

              {{-- Badge NEWEST/NEW --}}
              @if($isNewest)
                <span class="absolute top-2 left-2 text-[11px] font-bold text-white bg-amber-500 px-2 py-1 rounded shadow">NEWEST</span>
              @elseif($isNew)
                <span class="absolute top-2 left-2 text-[11px] font-semibold text-white bg-amber-500/90 px-2 py-1 rounded shadow">New</span>
              @endif

              <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
            </div>

            <div class="p-5">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#F5A201] text-white shadow transition-transform group-hover:scale-110 group-hover:rotate-6">
                  @if(Str::contains($n,'cuci')) <i class="fa-solid fa-basket-shopping"></i>
                  @elseif(Str::contains($n,'lipat')) <i class="fa-solid fa-box"></i>
                  @elseif(Str::contains($n,'strika') || Str::contains($n,'setrika')) <i class="fa-solid fa-wind"></i>
                  @elseif(Str::contains($n,'express')) <i class="fa-solid fa-bolt"></i>
                  @elseif(Str::contains($n,'sprei') || Str::contains($n,'bedcover') || Str::contains($n,'selimut')) <i class="fa-solid fa-bed"></i>
                  @elseif(Str::contains($n,'jas')) <i class="fa-solid fa-user-tie"></i>
                  @elseif(Str::contains($n,'baju') || Str::contains($n,'kemeja')) <i class="fa-solid fa-shirt"></i>
                  @else <i class="fa-solid fa-soap"></i> @endif
                </div>
                <h3 class="text-lg font-semibold text-[#013C58]">{{ $service->name }}</h3>
              </div>

              <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $service->description ?? 'Laundry service for you.' }}</p>

              <div class="mt-4 flex items-center justify-between">
                <p class="font-extrabold text-[#F5A201]">
                  Rp {{ number_format($service->price,0,',','.') }}@if(!empty($service->unit))/{{ $service->unit }}@endif
                </p>
                @if(!empty($service->unit))
                  <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $service->unit }}</span>
                @endif
              </div>

              <a href="{{ route('order.redirect') }}" class="mt-4 inline-flex items-center gap-2 text-sm bg-[#013C58] text-white px-4 py-2 rounded-lg hover:bg-[#00537A] transition focus-ring">
                Pilih Layanan <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
</section>


 <!-- WHY US (Premium Glass + Spotlight) -->
    <svg class="wave w-full h-10 text-gray-50" viewBox="0 0 1440 320" fill="currentColor" aria-hidden="true">
        <path
            d="M0,256L48,229.3C96,203,192,149,288,149.3C384,149,480,203,576,229.3C672,256,768,256,864,250.7C960,245,1056,235,1152,197.3C1248,160,1344,96,1392,64L1440,32L1440,0L0,0Z">
        </path>
    </svg>

    <section id="choose" class="relative py-20 bg-[#00537A] overflow-hidden text-white">
        <!-- dekorasi halus -->
        <div class="pointer-events-none absolute -top-24 -left-16 w-96 h-96 rounded-full bg-[#A8E8F9]/25 blur-3xl">
        </div>
        <div
            class="pointer-events-none absolute -bottom-28 -right-16 w-[28rem] h-[28rem] rounded-full bg-[#FFD35B]/20 blur-3xl">
        </div>

        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold mb-3" data-aos="fade-up">Why Choose Us?</h2>
            <p class="text-white/80 max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="80">
                Layanan cepat, harga ramah, dan ramah lingkungan—dirancang buat bikin hidup kamu lebih ringan.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group relative rounded-2xl bg-white/10 ring-1 ring-white/10 backdrop-blur-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden"
                    data-spotlight data-aos="zoom-in">
                    <!-- spotlight (ikuti mouse) -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                        style="background: radial-gradient(140px 140px at var(--mx,50%) var(--my,30%), rgba(255,211,91,0.18), transparent 60%);">
                    </div>

                    <!-- isi -->
                    <div class="relative z-10 text-left">
                        <div
                            class="w-14 h-14 rounded-2xl grid place-items-center bg-gradient-to-br from-[#FFD35B] to-[#F5A201] text-[#013C58] shadow-md transition-transform duration-300 group-hover:rotate-3">
                            <i class="fa-solid fa-truck-fast text-2xl"></i>
                        </div>
                        <h3 class="mt-5 text-xl font-bold">Fast Delivery</h3>
                        <p class="mt-2 text-white/85 text-sm">Jemput & antar cepat sesuai jadwal kamu, tanpa ribet.</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-2.5 py-1 text-xs rounded-full bg-white/10 ring-1 ring-white/10">Pick-up
                                Gratis*</span>
                            <span class="px-2.5 py-1 text-xs rounded-full bg-white/10 ring-1 ring-white/10">Tracking
                                Order</span>
                        </div>
                    </div>

                    <!-- garis aksen anim -->
                    <span
                        class="pointer-events-none absolute -bottom-px left-0 h-[2px] w-0 bg-gradient-to-r from-[#F5A201] via-[#FFD35B] to-[#A8E8F9] group-hover:w-full transition-[width] duration-500"></span>
                </div>

                <!-- Card 2 -->
                <div class="group relative rounded-2xl bg-white/10 ring-1 ring-white/10 backdrop-blur-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden"
                    data-spotlight data-aos="zoom-in" data-aos-delay="120">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                        style="background: radial-gradient(140px 140px at var(--mx,50%) var(--my,30%), rgba(168,232,249,0.18), transparent 60%);">
                    </div>

                    <div class="relative z-10 text-left">
                        <div
                            class="w-14 h-14 rounded-2xl grid place-items-center bg-gradient-to-br from-white to-[#A8E8F9] text-[#013C58] shadow-md transition-transform duration-300 group-hover:-rotate-2">
                            <i class="fa-solid fa-coins text-2xl"></i>
                        </div>
                        <h3 class="mt-5 text-xl font-bold">Affordable Price</h3>
                        <p class="mt-2 text-white/85 text-sm">Harga masuk akal dengan hasil kualitas premium.</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="px-2.5 py-1 text-xs rounded-full bg-white/10 ring-1 ring-white/10">Paket
                                Hemat</span>
                            <span class="px-2.5 py-1 text-xs rounded-full bg-white/10 ring-1 ring-white/10">Transparan
                                Tanpa Biaya Tersembunyi</span>
                        </div>
                    </div>

                    <span
                        class="pointer-events-none absolute -bottom-px left-0 h-[2px] w-0 bg-gradient-to-r from-[#A8E8F9] via-white to-[#FFD35B] group-hover:w-full transition-[width] duration-500"></span>
                </div>

                <!-- Card 3 -->
                <div class="group relative rounded-2xl bg-white/10 ring-1 ring-white/10 backdrop-blur-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden"
                    data-spotlight data-aos="zoom-in" data-aos-delay="220">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                        style="background: radial-gradient(140px 140px at var(--mx,50%) var(--my,30%), rgba(245,162,1,0.16), transparent 60%);">
                    </div>

                    <div class="relative z-10 text-left">
                        <div
                            class="w-14 h-14 rounded-2xl grid place-items-center bg-gradient-to-br from-[#00537A] to-[#2E9CA0] text-white shadow-md transition-transform duration-300 group-hover:rotate-1">
                            <i class="fa-solid fa-leaf text-2xl"></i>
                        </div>
                        <h3 class="mt-5 text-xl font-bold">Eco-Friendly</h3>
                        <p class="mt-2 text-white/85 text-sm">Detergen & proses yang aman untuk keluarga dan
                            lingkungan.</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span
                                class="px-2.5 py-1 text-xs rounded-full bg-white/10 ring-1 ring-white/10">Hypoallergenic</span>
                            <span class="px-2.5 py-1 text-xs rounded-full bg-white/10 ring-1 ring-white/10">Hemat Air &
                                Energi</span>
                        </div>
                    </div>

                    <span
                        class="pointer-events-none absolute -bottom-px left-0 h-[2px] w-0 bg-gradient-to-r from-[#2E9CA0] via-[#A8E8F9] to-[#F5A201] group-hover:w-full transition-[width] duration-500"></span>
                </div>
            </div>

            <!-- badge kecil / highlight -->
            <div class="mt-10 flex flex-wrap items-center justify-center gap-3 opacity-90" data-aos="fade-up"
                data-aos-delay="260">
                <span class="px-3 py-1 rounded-full bg-white/10 ring-1 ring-white/10 text-sm">⏱️ Express Ready</span>
                <span class="px-3 py-1 rounded-full bg-white/10 ring-1 ring-white/10 text-sm">🧼 Quality Check 3
                    Tahap</span>
                <span class="px-3 py-1 rounded-full bg-white/10 ring-1 ring-white/10 text-sm">🚚 Area Cengkareng &
                    Sekitar</span>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS (Premium) -->
    <section id="testimoni" class="relative py-20 bg-gray-50 overflow-hidden">
        <!-- dekorasi halus -->
        <div class="pointer-events-none absolute -top-16 -left-10 w-72 h-72 rounded-full bg-[#A8E8F9]/30 blur-3xl">
        </div>
        <div class="pointer-events-none absolute -bottom-20 -right-10 w-80 h-80 rounded-full bg-[#FFD35B]/25 blur-3xl">
        </div>

        <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl font-extrabold text-[#013C58] mb-3" data-aos="fade-up">
                What Our Customers Say
            </h2>
            <div class="flex items-center justify-center gap-2 mb-10" data-aos="fade-up" data-aos-delay="80">
                <div class="flex text-[#FFD35B] text-xl">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <span class="text-sm text-[#013C58]/80 font-medium">Rated 4.9/5 by our customers</span>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group relative rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden"
                    data-aos="fade-up">
                    <!-- aksen sudut -->
                    <div
                        class="absolute -right-8 -top-8 w-28 h-28 bg-gradient-to-br from-[#A8E8F9] to-[#FFD35B] opacity-20 rounded-full">
                    </div>

                    <div class="p-6 text-left">
                        <!-- header: avatar + nama + rating -->
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 rounded-full bg-[#FFD35B] text-[#013C58] font-extrabold flex items-center justify-center ring-2 ring-[#013C58]/10">
                                A
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#013C58] leading-tight">Andi</h4>
                                <div class="text-xs text-gray-500">Pelanggan</div>
                            </div>
                            <div class="ml-auto text-[#FFD35B]">
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star-half-stroke text-sm"></i>
                            </div>
                        </div>

                        <!-- quote -->
                        <div class="relative mt-5">
                            <i
                                class="fa-solid fa-quote-left text-3xl text-[#A8E8F9] opacity-60 absolute -top-3 -left-1"></i>
                            <p class="text-gray-700 pl-6">
                                “Layanan super cepat, pakaian rapi banget. Recommended!”
                            </p>
                        </div>
                    </div>

                    <!-- garis bawah anim -->
                    <div
                        class="h-1 w-0 bg-gradient-to-r from-[#F5A201] via-[#FFD35B] to-[#A8E8F9] group-hover:w-full transition-all duration-500">
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group relative rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden"
                    data-aos="fade-up" data-aos-delay="120">
                    <div
                        class="absolute -right-8 -top-8 w-28 h-28 bg-gradient-to-br from-[#A8E8F9] to-[#FFD35B] opacity-20 rounded-full">
                    </div>

                    <div class="p-6 text-left">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 rounded-full bg-[#FFD35B] text-[#013C58] font-extrabold flex items-center justify-center ring-2 ring-[#013C58]/10">
                                S
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#013C58] leading-tight">Siti</h4>
                                <div class="text-xs text-gray-500">Pelanggan</div>
                            </div>
                            <div class="ml-auto text-[#FFD35B]">
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                            </div>
                        </div>

                        <div class="relative mt-5">
                            <i
                                class="fa-solid fa-quote-left text-3xl text-[#A8E8F9] opacity-60 absolute -top-3 -left-1"></i>
                            <p class="text-gray-700 pl-6">
                                “Harga terjangkau tapi kualitas premium. Mantap!”
                            </p>
                        </div>
                    </div>

                    <div
                        class="h-1 w-0 bg-gradient-to-r from-[#F5A201] via-[#FFD35B] to-[#A8E8F9] group-hover:w-full transition-all duration-500">
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group relative rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden"
                    data-aos="fade-up" data-aos-delay="220">
                    <div
                        class="absolute -right-8 -top-8 w-28 h-28 bg-gradient-to-br from-[#A8E8F9] to-[#FFD35B] opacity-20 rounded-full">
                    </div>

                    <div class="p-6 text-left">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 rounded-full bg-[#FFD35B] text-[#013C58] font-extrabold flex items-center justify-center ring-2 ring-[#013C58]/10">
                                B
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#013C58] leading-tight">Budi</h4>
                                <div class="text-xs text-gray-500">Pelanggan</div>
                            </div>
                            <div class="ml-auto text-[#FFD35B]">
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-solid fa-star text-sm"></i>
                                <i class="fa-regular fa-star text-sm"></i>
                            </div>
                        </div>

                        <div class="relative mt-5">
                            <i
                                class="fa-solid fa-quote-left text-3xl text-[#A8E8F9] opacity-60 absolute -top-3 -left-1"></i>
                            <p class="text-gray-700 pl-6">
                                “Proses jemput dan antar sangat memudahkan.”
                            </p>
                        </div>
                    </div>

                    <div
                        class="h-1 w-0 bg-gradient-to-r from-[#F5A201] via-[#FFD35B] to-[#A8E8F9] group-hover:w-full transition-all duration-500">
                    </div>
                </div>
            </div>

            <!-- CTA kecil -->
            <div class="mt-12" data-aos="fade-up" data-aos-delay="260">
                <a href="{{ route('order.redirect') }}"
                    class="inline-flex items-center gap-2 bg-[#013C58] text-white px-5 py-2.5 rounded-lg hover:bg-[#00537A] transition">
                    Coba Qinclong Laundry <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>


  <!-- LOCATIONS -->
  <section id="lokasi" class="relative py-20 -mt-1">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-extrabold text-[#013C58] mb-12">Our Locations</h2>
      <div class="grid md:grid-cols-2 gap-8 text-left">

        <!-- Cabang 1 -->
        <article class="loc-card p-6 shadow ring-1 ring-gray-100" data-aos="fade-up">
          <span class="accent"></span><span class="shine"></span>
          <h3 class="text-xl font-bold text-[#F5A201] mb-2">Cabang 1</h3>
          <p class="text-gray-700">Blok E2 Gunung Pangrango No.13 3, RT.3/RW.15, Cengkareng Timur, Kecamatan Cengkareng, Kota Jakarta Barat, DKI Jakarta 11730</p>
          <div class="map-frame mt-4 ring-1 ring-gray-100">
            <iframe loading="lazy" referrerpolicy="no-referrer-when-downgrade"
              src="https://www.google.com/maps?q=Blok+E2+Gunung+Pangrango+No.13+Jakarta+Barat&output=embed"
              aria-label="Map Cabang 1"></iframe>
          </div>
        </article>

        <!-- Cabang 2 -->
        <article class="loc-card p-6 shadow ring-1 ring-gray-100" data-aos="fade-up" data-aos-delay="120">
          <span class="accent"></span><span class="shine"></span>
          <h3 class="text-xl font-bold text-[#F5A201] mb-2">Cabang 2</h3>
          <p class="text-gray-700">Jl. Raya Bumi Cengkareng Indah No.1, RT.13/RW.10, Cengkareng Timur, Kecamatan Cengkareng, Kota Jakarta Barat, DKI Jakarta 11730</p>
          <div class="map-frame mt-4 ring-1 ring-gray-100">
            <iframe loading="lazy" referrerpolicy="no-referrer-when-downgrade"
              src="https://www.google.com/maps?q=Bumi+Cengkareng+Indah+No.1+Jakarta+Barat&output=embed"
              aria-label="Map Cabang 2"></iframe>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- FOOTER (rich content, no JS) -->
<footer class="bg-[#013C58] text-[#A8E8F9] pt-8 footer-anim">
  <!-- CTA bar -->
  <div class="footer-cta">
    <div class="cta-box max-w-7xl mx-auto px-6">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h4 class="text-white font-extrabold text-xl">Butuh jemput cepat?</h4>
          <p class="text-white/80 text-sm">Order sekarang, kurir kami siap pick-up & antar.</p>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('order.redirect') }}" class="btn-subscribe px-5 py-2 rounded-lg text-white font-bold">Order Now</a>
          <a href="#layanan" class="inline-flex items-center px-5 py-2 rounded-lg border border-white/30 text-white/90 hover:bg-white/10 transition">Lihat Layanan</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main -->
  <div class="max-w-7xl mx-auto px-6 py-12 grid gap-10 md:grid-cols-4 relative z-10">
    <!-- Brand + badges + social -->
    <div>
      <h3 class="footer-title text-[#FFBA42] font-bold text-lg mb-3">Qinclong Laundry</h3>
      <p class="text-[#D7F3FB]">Premium laundry service with the best standards.</p>

      <div class="mt-5 flex flex-wrap gap-2">
        <span class="badge">Garansi 100%</span>
        <span class="badge">Free Pick-up</span>
        <span class="badge">Express 24h</span>
      </div>

      <div class="mt-6 flex gap-4 text-2xl social">
        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>

    <!-- Navigation -->
    <div>
      <h3 class="footer-title text-[#FFBA42] font-bold text-lg mb-3">Navigation</h3>
      <div class="grid grid-cols-2 gap-2 nav-links">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#layanan">Services</a>
        <a href="#choose">Why Us</a>
        <a href="#testimoni">Testimonials</a>
        <a href="#lokasi">Location</a>
      </div>

      <h3 class="footer-title text-[#FFBA42] font-bold text-lg mt-6 mb-3">Popular Services</h3>
      <ul class="space-y-2 nav-links">
        <li><a href="#layanan">Cuci & Lipat</a></li>
        <li><a href="#layanan">Setrika</a></li>
        <li><a href="#layanan">Express</a></li>
        <li><a href="#layanan">Sprei/Bedcover</a></li>
      </ul>
    </div>

    <!-- Contact + Hours -->
    <div>
      <h3 class="footer-title text-[#FFBA42] font-bold text-lg mb-3">Contact</h3>
      <ul class="contact-list space-y-3">
        <li class="contact-item">
          <i class="fa-solid fa-location-dot"></i>
          <span>Blok E2 Gunung Pangrango No.13, Cengkareng Timur, Jakarta Barat</span>
        </li>
        <li class="contact-item">
          <i class="fa-solid fa-phone"></i>
          <a href="tel:08xxxxxxxxxx" class="link-quiet">08xx-xxxx-xxxx</a>
        </li>
        <li class="contact-item">
          <i class="fa-solid fa-envelope"></i>
          <a href="mailto:cs@qinclonglaundry.com" class="link-quiet">cs@qinclonglaundry.com</a>
        </li>
        <li class="contact-item">
          <i class="fa-brands fa-whatsapp"></i>
          <a href="#" class="link-quiet">WhatsApp kami</a>
          <!-- ganti href dengan wa.me/62xxxxxxxxxx -->
        </li>
      </ul>

      <h3 class="footer-title text-[#FFBA42] font-bold text-lg mt-6 mb-3">Hours</h3>
      <ul class="hours">
        <li><span>Sen–Jum</span><span>08.00–20.00</span></li>
        <li><span>Sabtu</span><span>08.00–18.00</span></li>
        <li><span>Minggu</span><span>09.00–17.00</span></li>
      </ul>
    </div>

    <!-- Subscribe + Payments -->
    <div>
      <h3 class="footer-title text-[#FFBA42] font-bold text-lg mb-3">Subscribe</h3>
      <form class="flex subscribe">
        <input type="email" placeholder="Enter email"
               class="input-subscribe w-full px-4 py-2 rounded-l-lg focus:outline-none text-[#013C58]"
               aria-label="Email">
        <button class="btn-subscribe px-4 py-2 rounded-r-lg text-white font-bold">Send</button>
      </form>
      <p class="text-xs text-white/70 mt-2">Kami kirim tips perawatan pakaian & promo (no spam).</p>

      <h3 class="footer-title text-[#FFBA42] font-bold text-lg mt-6 mb-3">We Accept</h3>
      <div class="payments">
        <i class="fa-brands fa-cc-visa"></i>
        <i class="fa-brands fa-cc-mastercard"></i>
        <i class="fa-brands fa-cc-amex"></i>
        <i class="fa-brands fa-cc-jcb"></i>
      </div>
    </div>
  </div>

<div class="text-center text-white/70 text-sm mb-2">
  <a href="#" class="underline decoration-dotted hover:text-[#FFD35B]">Terms</a> ·
  <a href="#" class="underline decoration-dotted hover:text-[#FFD35B]">Privacy</a>
</div>


  <div class="text-center text-[#FFD35B] pb-8">
    © {{ date('Y') }} Qinclong Laundry. All Rights Reserved.
  </div>
</footer>



  <!-- Back to top -->
  <button id="backtop" class="backtop" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button>

  <!-- SCRIPTS -->
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 900, once: true });

    // Parallax (scroll + subtil mouse)
    (() => {
      const layers = Array.from(document.querySelectorAll('.parallax'));
      const clamp = (n, min, max) => Math.max(min, Math.min(n, max));
      let mouseX = 0, mouseY = 0;

      window.addEventListener('mousemove', (e) => {
        const cx = window.innerWidth / 2;
        const cy = window.innerHeight / 2;
        mouseX = (e.clientX - cx) / cx;
        mouseY = (e.clientY - cy) / cy;
      });

      const onScroll = () => {
        const sy = window.scrollY || window.pageYOffset;
        layers.forEach(el => {
          const speed = parseFloat(el.dataset.parallaxSpeed || 0.2);
          const tx = clamp(mouseX * 10 * speed, -10, 10);
          const ty = (sy * speed) + clamp(mouseY * 10 * speed, -10, 10);
          el.style.transform = `translate3d(${tx}px, ${ty}px, 0)`;
        });
      };
      onScroll();
      window.addEventListener('scroll', onScroll, { passive: true });
    })();

    // Keyboard support untuk slider services
    document.addEventListener('DOMContentLoaded', () => {
      const track = document.querySelector('#layanan [x-ref="track"]');
      if (!track) return;
      track.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') track.scrollBy({ left: 320, behavior: 'smooth' });
        if (e.key === 'ArrowLeft')  track.scrollBy({ left: -320, behavior: 'smooth' });
      });
    });

    // Back to top button
    (() => {
      const btn = document.getElementById('backtop');
      const toggle = () => btn.classList.toggle('show', window.scrollY > 600);
      toggle();
      window.addEventListener('scroll', toggle, { passive: true });
      btn.addEventListener('click', () => window.scrollTo({ top:0, behavior:'smooth' }));
    })();
  </script>
</body>
</html>
