<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>گالری نقاشی</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- VNS Gallery CSS -->
    <link rel="stylesheet" href="dist/vns-gallery.min.css">

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
        --shadow: rgba(90, 50, 0, .25);
        --card-bg: rgba(255, 248, 210, .65);
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

    /* ── WATERMARKS ── */
    .kooch-img {
        position: fixed;
        top: 15%;
        left: 0;
        width: min(500px, 50vw);
        z-index: 0;
        mix-blend-mode: multiply;
        opacity: .12;
        pointer-events: none;
    }

    .khat-img {
        position: fixed;
        top: 0;
        left: 40%;
        width: min(600px, 60vw);
        z-index: 0;
        mix-blend-mode: multiply;
        opacity: .04;
        pointer-events: none;
    }

    /* ── HEADER ── */
    .page-header {
        text-align: center;
        padding: 3rem 1rem 1.5rem;
        position: relative;
        z-index: 1;
    }

    .page-header h1 {
        font-size: clamp(2.5rem, 8vw, 5rem);
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

    /* ── CATEGORY GRID ── */
    .cat-section {
        position: relative;
        z-index: 1;
        padding: 0 1rem 2rem;
    }

    .cat-section-title {
        text-align: center;
        font-size: 1.05rem;
        color: var(--gold-deep);
        opacity: .75;
        letter-spacing: .1em;
        margin-bottom: 1.5rem;
    }

    .cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: .9rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .cat-card {
        position: relative;
        cursor: pointer;
        background: rgba(255, 240, 180, .35);
        border: 2px solid rgba(177, 126, 9, .35);
        border-radius: 12px;
        padding: 1.2rem .8rem .9rem;
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
        background: rgba(255, 230, 140, .8);
        border-color: var(--gold-deep);
        box-shadow: 0 8px 24px var(--shadow), inset 0 0 0 1px rgba(255, 220, 100, .6);
        transform: translateY(-3px);
    }

    .cat-icon {
        font-size: 1.9rem;
        line-height: 1;
        margin-bottom: .4rem;
        display: block;
    }

    .cat-name {
        font-size: 1.05rem;
        font-weight: bold;
        color: var(--ink);
    }

    .cat-count {
        font-size: .75rem;
        color: var(--gold-deep);
        margin-top: .2rem;
        opacity: .8;
    }

    /* ── DIVIDER ── */
    .section-divider {
        max-width: 500px;
        margin: 0 auto 1.8rem;
        display: none;
        align-items: center;
        gap: .8rem;
        padding: 0 1rem;
    }

    .section-divider.visible {
        display: flex;
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

    /* ── GALLERY SECTION ── */
    .gallery-section {
        position: relative;
        z-index: 1;
        padding: 0 clamp(.8rem, 3vw, 2rem) 4rem;
        max-width: 1300px;
        margin: 0 auto;
    }

    /* ── GALLERY HEADER bar ── */
    .gallery-topbar {
        display: none;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .6rem;
        margin-bottom: 1.2rem;
    }

    .gallery-topbar.visible {
        display: flex;
    }

    .gallery-cat-title {
        font-size: 1.45rem;
        color: var(--gold-deep);
        text-shadow: 0 1px 3px var(--shadow);
    }

    .gallery-meta {
        font-size: .85rem;
        color: var(--gold-deep);
        opacity: .75;
        background: rgba(255, 240, 180, .5);
        border: 1px solid rgba(177, 126, 9, .3);
        border-radius: 20px;
        padding: .25rem .9rem;
    }

    /* ── LOADER ── */
    .gallery-loader {
        display: none;
        justify-content: center;
        align-items: center;
        height: 180px;
        gap: 8px;
    }

    .gallery-loader.visible {
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

    /* ── EMPTY STATE ── */
    .empty-state {
        display: none;
        text-align: center;
        padding: 3rem 1rem;
        color: var(--gold-deep);
        font-size: 1.2rem;
        opacity: .7;
    }

    .empty-state.visible {
        display: block;
    }

    /* ── VNS Gallery wrapper ── */
    #paintingGallery {
        display: none;
    }

    #paintingGallery.visible {
        display: block;
    }

    /* ── Override VNS theme to match gold palette ── */
    .vns-gallery-container {
        --vns-primary: var(--gold-dark);
    }

    .vns-gallery-item img {
        border-radius: 8px;
        border: 2px solid rgba(177, 126, 9, .25);
        transition: border-color .2s, transform .2s;
    }

    .vns-gallery-item:hover img {
        border-color: var(--gold-dark);
        transform: scale(1.02);
    }

    /* ── LOAD MORE indicator at bottom of gallery ── */
    .gallery-load-more {
        display: none;
        justify-content: center;
        padding: 1.2rem 0 .5rem;
    }

    .gallery-load-more.visible {
        display: flex;
    }

    .gallery-load-more-dots {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .gallery-load-more-dots i {
        display: block;
        width: 8px;
        height: 8px;
        background: var(--gold-deep);
        border-radius: 50%;
        animation: bounce 1.1s infinite ease-in-out;
        font-style: normal;
    }

    .gallery-load-more-dots i:nth-child(2) {
        animation-delay: .15s;
    }

    .gallery-load-more-dots i:nth-child(3) {
        animation-delay: .3s;
    }

    .gallery-end-msg {
        font-size: .8rem;
        color: var(--gold-deep);
        opacity: .45;
        letter-spacing: .12em;
    }

    /* ── HOME BUTTON ── */
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
    }

    @media(max-width:500px) {
        .btn-home span.btn-home-label {
            display: none;
        }

        .btn-home {
            padding: .65rem .8rem;
            border-radius: 50%;
        }
    }

    @media(max-width:480px) {
        .cat-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: .5rem;
        }
    }
    </style>
