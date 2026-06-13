<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>اشعار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

    /* ── CATEGORY GRID (Accordion) ── */
    .cat-section { position: relative; z-index: 10; padding: 0 1rem 2rem; }
    .cat-grid { display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; gap: 1.5rem; max-width: 1200px; margin: 0 auto; }
    
    .parent-cat-card { cursor: pointer; background: rgba(255, 240, 180, .45); border: 2px solid rgba(177, 126, 9, .4); border-radius: 18px; padding: 1.2rem 0.5rem; text-align: center; transition: all .3s ease; backdrop-filter: blur(6px); box-shadow: 0 4px 15px var(--shadow); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; height: 100%; width: 150px; min-width: 140px; }
    .parent-cat-card img { width: 100px; height: 100px; object-fit: contain; border-radius: 0; }
    .parent-cat-card span { font-size: 3.5rem; display: flex; align-items: center; justify-content: center; width: 100px; height: 100px; }
    .parent-cat-card .cat-name { font-weight: bold; font-size: 1.1rem; color: var(--gold-deep); margin-top: 5px; }
    .parent-cat-card:hover { transform: translateY(-5px); background: rgba(255, 235, 150, .7); }
    .parent-cat-card.active { background: var(--gold-dark); border-color: var(--gold-deep); color: white; }
    .parent-cat-card.active .cat-name { color: white; }

    /* بخش زیردسته‌ها با انیمیشن کامل */
    #subCatSection { 
        display: block; 
        max-height: 0; 
        overflow: hidden; 
        opacity: 0;
        margin-top: 0;
        padding: 0 1.2rem;
        border: 0px dashed var(--gold-dark);
        transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), 
                    opacity 0.4s ease, 
                    margin-top 0.4s ease, 
                    padding 0.4s ease,
                    border-width 0.2s ease;
        width: 100%; 
        max-width: 1000px; 
        margin-left: auto;
        margin-right: auto;
        background: rgba(255, 255, 255, 0.25); 
        border-radius: 20px; 
        backdrop-filter: blur(10px); 
    }
    #subCatSection.open { 
        max-height: 800px; 
        opacity: 1; 
        margin-top: 1.5rem; 
        padding: 1.2rem;
        border-width: 1px;
    }
    .sub-cat-grid { display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; gap: 0.8rem; }
    
    @media (max-width: 768px) {
        .sub-cat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem; }
        .cat-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
        .parent-cat-card img, .parent-cat-card span { width: 80px; height: 80px; }
        .parent-cat-card span { font-size: 2.5rem; }
    }
    
    .cat-card { cursor: pointer; background: rgba(255, 255, 255, .5); border: 1px solid rgba(177, 126, 9, .2); border-radius: 12px; padding: 0.8rem .5rem; text-align: center; transition: all .2s ease; font-size: 0.95rem; }
    .cat-card:hover, .cat-card.active { background: white; border-color: var(--gold-dark); transform: scale(1.05); }
    .cat-name { font-weight: bold; margin-bottom: 2px; }

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

    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); opacity: .4; }
        40% { transform: scale(1); opacity: 1; }
    }

    /* Slider wrapper */
    .slider-wrapper {
        display: none;
        max-width: 1100px;
        margin: 0 auto;
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
    }

    .slider-counter {
        font-size: .9rem;
        color: var(--gold-deep);
        background: rgba(255, 240, 180, .5);
        border: 1px solid rgba(177, 126, 9, .3);
        border-radius: 20px;
        padding: .2rem .8rem;
    }

    .slider-body {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 1.2rem;
        align-items: start;
    }

    @media (max-width: 700px) {
        .slider-body { grid-template-columns: 1fr; }
        .poem-toc { order: -1; }
    }

    /* ── POEM TOC ── */
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
        text-align: center;
    }

    .toc-list {
        overflow-y: auto;
        flex: 1;
        padding: .4rem 0;
    }

    .toc-item {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .55rem 1rem;
        cursor: pointer;
        border-right: 3px solid transparent;
        transition: all .2s;
    }

    .toc-item.active {
        background: rgba(255, 230, 120, .6);
        border-right-color: var(--gold-deep);
    }

    .toc-title {
        font-size: .95rem;
        color: var(--ink);
        display: block;
    }

    .toc-poet {
        font-size: .75rem;
        color: var(--gold-deep);
        opacity: .75;
        display: block;
    }

    /* ── POEM CARD ── */
    .slider-track-outer { overflow: hidden; border-radius: 18px; width: 100%; }
    .slider-track { display: flex; transition: transform .5s cubic-bezier(.4, 0, .2, 1); width: 100%; }
    .poem-card {
        min-width: 100%;
        width: 100%;
        background: rgba(255, 248, 220, .7);
        border: 1.5px solid rgba(177, 126, 9, .3);
        border-radius: 18px;
        padding: 2rem;
        box-shadow: 0 8px 32px var(--shadow);
        text-align: center;
    }

    .poem-title { font-size: 1.8rem; color: var(--gold-deep); margin-bottom: .5rem; }
    .poem-poet { color: var(--gold-dark); font-size: .95rem; margin-bottom: 1.5rem; }
    .poem-content { line-height: 2.1; font-size: 1.2rem; white-space: pre-line; color: var(--ink); }

    .slider-controls { display: flex; align-items: center; justify-content: center; gap: 1rem; margin-top: 1.4rem; }
    .slider-btn { width: 2.6rem; height: 2.6rem; border-radius: 50%; border: 2px solid var(--gold-dark); background: rgba(255, 240, 180, .5); cursor: pointer; color: var(--gold-deep); }
    .slider-btn:disabled { opacity: .35; cursor: not-allowed; }

    .btn-home { position: fixed; bottom: 2rem; left: 2rem; z-index: 999; display: flex; align-items: center; gap: .5rem; padding: .6rem 1.1rem; border-radius: 2rem; border: 2px solid var(--gold-dark); background: rgba(219, 171, 56, .88); backdrop-filter: blur(8px); box-shadow: 0 4px 18px var(--shadow); color: var(--gold-deep); font-weight: bold; text-decoration: none; }

    /* ── COMMENTS ── */
    .comment-card {
        background: rgba(255, 255, 255, 0.5);
        border-right: 4px solid var(--gold-deep);
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        text-align: right;
    }
    .admin-reply {
        background: rgba(219, 171, 56, 0.15);
        border-right: 4px solid var(--gold-dark);
        padding: 0.8rem;
        margin-top: 0.8rem;
        border-radius: 6px;
        font-size: 0.9rem;
    }
    </style>
