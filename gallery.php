<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>گالری نقاشی</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- nanogallery2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/nanogallery2@3/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">

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
    }

    html, body {
        font-family: 'A Mashin Tahrir-Old', 'Tahoma', sans-serif;
        background-color: var(--gold);
        background-image: url("https://www.transparenttextures.com/patterns/french-stucco.png");
        color: var(--ink);
    }

    .kooch-img { position: fixed; top: 15%; left: 0; width: min(500px, 50vw); z-index: 0; mix-blend-mode: multiply; opacity: .12; pointer-events: none; }
    .khat-img { position: fixed; top: 0; left: 40%; width: min(600px, 60vw); z-index: 0; mix-blend-mode: multiply; opacity: .04; pointer-events: none; }

    .page-header { text-align: center; padding: 3rem 1rem 1.5rem; position: relative; z-index: 10; }
    .page-header h1 { font-size: clamp(2.5rem, 8vw, 5rem); color: var(--gold-deep); text-shadow: 1px 2px 0 rgba(255, 220, 100, .6), 0 4px 16px var(--shadow); margin: 0; }

    .cat-section { position: relative; z-index: 10; padding: 0 1rem 2rem; }
    .cat-grid { display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; gap: 1.5rem; max-width: 1200px; margin: 0 auto; }
    
    .parent-cat-card { cursor: pointer; background: rgba(255, 240, 180, .45); border: 2px solid rgba(177, 126, 9, .4); border-radius: 18px; padding: 1.2rem 0.5rem; text-align: center; transition: all .3s ease; backdrop-filter: blur(6px); box-shadow: 0 4px 15px var(--shadow); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; width: 150px; min-width: 140px; }
    .parent-cat-card img { width: 100px; height: 100px; object-fit: contain; border-radius: 0; }
    .parent-cat-card span { font-size: 3.5rem; display: flex; align-items: center; justify-content: center; width: 100px; height: 100px; }
    .parent-cat-card .cat-name { font-weight: bold; font-size: 1.3rem; color: var(--gold-deep); margin-top: 8px; }
    .parent-cat-card:hover { transform: translateY(-5px); background: rgba(255, 235, 150, .7); }
    .parent-cat-card.active { background: var(--gold-dark); border-color: var(--gold-deep); }
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
        grid-column: 1 / -1; 
        width: 100%; 
        max-width: 1000px; 
        margin-left: auto;
        margin-right: auto;
        background: rgba(255, 255, 255, 0.25); 
        border-radius: 20px; 
        backdrop-filter: blur(10px); 
    }
    #subCatSection.open { 
        max-height: 800px; /* افزایش برای اطمینان از جا شدن محتوا */
        opacity: 1; 
        margin-top: 1.5rem; 
        padding: 1.2rem;
        border-width: 1px;
    }
    .sub-cat-grid { display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; gap: 1rem; }
    
    @media (max-width: 768px) {
        .sub-cat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.6rem; }
        .cat-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
        .parent-cat-card img, .parent-cat-card span { width: 80px; height: 80px; }
        .parent-cat-card span { font-size: 2.5rem; }
    }
    
    .cat-card { cursor: pointer; background: rgba(255, 255, 255, .5); border: 1px solid rgba(177, 126, 9, .2); border-radius: 12px; padding: 1rem .8rem; text-align: center; transition: all .2s ease; }
    .cat-card:hover, .cat-card.active { background: white; border-color: var(--gold-dark); transform: scale(1.05); }
    .cat-card { cursor: pointer; background: rgba(255, 255, 255, .4); border: 1px solid rgba(177, 126, 9, .2); border-radius: 10px; padding: 1rem .8rem; text-align: center; transition: all .2s ease; font-size: 1.15rem; }
    .cat-card:hover, .cat-card.active { background: white; border-color: var(--gold-dark); transform: scale(1.03); box-shadow: 0 2px 8px var(--shadow); }
    .cat-name { font-weight: bold; margin-bottom: 4px; }

    .gallery-section { position: relative; z-index: 20; padding: 2rem clamp(.8rem, 3vw, 2rem) 4rem; max-width: 1400px; margin: 0 auto; }

    /* ── COMMENTS ── */
    .comment-card { background: rgba(255, 255, 255, 0.4); border-right: 4px solid var(--gold-deep); padding: 1rem; margin-bottom: 1rem; border-radius: 8px; text-align: right; }
    .admin-reply { background: rgba(219, 171, 56, 0.15); border-right: 4px solid var(--gold-dark); padding: 0.8rem; margin-top: 0.8rem; border-radius: 6px; font-size: 0.9rem; }

    .btn-home { position: fixed; bottom: 2rem; left: 2rem; z-index: 999; display: flex; align-items: center; gap: .5rem; padding: .6rem 1.1rem; border-radius: 2rem; border: 2px solid var(--gold-dark); background: rgba(219, 171, 56, .88); color: var(--gold-deep); font-weight: bold; text-decoration: none; }
    </style>
</head>

