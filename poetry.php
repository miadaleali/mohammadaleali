<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>اشعار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    @font-face {
        font-family: 'A Mashin Tahrir-Old';
        src: url('assets/fonts/AMashinTahrir-Old.woff2') format('woff2'),
            url('assets/fonts/AMashinTahrir-Old.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }

    :root {
        --gold: #dbab38;
        --gold-dark: #b17e09;
        --gold-deep: #7a5505;
        --ink: #1a1105;
        --parchment: #f5e9c8;
        --shadow: rgba(90, 50, 0, 0.25);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    html,
    body {
        font-family: 'A Mashin Tahrir-Old', 'Tahoma', sans-serif;
        min-height: 100%;
        margin: 0;
        background-color: var(--gold);
        background-image: url("https://www.transparenttextures.com/patterns/french-stucco.png");
        color: var(--ink);
        overflow-x: hidden;
        max-width: 100vw;
    }

    /* ── HEADER ── */
    .page-header {
        text-align: center;
        padding: 3rem 1rem 1.5rem;
        position: relative;
    }

    .page-header h1 {
        font-size: clamp(2.5rem, 8vw, 5rem);
        letter-spacing: .06em;
        color: var(--gold-deep);
        text-shadow: 1px 2px 0 rgba(255, 220, 100, .6), 0 4px 16px var(--shadow);
        margin: 0;
        line-height: 1.1;
    }

    .header-ornament {
        display: block;
        width: 200px;
        margin: .6rem auto 0;
        height: 2px;
        background: linear-gradient(to left, transparent, var(--gold-deep), transparent);
        position: relative;
    }

    .header-ornament::before,
    .header-ornament::after {
        content: '✦';
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: .65rem;
        color: var(--gold-deep);
    }

    .header-ornament::before {
        right: -1rem;
    }

    .header-ornament::after {
        left: -1rem;
    }

    /* ── BACKGROUND WATERMARKS ── */
    .kooch-img {
        position: fixed;
        top: 15%;
        left: 0;
        width: min(500px, 50vw);
        z-index: 0;
        mix-blend-mode: multiply;
        opacity: .15;
        pointer-events: none;
    }

    .khat-img {
        position: fixed;
        top: 0;
        left: 40%;
        width: min(600px, 60vw);
        z-index: 0;
        mix-blend-mode: multiply;
        opacity: .05;
        pointer-events: none;
    }

    /* ── CATEGORY GRID ── */
    .cat-section {
        position: relative;
        z-index: 1;
        padding: 0 1rem 2rem;
    }

    .cat-section-title {
        text-align: center;
        font-size: 1.1rem;
        color: var(--gold-deep);
        opacity: .75;
        letter-spacing: .1em;
        margin-bottom: 1.5rem;
    }

    .cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .cat-card {
        position: relative;
        cursor: pointer;
        background: rgba(255, 240, 180, .35);
        border: 2px solid rgba(177, 126, 9, .35);
        border-radius: 12px;
        padding: 1.3rem .8rem 1rem;
        text-align: center;
        transition: transform .25s, box-shadow .25s, background .25s, border-color .25s;
        backdrop-filter: blur(4px);
        user-select: none;
        overflow: hidden;
    }

    .cat-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 0%, rgba(255, 240, 150, .5), transparent 70%);
        opacity: 0;
        transition: opacity .3s;
    }

    .cat-card:hover::before,
    .cat-card.active::before {
        opacity: 1;
    }

    .cat-card:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 10px 28px var(--shadow);
        border-color: var(--gold-dark);
        background: rgba(255, 240, 180, .6);
    }

    .cat-card.active {
        background: rgba(255, 230, 140, .75);
        border-color: var(--gold-deep);
        box-shadow: 0 8px 24px var(--shadow), inset 0 0 0 1px rgba(255, 220, 100, .6);
        transform: translateY(-3px);
    }

    .cat-icon {
        font-size: 2rem;
        line-height: 1;
        margin-bottom: .4rem;
        display: block;
    }

    .cat-name {
        font-size: 1.15rem;
        font-weight: bold;
        color: var(--ink);
    }

    .cat-count {
        font-size: .78rem;
        color: var(--gold-deep);
        margin-top: .2rem;
        opacity: .8;
    }

    .cat-card.loading-state {
        pointer-events: none;
        opacity: .7;
    }

    /* ── DIVIDER ── */
    .section-divider {
        max-width: 500px;
        margin: 0 auto 1.8rem;
        display: flex;
        align-items: center;
        gap: .8rem;
        padding: 0 1rem;
    }

    .section-divider span {
        flex: 1;
        height: 1px;
        background: var(--gold-deep);
        opacity: .4;
    }

    .section-divider .diamond {
        color: var(--gold-deep);
        font-size: .7rem;
        opacity: .7;
    }

    /* ── POEM SLIDER SECTION ── */
    .poem-section {
        position: relative;
        z-index: 1;
        padding: 0 1rem 4rem;
        min-height: 320px;
    }

    /* Loading Spinner */
    .poem-loader {
        display: none;
        justify-content: center;
        align-items: center;
        height: 200px;
        gap: 8px;
    }

    .poem-loader.visible {
        display: flex;
    }

    .loader-dot {
        width: 10px;
        height: 10px;
        background: var(--gold-deep);
        border-radius: 50%;
        animation: bounce 1.2s infinite ease-in-out;
    }

    .loader-dot:nth-child(2) {
        animation-delay: .2s;
    }

    .loader-dot:nth-child(3) {
        animation-delay: .4s;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
            opacity: .4;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Slider wrapper */
    .slider-wrapper {
        display: none;
        max-width: 1100px;
        margin: 0 auto;
        overflow: hidden;
    }

    .slider-wrapper.visible {
        display: block;
    }

    .slider-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.2rem;
        padding: 0 .3rem;
    }

    .slider-cat-title {
        font-size: 1.5rem;
        color: var(--gold-deep);
        text-shadow: 0 1px 3px var(--shadow);
    }

    .slider-counter {
        font-size: .9rem;
        color: var(--gold-deep);
        opacity: .75;
        background: rgba(255, 240, 180, .5);
        border: 1px solid rgba(177, 126, 9, .3);
        border-radius: 20px;
        padding: .2rem .8rem;
    }

    /* ── TWO-COLUMN LAYOUT ── */
    .slider-body {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 1.2rem;
        align-items: start;
        min-width: 0;
        overflow: hidden;
    }

    @media (max-width: 700px) {
        .slider-body {
            grid-template-columns: 1fr;
        }

        .poem-toc {
            order: -1;
        }
    }

    /* ── POEM TABLE OF CONTENTS ── */
    .poem-toc {
        background: rgba(255, 248, 210, .55);
        border: 1.5px solid rgba(177, 126, 9, .3);
        border-radius: 14px;
        overflow: hidden;
        backdrop-filter: blur(4px);
        box-shadow: 0 4px 18px var(--shadow);
        position: sticky;
        top: 1rem;
        max-height: 480px;
        display: flex;
        flex-direction: column;
    }

    .toc-header {
        padding: .7rem 1rem;
        background: rgba(177, 126, 9, .12);
        border-bottom: 1px solid rgba(177, 126, 9, .25);
        font-size: .85rem;
        color: var(--gold-deep);
        letter-spacing: .08em;
        text-align: center;
        flex-shrink: 0;
    }

    .toc-list {
        overflow-y: auto;
        flex: 1;
        padding: .4rem 0;
        scrollbar-width: thin;
        scrollbar-color: rgba(177, 126, 9, .3) transparent;
    }

    .toc-list::-webkit-scrollbar {
        width: 4px;
    }

    .toc-list::-webkit-scrollbar-thumb {
        background: rgba(177, 126, 9, .3);
        border-radius: 2px;
    }

    .toc-item {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .55rem 1rem;
        cursor: pointer;
        border-right: 3px solid transparent;
        transition: background .2s, border-color .2s;
        position: relative;
    }

    .toc-item:hover {
        background: rgba(255, 230, 120, .4);
    }

    .toc-item.active {
        background: rgba(255, 230, 120, .6);
        border-right-color: var(--gold-deep);
    }

    .toc-num {
        font-size: .75rem;
        color: var(--gold-dark);
        opacity: .7;
        min-width: 1.4rem;
        text-align: center;
        flex-shrink: 0;
    }

    .toc-info {
        flex: 1;
        min-width: 0;
    }

    .toc-title {
        font-size: .95rem;
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        line-height: 1.3;
    }

    .toc-poet {
        font-size: .75rem;
        color: var(--gold-deep);
        opacity: .75;
        display: block;
        margin-top: .1rem;
    }

    .toc-arrow {
        font-size: .7rem;
        color: var(--gold-dark);
        opacity: 0;
        transition: opacity .2s;
        flex-shrink: 0;
    }

    .toc-item:hover .toc-arrow,
    .toc-item.active .toc-arrow {
        opacity: 1;
    }

    /* ── SENTINEL (infinite scroll indicator) ── */
    .toc-sentinel {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: .7rem 0;
        min-height: 36px;
    }

    .toc-end {
        font-size: .72rem;
        color: var(--gold-deep);
        opacity: .45;
        letter-spacing: .12em;
    }

    .toc-load-dots {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .toc-load-dots i {
        display: block;
        width: 6px;
        height: 6px;
        background: var(--gold-deep);
        border-radius: 50%;
        animation: tocBounce 1s infinite ease-in-out;
        font-style: normal;
    }

    .toc-load-dots i:nth-child(2) {
        animation-delay: .15s;
    }

    .toc-load-dots i:nth-child(3) {
        animation-delay: .30s;
    }

    @keyframes tocBounce {

        0%,
        80%,
        100% {
            transform: scale(0.4);
            opacity: .3;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Slider track */
    .slider-track-outer {
        overflow: hidden;
        border-radius: 18px;
        position: relative;
        width: 100%;
    }

    .slider-track {
        display: grid;
        grid-auto-flow: column;
        grid-auto-columns: 100%;
        transition: transform .5s cubic-bezier(.4, 0, .2, 1);
        will-change: transform;
        width: 100%;
    }

    /* Poem Card */
    .poem-card {
        min-width: 0;
        width: 100%;
        background: rgba(255, 248, 220, .7);
        border: 1.5px solid rgba(177, 126, 9, .3);
        border-radius: 18px;
        padding: clamp(1.4rem, 4vw, 2.4rem) clamp(1.2rem, 4vw, 2.5rem);
        position: relative;
        backdrop-filter: blur(6px);
        box-shadow: 0 8px 32px var(--shadow);
        animation: cardIn .4s ease both;
    }

    @keyframes cardIn {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .poem-ornament-top,
    .poem-ornament-bottom {
        text-align: center;
        font-size: .8rem;
        color: var(--gold-dark);
        letter-spacing: .4em;
        opacity: .6;
        line-height: 1;
    }

    .poem-ornament-top {
        margin-bottom: 1rem;
    }

    .poem-ornament-bottom {
        margin-top: 1rem;
    }

    .poem-title {
        font-size: clamp(1.3rem, 4vw, 1.9rem);
        color: var(--gold-deep);
        text-align: center;
        margin: 0 0 .3rem;
        text-shadow: 0 1px 4px rgba(255, 220, 80, .5);
    }

    .poem-poet {
        text-align: center;
        color: var(--gold-dark);
        font-size: .95rem;
        margin-bottom: 1.4rem;
        opacity: .8;
    }

    .poem-poet::before {
        content: '— ';
    }

    .poem-content {
        line-height: 2.1;
        font-size: clamp(1.05rem, 2.5vw, 1.25rem);
        white-space: pre-line;
        text-align: center;
        color: var(--ink);
        padding: 0 .5rem;
    }

    /* Slider Controls */
    .slider-controls {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.4rem;
    }

    .slider-btn {
        width: 2.6rem;
        height: 2.6rem;
        border-radius: 50%;
        border: 2px solid var(--gold-dark);
        background: rgba(255, 240, 180, .5);
        cursor: pointer;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s, transform .15s, box-shadow .2s;
        color: var(--gold-deep);
        line-height: 1;
    }

    .slider-btn:hover:not(:disabled) {
        background: rgba(255, 230, 130, .85);
        transform: scale(1.08);
        box-shadow: 0 3px 10px var(--shadow);
    }

    .slider-btn:disabled {
        opacity: .35;
        cursor: not-allowed;
    }

    .slider-dots {
        display: flex;
        gap: .5rem;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(122, 85, 5, .3);
        cursor: pointer;
        transition: background .25s, transform .25s;
        border: none;
        padding: 0;
    }

    .dot.active {
        background: var(--gold-deep);
        transform: scale(1.4);
    }

    /* ── BACK TO HOME BUTTON ── */
    .btn-home {
        position: fixed;
        bottom: 2rem;
        left: 2rem;
        z-index: 999;
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem 1.1rem .6rem .9rem;
        border-radius: 2rem;
        border: 2px solid var(--gold-dark);
        background: rgba(219, 171, 56, .88);
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 18px var(--shadow);
        cursor: pointer;
        color: var(--gold-deep);
        font-family: inherit;
        font-size: .95rem;
        font-weight: bold;
        text-decoration: none;
        transition: background .25s, box-shadow .25s, transform .2s;
        white-space: nowrap;
    }

    .btn-home:hover {
        background: rgba(255, 230, 120, .97);
        box-shadow: 0 6px 24px var(--shadow);
        transform: translateY(-2px);
        color: var(--gold-deep);
        text-decoration: none;
    }

    .btn-home:active {
        transform: scale(.96);
    }

    .btn-home-icon {
        font-size: 1.1rem;
        line-height: 1;
    }

    @media (max-width: 500px) {
        .btn-home span.btn-home-label {
            display: none;
        }

        .btn-home {
            padding: .65rem .8rem;
            border-radius: 50%;
        }
    }

    /* ── BACK TO TOP BUTTON ── */
    .btn-back-top {
        position: fixed;
        bottom: 2rem;
        left: 2rem;
        z-index: 999;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        border: 2px solid var(--gold-dark);
        background: rgba(219, 171, 56, .85);
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 18px var(--shadow);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--gold-deep);
        opacity: 0;
        transform: translateY(12px) scale(.85);
        transition: opacity .35s, transform .35s, box-shadow .25s, background .25s;
        pointer-events: none;
    }

    .btn-back-top.visible {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    .btn-back-top:hover {
        background: rgba(255, 230, 120, .95);
        box-shadow: 0 6px 24px var(--shadow);
        transform: translateY(-2px) scale(1.08);
    }

    .btn-back-top:active {
        transform: scale(.95);
    }

    .btn-back-top::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 50%;
        border: 1.5px solid rgba(177, 126, 9, .25);
        animation: pulseRing 2.4s infinite ease-out;
    }

    @keyframes pulseRing {
        0% {
            transform: scale(1);
            opacity: .6;
        }

        70% {
            transform: scale(1.4);
            opacity: 0;
        }

        100% {
            transform: scale(1.4);
            opacity: 0;
        }
    }

    @media (max-width: 700px) {
        .btn-back-top {
            bottom: 1.2rem;
            left: 1.2rem;
            width: 2.6rem;
            height: 2.6rem;
            font-size: 1.1rem;
        }
    }

    /* Empty state */
    .empty-state {
        display: none;
        text-align: center;
        padding: 3rem 1rem;
        color: var(--gold-deep);
        opacity: .7;
        font-size: 1.2rem;
    }

    .empty-state.visible {
        display: block;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 480px) {
        .cat-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: .6rem;
        }

        .cat-card {
            padding: 1rem .5rem .7rem;
        }

        .cat-icon {
            font-size: 1.5rem;
        }

        .cat-name {
            font-size: .95rem;
        }

        .poem-card {
            border-radius: 14px;
        }
    }

    @media (min-width: 768px) {
        .cat-grid {
            grid-template-columns: repeat(6, 1fr);
        }
    }
    </style>
</head>

<body>

    <img class="kooch-img" src="assets/img/unnamed.jpg" alt="">
    <img class="khat-img" src="assets/img/r.jpeg" alt="">

    <!-- HEADER -->
    <header class="page-header">
        <h1>اشعار</h1>
        <span class="header-ornament"></span>
    </header>

    <!-- CATEGORIES -->
    <section class="cat-section">
        <p class="cat-section-title">دسته‌بندی</p>
        <div class="cat-grid" id="catGrid">
            <!-- JS fills this -->
            <div class="text-center w-100 py-4" id="catLoader" style="grid-column:1/-1">
                <span style="color:var(--gold-deep);opacity:.6">در حال بارگذاری…</span>
            </div>
        </div>
    </section>

    <!-- DIVIDER -->
    <div class="section-divider" id="divider" style="display:none">
        <span></span>
        <span class="diamond">◆</span>
        <span></span>
    </div>

    <!-- POEMS -->
    <section class="poem-section">
        <div class="poem-loader" id="poemLoader">
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
        </div>

        <div class="empty-state" id="emptyState">شعری در این دسته یافت نشد</div>

        <div class="slider-wrapper" id="sliderWrapper">
            <div class="slider-header">
                <span class="slider-cat-title" id="sliderTitle"></span>
                <span class="slider-counter" id="sliderCounter"></span>
            </div>
            <div class="slider-body">
                <!-- فهرست اشعار -->
                <div class="poem-toc">
                    <div class="toc-header">فهرست اشعار</div>
                    <div class="toc-list" id="tocList"></div>
                </div>
                <!-- اسلایدر -->
                <div>
                    <div class="slider-track-outer">
                        <div class="slider-track" id="sliderTrack"></div>
                    </div>
                    <div class="slider-controls">
                        <button class="slider-btn" id="btnPrev" title="قبلی">&#8250;</button>
                        <div class="slider-dots" id="sliderDots"></div>
                        <button class="slider-btn" id="btnNext" title="بعدی">&#8249;</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    // ══════════════════════════════════════════
    // CONFIG
    // ══════════════════════════════════════════
    const API = 'api.php';
    const PER_PAGE = 10; // تعداد شعر در هر بار بارگذاری فهرست

    // ══════════════════════════════════════════
    // STATE
    // ══════════════════════════════════════════
    let currentIndex = 0;
    let totalPoems = 0; // کل اشعار این دسته (از سرور)
    let loadedPoems = []; // آرایه کامل اشعار لود‌شده تا الان
    let tocPage = 1; // صفحه‌ی بعدی برای لود فهرست
    let tocHasMore = false; // آیا صفحه بعدی وجود دارد؟
    let tocLoading = false; // در حال لود فهرست هستیم؟
    let activeCatId = null;
    let activeCatName = '';

    let isDragging = false;
    let dragStartX = 0;
    let dragDeltaX = 0;

    // ══════════════════════════════════════════
    // INIT
    // ══════════════════════════════════════════
    document.addEventListener('DOMContentLoaded', loadCategories);

    // ══════════════════════════════════════════
    // CATEGORIES
    // ══════════════════════════════════════════
    async function loadCategories() {
        try {
            const res = await fetch(`${API}?action=categories`);
            const json = await res.json();
            document.getElementById('catLoader').remove();
            if (json.success && json.data.length) renderCategories(json.data);
        } catch (e) {
            document.getElementById('catLoader').textContent = 'خطا در بارگذاری';
        }
    }

    function renderCategories(cats) {
        const grid = document.getElementById('catGrid');
        cats.forEach(cat => {
            const card = document.createElement('div');
            card.className = 'cat-card';
            card.dataset.id = cat.id;
            card.dataset.name = cat.name;
            card.innerHTML = `
            <span class="cat-icon">${cat.icon || ''}</span>
            <div class="cat-name">${cat.name}</div>
            <div class="cat-count">${toPersianNum(cat.count)} شعر</div>`;
            card.addEventListener('click', () => selectCategory(card, cat));
            grid.appendChild(card);
        });
    }

    function selectCategory(card, cat) {
        document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        activeCatId = cat.id;
        activeCatName = cat.name;

        // reset state
        currentIndex = 0;
        loadedPoems = [];
        tocPage = 1;
        tocHasMore = false;
        tocLoading = false;

        // reset UI
        document.getElementById('sliderTrack').innerHTML = '';
        document.getElementById('sliderDots').innerHTML = '';
        document.getElementById('tocList').innerHTML = '';
        document.getElementById('poemLoader').classList.add('visible');
        document.getElementById('sliderWrapper').classList.remove('visible');
        document.getElementById('emptyState').classList.remove('visible');
        document.getElementById('divider').style.display = 'flex';

        setTimeout(() => {
            document.querySelector('.poem-section').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 100);

        // بار اول را بارگذاری کن
        loadPoemsPage(cat.id, cat.name, 1, true);
    }

    // ══════════════════════════════════════════
    // LOAD POEMS PAGE  (صفحه‌بندی شده)
    // ══════════════════════════════════════════
    async function loadPoemsPage(catId, catName, page, isFirst = false) {
        if (tocLoading) return;
        tocLoading = true;

        // نشانگر در پایین فهرست
        const sentinel = document.getElementById('tocSentinel');
        if (sentinel) sentinel.classList.add('loading');

        try {
            const res = await fetch(`${API}?action=poems&category_id=${catId}&page=${page}&per_page=${PER_PAGE}`);
            const json = await res.json();

            if (!json.success) throw new Error('api error');

            totalPoems = json.total;
            tocHasMore = json.has_more;
            tocPage = page + 1;

            document.getElementById('poemLoader').classList.remove('visible');

            if (isFirst && json.data.length === 0) {
                document.getElementById('emptyState').classList.add('visible');
                tocLoading = false;
                return;
            }

            appendPoems(json.data, isFirst, catName);

        } catch (e) {
            document.getElementById('poemLoader').classList.remove('visible');
            if (isFirst) {
                document.getElementById('emptyState').textContent = 'خطا در بارگذاری اشعار';
                document.getElementById('emptyState').classList.add('visible');
            }
        }

        tocLoading = false;
        if (sentinel) sentinel.classList.remove('loading');
        updateSentinel();
    }

    // ══════════════════════════════════════════
    // APPEND POEMS  (اضافه کردن دسته جدید به slider + TOC)
    // ══════════════════════════════════════════
    function appendPoems(poems, isFirst, catName) {
        const globalOffset = loadedPoems.length; // ایندکس شروع این دسته
        loadedPoems.push(...poems);

        const track = document.getElementById('sliderTrack');
        const dots = document.getElementById('sliderDots');
        const tocList = document.getElementById('tocList');

        poems.forEach((poem, localIdx) => {
            const globalIdx = globalOffset + localIdx;

            // ── Slide Card ──
            const card = document.createElement('div');
            card.className = 'poem-card';
            card.innerHTML = `
            <div class="poem-ornament-top">✦ ✦ ✦</div>
            <h2 class="poem-title">${poem.title}</h2>
            <div class="poem-poet">${poem.poet || 'ناشناس'}</div>
            <div class="poem-content">${escapeHtml(poem.content)}</div>
            <div class="poem-ornament-bottom">✦ ✦ ✦</div>`;
            track.appendChild(card);

            // ── Dot ──
            const dot = document.createElement('button');
            dot.className = 'dot' + (globalIdx === 0 ? ' active' : '');
            dot.setAttribute('aria-label', `شعر ${globalIdx + 1}`);
            dot.addEventListener('click', () => goTo(globalIdx));
            dots.appendChild(dot);

            // ── TOC Item (قبل از sentinel) ──
            const item = document.createElement('div');
            item.className = 'toc-item' + (globalIdx === 0 ? ' active' : '');
            item.dataset.index = globalIdx;
            item.innerHTML = `
            <span class="toc-num">${toPersianNum(globalIdx + 1)}</span>
            <span class="toc-info">
                <span class="toc-title">${poem.title}</span>
                <span class="toc-poet">${poem.poet || 'ناشناس'}</span>
            </span>
            <span class="toc-arrow">◄</span>`;
            item.addEventListener('click', () => goTo(globalIdx));

            // قبل از sentinel درج کن
            const sentinel = document.getElementById('tocSentinel');
            tocList.insertBefore(item, sentinel);
        });

        if (isFirst) {
            document.getElementById('sliderTitle').textContent = catName;
            document.getElementById('sliderWrapper').classList.add('visible');
            updateSliderCounter();
            updateButtons();
            setupDrag();
            setupTocScroll();
        }

        updateSentinel();
    }

    // ══════════════════════════════════════════
    // SENTINEL  (نشانگر پایین فهرست برای infinite scroll)
    // ══════════════════════════════════════════
    function updateSentinel() {
        let sentinel = document.getElementById('tocSentinel');
        if (!sentinel) {
            sentinel = document.createElement('div');
            sentinel.id = 'tocSentinel';
            sentinel.className = 'toc-sentinel';
            document.getElementById('tocList').appendChild(sentinel);
            // ثبت IntersectionObserver روی sentinel
            tocObserver.observe(sentinel);
        }
        if (tocHasMore) {
            sentinel.innerHTML = `<span class="toc-load-dots"><i></i><i></i><i></i></span>`;
            sentinel.style.display = 'flex';
        } else {
            sentinel.innerHTML = `<span class="toc-end">✦ پایان فهرست ✦</span>`;
            sentinel.style.display = 'flex';
        }
    }

    // IntersectionObserver برای auto-load وقتی sentinel دیده می‌شود
    const tocObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && tocHasMore && !tocLoading && activeCatId) {
                loadPoemsPage(activeCatId, activeCatName, tocPage);
            }
        });
    }, {
        threshold: 0.1
    });

    // ══════════════════════════════════════════
    // TOC SCROLL SETUP
    // ══════════════════════════════════════════
    function setupTocScroll() {
        // اگر قبلاً ست شده بود دوباره نیاز نیست
        const tocList = document.getElementById('tocList');
        if (tocList.dataset.scrollSetup) return;
        tocList.dataset.scrollSetup = '1';
        // scroll روی tocList برای لود بیشتر (پشتیبان IntersectionObserver)
        tocList.addEventListener('scroll', () => {
            const {
                scrollTop,
                scrollHeight,
                clientHeight
            } = tocList;
            if (scrollHeight - scrollTop - clientHeight < 60 && tocHasMore && !tocLoading && activeCatId) {
                loadPoemsPage(activeCatId, activeCatName, tocPage);
            }
        });
    }

    // ══════════════════════════════════════════
    // SLIDE
    // ══════════════════════════════════════════
    function goTo(index) {
        currentIndex = Math.max(0, Math.min(index, loadedPoems.length - 1));
        const outer = document.querySelector('.slider-track-outer');
        const slideWidth = outer ? outer.offsetWidth : 0;
        document.getElementById('sliderTrack').style.transform = `translateX(${currentIndex * slideWidth}px)`;

        document.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === currentIndex));
        updateSliderCounter();

        // sync TOC
        document.querySelectorAll('.toc-item').forEach(item => {
            item.classList.toggle('active', parseInt(item.dataset.index) === currentIndex);
        });
        const activeItem = document.querySelector(`.toc-item[data-index="${currentIndex}"]`);
        if (activeItem) activeItem.scrollIntoView({
            block: 'nearest',
            behavior: 'smooth'
        });

        updateButtons();
    }

    function updateSliderCounter() {
        const loaded = loadedPoems.length;
        const total = totalPoems || loaded;
        document.getElementById('sliderCounter').textContent =
            `${toPersianNum(currentIndex + 1)} از ${toPersianNum(total)}`;
    }

    function updateButtons() {
        document.getElementById('btnPrev').disabled = currentIndex >= loadedPoems.length - 1;
        document.getElementById('btnNext').disabled = currentIndex <= 0;
    }

    document.getElementById('btnNext').addEventListener('click', () => goTo(currentIndex - 1));
    document.getElementById('btnPrev').addEventListener('click', () => goTo(currentIndex + 1));

    // ── SWIPE / DRAG ──
    function setupDrag() {
        const outer = document.querySelector('.slider-track-outer');
        if (outer.dataset.dragSetup) return;
        outer.dataset.dragSetup = '1';
        outer.addEventListener('pointerdown', onDown);
        outer.addEventListener('pointermove', onMove);
        outer.addEventListener('pointerup', onUp);
        outer.addEventListener('pointercancel', onUp);
        outer.style.touchAction = 'pan-y';
    }

    function onDown(e) {
        isDragging = true;
        dragStartX = e.clientX;
        dragDeltaX = 0;
        document.getElementById('sliderTrack').style.transition = 'none';
    }

    function onMove(e) {
        if (!isDragging) return;
        dragDeltaX = e.clientX - dragStartX;
    }

    function onUp() {
        if (!isDragging) return;
        isDragging = false;
        document.getElementById('sliderTrack').style.transition = '';
        if (dragDeltaX > 60) goTo(currentIndex + 1);
        else if (dragDeltaX < -60) goTo(currentIndex - 1);
        else goTo(currentIndex);
    }

    // ── RESIZE: recalculate slide position ──
    window.addEventListener('resize', () => {
        if (loadedPoems.length === 0) return;
        const outer = document.querySelector('.slider-track-outer');
        const slideWidth = outer ? outer.offsetWidth : 0;
        document.getElementById('sliderTrack').style.transition = 'none';
        document.getElementById('sliderTrack').style.transform = `translateX(${currentIndex * slideWidth}px)`;
        setTimeout(() => {
            document.getElementById('sliderTrack').style.transition = '';
        }, 50);
    });

    // ── KEYBOARD ──
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight') goTo(currentIndex + 1);
        if (e.key === 'ArrowLeft') goTo(currentIndex - 1);
    });

    // ══════════════════════════════════════════
    // BACK TO TOP BUTTON
    // ══════════════════════════════════════════
    (function() {
        const btn = document.getElementById('btnBackTop');
        // نمایش دکمه وقتی از header اسکرول شد
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.page-header');
            const threshold = header ? header.offsetHeight : 200;
            btn.classList.toggle('visible', window.scrollY > threshold);
        }, {
            passive: true
        });

        btn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            // پس از رسیدن به بالا، دسته‌بندی انتخابی را پاک کن
            setTimeout(() => {
                document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active'));
                document.getElementById('sliderWrapper').classList.remove('visible');
                document.getElementById('emptyState').classList.remove('visible');
                document.getElementById('divider').style.display = 'none';
                document.getElementById('poemLoader').classList.remove('visible');
                // reset state
                activeCatId = null;
                activeCatName = '';
                loadedPoems = [];
                currentIndex = 0;
            }, 600);
        });
    })();

    // ══════════════════════════════════════════
    // HELPERS
    // ══════════════════════════════════════════
    function escapeHtml(str) {
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function toPersianNum(n) {
        return String(n).replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹' [d]);
    }
    </script>

    <!-- BACK TO HOME -->
    <a href="index.php" class="btn-home" title="بازگشت به صفحه اصلی">
        <span class="btn-home-icon">🏠</span>
        <span class="btn-home-label">صفحه اصلی</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>