</head>

<body>

    <img class="kooch-img" src="assets/img/unnamed.jpg" alt="">
    <img class="khat-img" src="assets/img/r.jpeg" alt="">

    <!-- HEADER -->
    <header class="page-header">
        <h1>گالری نقاشی</h1>
        <span class="header-ornament"></span>
    </header>

    <!-- CATEGORIES -->
    <section class="cat-section">
        <p class="cat-section-title">دسته‌بندی</p>
        <div class="cat-grid" id="catGrid">
            <div id="catLoader" style="grid-column:1/-1;text-align:center;padding:2rem 0;">
                <span style="color:var(--gold-deep);opacity:.6">در حال بارگذاری…</span>
            </div>
        </div>
    </section>

    <!-- DIVIDER -->
    <div class="section-divider" id="divider">
        <span></span><span class="diamond">◆</span><span></span>
    </div>

    <!-- GALLERY -->
    <section class="gallery-section">

        <div class="gallery-loader" id="galleryLoader">
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
        </div>

        <div class="empty-state" id="emptyState">نقاشی‌ای در این دسته یافت نشد</div>

        <div class="gallery-topbar" id="galleryTopbar">
            <span class="gallery-cat-title" id="galleryCatTitle"></span>
            <span class="gallery-meta" id="galleryMeta"></span>
        </div>

        <!-- VNS Gallery container — images injected by JS -->
        <div id="paintingGallery"></div>

        <!-- Load more indicator -->
        <div class="gallery-load-more" id="galleryLoadMore">
            <div class="gallery-load-more-dots"><i></i><i></i><i></i></div>
        </div>
        <div style="text-align:center;padding:.5rem 0 0;" id="galleryEndMsg" class="gallery-end-msg"
            style="display:none"></div>

    </section>

    <!-- HOME BUTTON -->
    <a href="index.html" class="btn-home" title="بازگشت به صفحه اصلی">
        <span style="font-size:1.1rem">🏠</span>
        <span class="btn-home-label">صفحه اصلی</span>
    </a>

    <!-- jQuery (required by VNS Gallery) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- VNS Gallery JS -->
    <script src="dist/vns-gallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // ══════════════════════════════════════════
    // CONFIG
    // ══════════════════════════════════════════
    const GALLERY_API = 'gallery_api.php';
    const PER_PAGE = 12; // تعداد نقاشی در هر بار بارگذاری

    // ══════════════════════════════════════════
    // STATE
    // ══════════════════════════════════════════
    let activeCatId = null;
    let activeCatName = '';
    let currentPage = 1;
    let totalCount = 0;
    let hasMore = false;
    let isLoading = false;
    let vnsInstance = null; // نمونه پلاگین VNS Gallery

    // ══════════════════════════════════════════
    // INIT
    // ══════════════════════════════════════════
    document.addEventListener('DOMContentLoaded', loadCategories);

    // ══════════════════════════════════════════
    // CATEGORIES
    // ══════════════════════════════════════════
    async function loadCategories() {
        try {
            const res = await fetch(`${GALLERY_API}?action=categories`);
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
            card.innerHTML = `
            <span class="cat-icon">${cat.icon || '🎨'}</span>
            <div class="cat-name">${cat.name}</div>
            <div class="cat-count">${toPersianNum(cat.count)} اثر</div>`;
            card.addEventListener('click', () => selectCategory(card, cat));
            grid.appendChild(card);
        });
    }

    // ══════════════════════════════════════════
    // SELECT CATEGORY
    // ══════════════════════════════════════════
    function selectCategory(card, cat) {
        document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        activeCatId = cat.id;
        activeCatName = cat.name;
        currentPage = 1;
        totalCount = 0;
        hasMore = false;

        // reset UI
        document.getElementById('galleryLoader').classList.add('visible');
        document.getElementById('paintingGallery').classList.remove('visible');
        document.getElementById('emptyState').classList.remove('visible');
        document.getElementById('galleryTopbar').classList.remove('visible');
        document.getElementById('galleryLoadMore').classList.remove('visible');
        document.getElementById('galleryEndMsg').style.display = 'none';
        document.getElementById('divider').classList.add('visible');
        document.getElementById('paintingGallery').innerHTML = '';

        // destroy قبلی
        if (vnsInstance) {
            try {
                vnsInstance.destroy();
            } catch (e) {}
            vnsInstance = null;
        }

        setTimeout(() => {
            document.querySelector('.gallery-section').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 120);

        loadPaintings(cat.id, cat.name, 1, true);
    }

    // ══════════════════════════════════════════
    // LOAD PAINTINGS (AJAX paginated)
    // ══════════════════════════════════════════
    async function loadPaintings(catId, catName, page, isFirst = false) {
        if (isLoading) return;
        isLoading = true;

        if (!isFirst) {
            document.getElementById('galleryLoadMore').classList.add('visible');
        }

        try {
            const res = await fetch(
                `${GALLERY_API}?action=paintings&category_id=${catId}&page=${page}&per_page=${PER_PAGE}`);
            const json = await res.json();

            if (!json.success) throw new Error('api error');

            totalCount = json.total;
            hasMore = json.has_more;
            currentPage = page + 1;

            document.getElementById('galleryLoader').classList.remove('visible');
            document.getElementById('galleryLoadMore').classList.remove('visible');

            if (isFirst && json.data.length === 0) {
                document.getElementById('emptyState').classList.add('visible');
                isLoading = false;
                return;
            }

            appendPaintings(json.data, isFirst, catName);

        } catch (e) {
            document.getElementById('galleryLoader').classList.remove('visible');
            document.getElementById('galleryLoadMore').classList.remove('visible');
            if (isFirst) {
                document.getElementById('emptyState').textContent = 'خطا در بارگذاری';
                document.getElementById('emptyState').classList.add('visible');
            }
        }

        isLoading = false;
        updateEndState();
    }

    // ══════════════════════════════════════════
    // APPEND PAINTINGS → DOM + VNS refresh
    // ══════════════════════════════════════════
    function appendPaintings(paintings, isFirst, catName) {
        const container = document.getElementById('paintingGallery');

        paintings.forEach(p => {
            const img = document.createElement('img');
            img.src = p.thumb;
            img.dataset.fullsize = p.fullsize || p.thumb;
            img.alt = p.title;
            // caption کامل برای lightbox
            img.title =
                `${p.title}${p.technique ? ' — ' + p.technique : ''}${p.year ? ' (' + p.year + ')' : ''}`;
            container.appendChild(img);
        });

        if (isFirst) {
            // اولین بار: init پلاگین
            vnsInstance = $(container).vnsGallery({
                useCarousel: false, // گرید ثابت — carousel نمی‌خواهیم
                maxImages: null, // همه نمایش داده شوند
                showAllButton: false,
                showNavigation: true,
                showCounter: true,
                enableKeyboard: true,
                enableDrag: true,
                hoverEffect: true,
                captions: true,
                captionSelector: 'img',
                captionType: 'attr',
                captionsData: 'title',
                captionPosition: 'outside-center',
                prevText: '→',
                nextText: '←',
                responsive: {
                    0: {
                        columns: 2,
                        modalColumns: 1
                    },
                    576: {
                        columns: 3,
                        modalColumns: 2
                    },
                    992: {
                        columns: 4,
                        modalColumns: 3
                    },
                    1200: {
                        columns: 5,
                        modalColumns: 4
                    },
                },
            });

            // topbar
            document.getElementById('galleryCatTitle').textContent = catName;
            updateGalleryMeta();
            document.getElementById('galleryTopbar').classList.add('visible');
            container.classList.add('visible');

        } else {
            // صفحات بعدی: refresh پلاگین تا تصاویر جدید را بگیرد
            if (vnsInstance) {
                try {
                    vnsInstance.refresh();
                } catch (e) {}
            }
            updateGalleryMeta();
        }
    }

    // ══════════════════════════════════════════
    // INFINITE SCROLL  (scroll صفحه اصلی)
    // ══════════════════════════════════════════
    window.addEventListener('scroll', () => {
        if (!hasMore || isLoading || !activeCatId) return;
        const endMsg = document.getElementById('galleryEndMsg');
        const scrollBottom = window.scrollY + window.innerHeight;
        const docHeight = document.documentElement.scrollHeight;
        if (docHeight - scrollBottom < 300) {
            loadPaintings(activeCatId, activeCatName, currentPage);
        }
    }, {
        passive: true
    });

    // ══════════════════════════════════════════
    // HELPERS
    // ══════════════════════════════════════════
    function updateGalleryMeta() {
        const loaded = document.getElementById('paintingGallery').querySelectorAll('img').length;
        const total = totalCount || loaded;
        document.getElementById('galleryMeta').textContent =
            `${toPersianNum(loaded)} از ${toPersianNum(total)} اثر`;
    }

    function updateEndState() {
        const endMsg = document.getElementById('galleryEndMsg');
        if (!hasMore && activeCatId) {
            endMsg.textContent = '✦  پایان گالری  ✦';
            endMsg.style.display = 'block';
        } else {
            endMsg.style.display = 'none';
        }
    }

    function toPersianNum(n) {
        return String(n).replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹' [d]);
    }
    </script>

</body>

</html>