<body>
    <img class="kooch-img" src="assets/img/unnamed.jpg">
    <img class="khat-img" src="assets/img/r.jpeg">

    <header class="page-header"><h1>گالری نقاشی</h1></header>

    <section class="cat-section">
        <div class="cat-grid" id="catGrid">
            <div id="catLoader" style="grid-column:1/-1;text-align:center;padding:2rem 0;">در حال بارگذاری…</div>
        </div>
    </section>

    <section class="gallery-section">
        <div id="paintingGallery"></div>

        <!-- بخش نظرات -->
        <div id="commentSection" class="mt-5 bg-white bg-opacity-25 rounded-4 p-4 shadow-sm" style="display:none; max-width: 900px; margin: 2rem auto;">
            <h5 class="mb-4 text-end" id="commentTitle">نظرات این اثر</h5>
            <div id="commentsList" class="mb-4"></div>
            
            <div class="card bg-white bg-opacity-50 border-0 p-3 shadow-sm">
                <h6 class="mb-3 text-end">ارسال نظر جدید</h6>
                <form id="commentForm">
                    <input type="hidden" name="type" value="painting">
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
    </section>

    <a href="index.php" class="btn-home"><span>🏠</span><span>صفحه اصلی</span></a>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/nanogallery2@3/dist/jquery.nanogallery2.min.js"></script>

    <script>
    const API = 'gallery-api.php';
    let activeCatId = null;

    document.addEventListener('DOMContentLoaded', loadCategories);

    async function loadCategories() {
        try {
            const res = await fetch(`${API}?action=categories`);
            const json = await res.json();
            $("#catLoader").remove();
            if (json.success) renderCategories(json.data);
        } catch (e) { }
    }

    function renderCategories(allCats) {
        const grid = $("#catGrid");
        grid.empty();
        
        const parents = allCats.filter(c => !c.parent_id);
        const children = allCats.filter(c => c.parent_id);

        // ایجاد بخش زیردسته‌ها اگر وجود ندارد
        if ($("#subCatSection").length === 0) {
            $(".cat-section").append('<div id="subCatSection"><div class="sub-cat-grid"></div></div>');
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

            const pCard = $('<div class="parent-cat-card">').html(`${iconHtml} <div class="cat-name">${p.name}</div>`);
            
            pCard.click(() => {
                const isActive = pCard.hasClass("active");
                const subSection = $("#subCatSection");
                
                $(".parent-cat-card").removeClass("active");
                subSection.removeClass("open");

                if (!isActive) {
                    pCard.addClass("active");
                    const myChildren = children.filter(c => c.parent_id == p.id);
                    
                    if (myChildren.length > 0) {
                        const subGrid = subSection.find(".sub-cat-grid").empty();
                        myChildren.forEach(child => {
                            const cCard = $('<div class="cat-card">').html(`<div class="cat-name">${child.name}</div><div style="font-size:0.7rem;">${toPersianNum(child.count)} اثر</div>`);
                            cCard.click((e) => {
                                e.stopPropagation();
                                $(".cat-card").removeClass("active");
                                cCard.addClass("active");
                                loadPaintings(child.id);
                            });
                            subGrid.append(cCard);
                        });
                        subSection.addClass("open");
                    }
                    loadPaintings(p.id);
                }
            });

            grid.append(pCard);
        });
    }

    async function loadPaintings(catId) {
        try {
            const res = await fetch(`${API}?action=paintings&category_id=${catId}&per_page=100`);
            const json = await res.json();
            renderGallery(json.data);
        } catch (e) { }
    }

    function renderGallery(paintings) {
        const items = paintings.map(p => ({
            src: p.fullsize || p.thumb,
            srct: p.thumb,
            title: p.title,
            ID: p.id
        }));

        if ($("#paintingGallery").nanogallery2('instance')) {
            $("#paintingGallery").nanogallery2('destroy');
        }

        $("#paintingGallery").nanogallery2({
            items: items,
            thumbnailHeight: 250, thumbnailWidth: 'auto',
            thumbnailAlignment: 'fillWidth',
            thumbnailL1Label: { display: true, position: 'overImageOnBottom', align: 'right' },
            fnThumbnailClicked: function(item) {
                showCommentSection(item.title, item.ID);
            }
        });
    }

    function showCommentSection(title, id) {
        $("#commentTitle").text(`نظرات اثر: ${title}`);
        $("#commentContentId").val(id);
        $("#commentSection").show();
        loadComments('painting', id);
    }

    async function loadComments(type, id) {
        const list = document.getElementById('commentsList');
        list.innerHTML = '<div class="text-center opacity-50">در حال بارگذاری...</div>';
        try {
            const res = await fetch(`comment-api.php?action=list&type=${type}&content_id=${id}`);
            const json = await res.json();
            if (json.data && json.data.length) {
                list.innerHTML = json.data.map(c => `
                    <div class="comment-card">
                        <strong>${c.author}</strong>
                        <p class="mb-0 mt-1">${c.comment}</p>
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