</head>

<body>

    <img class="kooch-img" src="assets/img/unnamed.jpg" alt="">
    <img class="khat-img" src="assets/img/r.jpeg" alt="">

    <header class="page-header">
        <h1>اشعار</h1>
        <span class="header-ornament"></span>
    </header>

    <section class="cat-section">
        <div class="cat-grid" id="catGrid">
            <div class="text-center w-100 py-4" id="catLoader" style="grid-column:1/-1">
                <span style="color:var(--gold-deep);opacity:.6">در حال بارگذاری…</span>
            </div>
        </div>
    </section>

    <section class="poem-section">
        <div class="poem-loader" id="poemLoader">
            <div class="loader-dot"></div><div class="loader-dot"></div><div class="loader-dot"></div>
        </div>

        <div class="empty-state" id="emptyState" style="display:none; text-align:center;">شعری در این دسته یافت نشد</div>

        <div class="slider-wrapper" id="sliderWrapper">
            <div class="slider-header">
                <span class="slider-cat-title" id="sliderTitle"></span>
                <span class="slider-counter" id="sliderCounter"></span>
            </div>
            <div class="slider-body">
                <div class="poem-toc">
                    <div class="toc-header">فهرست اشعار</div>
                    <div class="toc-list" id="tocList"></div>
                </div>
                <div>
                    <div class="slider-track-outer">
                        <div class="slider-track" id="sliderTrack"></div>
                    </div>
                    <div class="slider-controls">
                        <button class="slider-btn" id="btnPrev">&#8250;</button>
                        <button class="slider-btn" id="btnNext">&#8249;</button>
                    </div>

                    <!-- بخش نظرات -->
                    <div id="commentSection" class="mt-5 bg-white bg-opacity-25 rounded-4 p-4 shadow-sm" style="display:none;">
                        <h5 class="mb-4 text-end"><i class="bi bi-chat-text me-2"></i>نظرات کاربران</h5>
                        <div id="commentsList" class="mb-4"></div>
                        
                        <div class="card bg-white bg-opacity-50 border-0 p-3 shadow-sm">
                            <h6 class="mb-3 text-end">ارسال نظر جدید</h6>
                            <form id="commentForm">
                                <input type="hidden" name="type" value="poem">
                                <input type="hidden" name="content_id" id="commentContentId">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="author" class="form-control" placeholder="نام شما" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <textarea name="comment" class="form-control" rows="3" placeholder="متن نظر شما..." required></textarea>
                                    </div>
                                </div>
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary" id="btnSendComment">ارسال نظر</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <a href="index.php" class="btn-home">
        <span>🏠</span>
        <span>صفحه اصلی</span>
    </a>

    <script>
    const API = 'api.php';
    let currentIndex = 0;
    let loadedPoems = [];
    let activeCatId = null;

    document.addEventListener('DOMContentLoaded', loadCategories);

    async function loadCategories() {
        try {
            const res = await fetch(`${API}?action=categories`);
            const json = await res.json();
            document.getElementById('catLoader').remove();
            if (json.success) renderCategories(json.data);
        } catch (e) { }
    }

    function renderCategories(allCats) {
        const grid = document.getElementById('catGrid');
        grid.innerHTML = '';
        
        const parents = allCats.filter(c => !c.parent_id);
        const children = allCats.filter(c => c.parent_id);

        // ایجاد بخش زیردسته‌ها اگر وجود ندارد
        let subSection = document.getElementById('subCatSection');
        if (!subSection) {
            subSection = document.createElement('div');
            subSection.id = 'subCatSection';
            subSection.innerHTML = '<div class="sub-cat-grid"></div>';
            document.querySelector('.cat-section').appendChild(subSection);
        }

        parents.forEach(p => {
            let iconHtml = '';
            if (p.icon) {
                if (p.icon.includes('assets/')) {
                    iconHtml = `<img src="${p.icon}" alt="">`;
                } else {
                    iconHtml = `<span>${p.icon}</span>`;
                }
            }

            const pCard = document.createElement('div');
            pCard.className = 'parent-cat-card';
            pCard.innerHTML = `${iconHtml} <div class="cat-name">${p.name}</div>`;
            
            pCard.onclick = () => {
                const isActive = pCard.classList.contains('active');
                document.querySelectorAll('.parent-cat-card').forEach(c => c.classList.remove('active'));
                subSection.classList.remove('open');

                if (!isActive) {
                    pCard.classList.add('active');
                    const myChildren = children.filter(c => c.parent_id == p.id);
                    
                    if (myChildren.length > 0) {
                        const subGrid = subSection.querySelector('.sub-cat-grid');
                        subGrid.innerHTML = '';
                        myChildren.forEach(child => {
                            const cCard = document.createElement('div');
                            cCard.className = 'cat-card';
                            cCard.innerHTML = `<div class="cat-name">${child.name}</div><div class="cat-count">${toPersianNum(child.count)} شعر</div>`;
                            cCard.onclick = (e) => {
                                e.stopPropagation();
                                document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active'));
                                cCard.classList.add('active');
                                activeCatId = child.id;
                                document.getElementById('poemLoader').classList.add('visible');
                                document.getElementById('sliderWrapper').classList.remove('visible');
                                loadPoems(child.id, child.name);
                            };
                            subGrid.appendChild(cCard);
                        });
                        subSection.classList.add('open');
                    }
                    // لود تمام اشعار دسته مادر
                    activeCatId = p.id;
                    document.getElementById('poemLoader').classList.add('visible');
                    document.getElementById('sliderWrapper').classList.remove('visible');
                    loadPoems(p.id, p.name);
                }
            };

            grid.appendChild(pCard);
        });
    }

    async function loadPoems(catId, catName) {
        try {
            const res = await fetch(`${API}?action=poems&category_id=${catId}&per_page=50`);
            const json = await res.json();
            loadedPoems = json.data;
            renderPoems(catName);
        } catch (e) { }
    }

    function renderPoems(catName) {
        document.getElementById('poemLoader').classList.remove('visible');
        document.getElementById('sliderWrapper').classList.add('visible');
        document.getElementById('sliderTitle').textContent = catName;
        
        const track = document.getElementById('sliderTrack');
        const toc = document.getElementById('tocList');
        track.innerHTML = '';
        toc.innerHTML = '';

        loadedPoems.forEach((poem, idx) => {
            const card = document.createElement('div');
            card.className = 'poem-card';
            card.innerHTML = `<h2 class="poem-title">${poem.title}</h2><div class="poem-poet">${poem.poet || 'ناشناس'}</div><div class="poem-content">${poem.content}</div>`;
            track.appendChild(card);

            const item = document.createElement('div');
            item.className = 'toc-item' + (idx === 0 ? ' active' : '');
            item.innerHTML = `<span class="toc-title">${poem.title}</span><span class="toc-poet">${poem.poet || ''}</span>`;
            item.onclick = () => goTo(idx);
            toc.appendChild(item);
        });

        goTo(0);
    }

    function goTo(idx) {
        currentIndex = idx;
        const width = document.querySelector('.slider-track-outer').offsetWidth;
        document.getElementById('sliderTrack').style.transform = `translateX(${idx * width}px)`;
        
        document.querySelectorAll('.toc-item').forEach((it, i) => it.classList.toggle('active', i === idx));
        document.getElementById('sliderCounter').textContent = `${toPersianNum(idx + 1)} از ${toPersianNum(loadedPoems.length)}`;
        
        document.getElementById('btnPrev').disabled = idx >= loadedPoems.length - 1;
        document.getElementById('btnNext').disabled = idx <= 0;

        loadComments('poem', loadedPoems[idx].id);
    }

    document.getElementById('btnNext').onclick = () => goTo(currentIndex - 1);
    document.getElementById('btnPrev').onclick = () => goTo(currentIndex + 1);

    async function loadComments(type, id) {
        const list = document.getElementById('commentsList');
        document.getElementById('commentContentId').value = id;
        document.getElementById('commentSection').style.display = 'block';
        list.innerHTML = '<div class="text-center opacity-50">در حال بارگذاری...</div>';

        try {
            const res = await fetch(`comment-api.php?action=list&type=${type}&content_id=${id}`);
            const json = await res.json();
            if (json.data && json.data.length) {
                list.innerHTML = json.data.map(c => `
                    <div class="comment-card">
                        <div class="d-flex justify-content-between mb-2"><strong>${c.author}</strong></div>
                        <div>${c.comment}</div>
                        ${c.reply ? `<div class="admin-reply"><strong>پاسخ مدیر:</strong><br>${c.reply}</div>` : ''}
                    </div>
                `).join('');
            } else {
                list.innerHTML = '<div class="text-center py-3 opacity-50">نظری ثبت نشده است.</div>';
            }
        } catch (e) { }
    }

    document.getElementById('commentForm').onsubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        try {
            const res = await fetch('comment-api.php?action=send', { method: 'POST', body: formData });
            const json = await res.json();
            alert(json.message);
            if (json.success) e.target.reset();
        } catch (e) { }
    };

    function toPersianNum(n) { return String(n).replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]); }
    </script>
</body>
</html>