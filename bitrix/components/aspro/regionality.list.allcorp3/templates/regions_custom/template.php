<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if ($arResult['POPUP']) return;
if (!$arResult['CURRENT_REGION']) return;

use \Bitrix\Main\Localization\Loc;
global $arTheme;

$flat      = empty($arResult['SECTION_LEVEL1']) && empty($arResult['SECTION_LEVEL2']);
$currentId = $arResult['CURRENT_REGION']['ID'] ?? null;

$isSameDomain = (
    isset($arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_TYPE']['VALUE']) &&
    $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_TYPE']['VALUE'] === 'SUBDOMAIN' &&
    ($arResult['HOST'] . $_SERVER['HTTP_HOST'] . $arResult['URI'] === ($arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL'] ?? ''))
);

$jsRegions = \Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'REGIONALITY_SEARCH_ROW', 'N') != 'Y'
    ? CUtil::PhpToJsObject($arResult['JS_REGIONS'])
    : '{}';

$cities = [];
foreach (($arResult['REGIONS'] ?? []) as $city) {
    $cities[] = [
        'id'        => (int)$city['ID'],
        'name'      => $city['NAME'],
        'url'       => $city['URL'],
        'secId'     => (isset($city['IBLOCK_SECTION_ID']) && $city['IBLOCK_SECTION_ID']) ? (int)$city['IBLOCK_SECTION_ID'] : 0,
        'isCurrent' => ($currentId && $city['ID'] == $currentId),
    ];
}

$sections1 = [];
foreach (($arResult['SECTION_LEVEL1'] ?? []) as $sId => $sec) {
    $sections1[] = ['id' => (int)$sId, 'name' => $sec['NAME']];
}

$sections2 = [];
foreach (($arResult['SECTION_LEVEL2'] ?? []) as $pId => $secs) {
    $children = [];
    foreach ($secs as $sId2 => $sec2) {
        $children[] = ['id' => (int)$sId2, 'name' => $sec2['NAME']];
    }
    $sections2[] = ['pid' => (int)$pId, 'children' => $children];
}

$favs = [];
foreach (($arResult['FAVORITS'] ?? []) as $fav) {
    $favs[] = ['id' => (int)$fav['ID'], 'name' => $fav['NAME'], 'url' => $fav['URL']];
}

$confirmUrl = !$isSameDomain ? ($arResult['REGIONS'][$arResult['REAL_REGION']['ID']]['URL'] ?? '') : '';
?>
<style>
.rc-trigger {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    font-size: inherit;
    color: inherit;
    font-family: inherit;
    white-space: nowrap;
}
.rc-trigger__name {
    border-bottom: 1px dashed currentColor;
    line-height: 1.3;
}
.rc-trigger:hover .rc-trigger__name { opacity: .7; }
.rc-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    box-sizing: border-box;
}
.rc-confirm {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 16px 48px rgba(0,0,0,.22);
    padding: 32px 32px 28px;
    width: 360px;
    max-width: 100%;
    text-align: center;
    position: relative;
    animation: rcIn .15s ease;
}
.rc-confirm__city {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 6px;
    color: #111;
}
.rc-confirm__question {
    font-size: 15px;
    color: #666;
    margin-bottom: 24px;
}
.rc-confirm__btns {
    display: flex;
    gap: 10px;
    justify-content: center;
}
.rc-confirm__close-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    color: #999;
    padding: 0;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}
.rc-confirm__close-btn:hover { color: #333; }
.rc-modal {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 16px 60px rgba(0,0,0,.25);
    width: 820px;
    max-width: 100%;
    max-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
    animation: rcIn .15s ease;
}
@keyframes rcIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.rc-modal__close-btn {
    position: absolute;
    top: 20px;
    right: 24px;
    background: none;
    border: none;
    font-size: 32px;
    line-height: 1;
    cursor: pointer;
    color: #999;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 20;
}
.rc-modal__close-btn:hover { color: #333; }
.rc-modal__head { 
    padding: 24px 56px 12px 24px; 
    flex-shrink: 0; 
    position: relative;
}
.rc-search-wrap { position: relative; margin-bottom: 16px; }
.rc-search {
    display: flex; align-items: center;
    border: 1.5px solid #e5e7eb; border-radius: 12px;
    background: #fff; transition: border-color .15s;
}
.rc-search:focus-within { border-color: #2563eb; }
.rc-search input {
    flex: 1; border: none; outline: none;
    padding: 14px 16px; font-size: 16px;
    font-family: inherit; background: transparent;
}
.rc-search svg { margin: 0 8px 0 16px; color: #9ca3af; flex-shrink: 0; }
.rc-drop {
    display: none;
    position: absolute;
    top: calc(100% + 4px); left: 0; right: 0;
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,.12);
    z-index: 20; max-height: 260px; overflow-y: auto;
}
.rc-drop.is-open { display: block; }
.rc-drop a { display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 15px; }
.rc-drop a:hover { background: #f5f5f5; }
.rc-drop-none { padding: 12px 16px; color: #9ca3af; font-size: 15px; }
.rc-favs { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px; }
.rc-favs a {
    font-size: 14px; color: #2563eb; text-decoration: none;
    padding: 6px 14px; border-radius: 30px;
    border: 1px solid #bfdbfe; background: #eff6ff; transition: all .15s;
}
.rc-favs a:hover { background: #dbeafe; border-color: #2563eb; }
.rc-modal__body {
    display: flex; flex: 1; overflow: hidden;
    border-top: 1px solid #f0f0f0;
}
.rc-col { 
    flex: 1; overflow-y: auto; padding: 16px 20px; 
    border-right: 1px solid #f0f0f0; max-height: 380px;
}
.rc-col:last-child { border-right: none; }
.rc-col__title {
    font-size: 12px; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .05em;
    margin-bottom: 12px; position: sticky; top: 0;
    background: #fff; padding: 8px 0 4px;
}
.rc-sec { 
    padding: 10px 12px; font-size: 15px; color: #333; 
    border-radius: 8px; cursor: pointer; margin-bottom: 2px;
}
.rc-sec:hover, .rc-sec.is-active { background: #f3f4f6; color: #2563eb; font-weight: 500; }
.rc-city { 
    display: block; padding: 10px 12px; color: #333; 
    text-decoration: none; font-size: 15px; border-radius: 8px;
    margin-bottom: 2px; transition: background .15s;
}
.rc-city:hover { background: #f3f4f6; }
.rc-city--cur { color: #2563eb; font-weight: 600; background: #eff6ff; pointer-events: none; }
.rc-btn {
    padding: 12px 28px; border-radius: 10px; font-size: 15px;
    cursor: pointer; border: none; font-family: inherit;
    line-height: 1; font-weight: 500; transition: all .15s;
}
.rc-btn--yes { background: #2563eb; color: #fff; }
.rc-btn--yes:hover { background: #1d4ed8; }
.rc-btn--chg { background: #f3f4f6; color: #333; border: 1px solid #d1d5db; }
.rc-btn--chg:hover { background: #e5e7eb; }
.rc-col::-webkit-scrollbar { width: 4px; }
.rc-col::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

@media (max-width: 768px) {
    .rc-modal__head { padding: 20px 48px 8px 20px; }
    .rc-modal__close-btn { top: 16px; right: 20px; font-size: 30px; width: 30px; height: 30px; }
    .rc-search input { padding: 12px 14px; font-size: 15px; }
    .rc-favs a { font-size: 13px; padding: 5px 12px; }
    .rc-col { padding: 12px 16px; max-height: 300px; }
    .rc-col__title { font-size: 11px; margin-bottom: 8px; }
    .rc-sec, .rc-city { padding: 8px 10px; font-size: 14px; }
}

@media (max-width: 640px) {
    .rc-overlay { padding: 12px; }
    .rc-modal { border-radius: 20px; max-height: calc(100vh - 40px); }
    .rc-modal__head { padding: 18px 44px 8px 18px; }
    .rc-modal__close-btn { top: 14px; right: 18px; }
    .rc-modal__body { flex-direction: column; }
    .rc-col { 
        border-right: none; border-bottom: 1px solid #f0f0f0; 
        max-height: 200px; padding: 12px 16px;
    }
    .rc-col:last-child { border-bottom: none; }
}

@media (max-width: 480px) {
    .rc-overlay { padding: 0; align-items: flex-end; }
    .rc-modal { 
        border-radius: 24px 24px 0 0; width: 100%; 
        max-height: 85dvh; max-width: 100%;
    }
    .rc-modal__head { padding: 16px 40px 8px 16px; }
    .rc-modal__close-btn { top: 12px; right: 16px; font-size: 28px; width: 28px; height: 28px; }
    .rc-confirm { border-radius: 24px 24px 0 0; width: 100%; padding: 28px 20px 24px; }
    .rc-confirm__close-btn { top: 16px; right: 16px; }
    .rc-confirm__city { font-size: 20px; }
    .rc-confirm__question { font-size: 14px; margin-bottom: 20px; }
    .rc-search input { padding: 12px; font-size: 15px; }
    .rc-favs { gap: 6px; margin-top: 10px; }
    .rc-favs a { font-size: 12px; padding: 5px 10px; }
    .rc-col { max-height: 180px; padding: 10px 14px; }
    .rc-col__title { font-size: 10px; margin-bottom: 6px; }
    .rc-sec, .rc-city { padding: 8px 10px; font-size: 14px; }
    .rc-btn { padding: 10px 20px; font-size: 14px; }
}

@media (max-width: 360px) {
    .rc-modal__head { padding: 14px 36px 8px 14px; }
    .rc-modal__close-btn { top: 10px; right: 14px; }
    .rc-confirm { padding: 24px 16px 20px; }
    .rc-confirm__btns { flex-direction: column; gap: 8px; }
    .rc-btn { width: 100%; }
    .rc-col { max-height: 160px; }
}
</style>

<button class="rc-trigger" id="rc-trigger" type="button" onclick="rcOpenModal()">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
    </svg>
    <span class="rc-trigger__name"><?= htmlspecialcharsbx($arResult['CURRENT_REGION']['NAME']) ?></span>
</button>

<script>
var RC = {
    regions:   <?= $jsRegions ?>,
    cities:    <?= json_encode($cities, JSON_UNESCAPED_UNICODE) ?>,
    sections1: <?= json_encode($sections1, JSON_UNESCAPED_UNICODE) ?>,
    sections2: <?= json_encode($sections2, JSON_UNESCAPED_UNICODE) ?>,
    favs:      <?= json_encode($favs, JSON_UNESCAPED_UNICODE) ?>,
    flat:      <?= $flat ? 'true' : 'false' ?>,
    confirm: {
        show:       <?= $arResult['SHOW_REGION_CONFIRM'] ? 'true' : 'false' ?>,
        regionName: <?= json_encode($arResult['REAL_REGION']['NAME'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
        regionId:   <?= (int)($arResult['REAL_REGION']['ID'] ?? 0) ?>,
        regionUrl:  <?= json_encode($confirmUrl, JSON_UNESCAPED_UNICODE) ?>
    }
};

function rcH(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function rcGetSiteAddress() {
    if (typeof arAllcorp3Options === 'undefined') return location.hostname;
    var a = arAllcorp3Options['SITE_ADDRESS'];
    if (!a) return location.hostname;
    return typeof a === 'string' ? a : (Array.isArray(a) ? a.join(',') : String(a));
}

function rcSelectCity(id, url) {
    var siteAddress = rcGetSiteAddress();
    var arDomains = siteAddress.indexOf(',') !== -1 ? siteAddress.split(',') : [siteAddress];
    arDomains.forEach(function(d) {
        d = d.replace(/[\n']/g, '').trim();
        if (!d) return;
        $.removeCookie('current_region', { path: '/', domain: d });
    });
    arDomains.forEach(function(d) {
        d = d.replace(/[\n']/g, '').trim();
        if (!d) return;
        $.cookie('current_region', id, { path: '/', domain: d });
    });
    location.href = url || location.href;
}

function rcShowConfirm() {
    if (!RC.confirm.show) return;
    var overlay = document.createElement('div');
    overlay.className = 'rc-overlay';
    overlay.id = 'rc-confirm-overlay';
    overlay.onclick = function(e) {
        if (e.target === overlay) rcHideConfirm();
    };
    overlay.innerHTML =
        '<div class="rc-confirm">' +
            '<button class="rc-confirm__close-btn" onclick="rcHideConfirm()">×</button>' +
            '<div class="rc-confirm__city">' + rcH(RC.confirm.regionName) + '</div>' +
            '<div class="rc-confirm__question">Это ваш город?</div>' +
            '<div class="rc-confirm__btns">' +
                '<button class="rc-btn rc-btn--yes" onclick="rcConfirmYes()">Да</button>' +
                '<button class="rc-btn rc-btn--chg" onclick="rcHideConfirm();rcOpenModal()">Изменить</button>' +
            '</div>' +
        '</div>';
    document.body.appendChild(overlay);
}

function rcHideConfirm() {
    var el = document.getElementById('rc-confirm-overlay');
    if (el) el.remove();
}

function rcConfirmYes() {
    rcHideConfirm();
    rcSelectCity(RC.confirm.regionId, RC.confirm.regionUrl || location.href);
}

function rcOpenModal() {
    rcHideConfirm();
    var existing = document.getElementById('rc-overlay');
    if (existing) {
        existing.style.display = 'flex';
        var inp = document.getElementById('rc-input');
        if (inp) { inp.value = ''; rcSearch(''); inp.focus(); }
        return;
    }

    var col1 = '';
    if (RC.sections1.length) {
        col1 = '<div class="rc-col" id="rc-col1"><div class="rc-col__title">' +
            (RC.sections2.length ? 'Округ' : 'Регион') + '</div>';
        RC.sections1.forEach(function(s) {
            col1 += '<div class="rc-sec" data-id="' + s.id + '" data-lv="1" onclick="rcClickSec(this)">' + rcH(s.name) + '</div>';
        });
        col1 += '</div>';
    }

    var col2 = '';
    if (RC.sections2.length) {
        col2 = '<div class="rc-col" id="rc-col2"><div class="rc-col__title">Регион</div>';
        RC.sections2.forEach(function(p) {
            col2 += '<div data-pid="' + p.pid + '" style="display:none">';
            p.children.forEach(function(c) {
                col2 += '<div class="rc-sec" data-id="' + c.id + '" data-lv="2" onclick="rcClickSec(this)">' + rcH(c.name) + '</div>';
            });
            col2 += '</div>';
        });
        col2 += '</div>';
    }

    var col3 = '<div class="rc-col" id="rc-col3"><div class="rc-col__title">Город</div>';
    RC.cities.forEach(function(c) {
        var show = RC.flat ? '' : ' style="display:none"';
        if (c.isCurrent) {
            col3 += '<div data-sid="' + c.secId + '"' + show + '><span class="rc-city rc-city--cur">' + rcH(c.name) + '</span></div>';
        } else {
            col3 += '<div data-sid="' + c.secId + '"' + show + '>' +
                '<a class="rc-city" href="javascript:void(0)" onclick="rcSelectCity(' + c.id + ',\'' + rcH(c.url) + '\')">' + rcH(c.name) + '</a>' +
                '</div>';
        }
    });
    col3 += '</div>';

    var favsHtml = '';
    if (RC.favs.length) {
        favsHtml = '<div class="rc-favs">';
        RC.favs.forEach(function(f) {
            favsHtml += '<a href="javascript:void(0)" onclick="rcSelectCity(' + f.id + ',\'' + rcH(f.url) + '\')">' + rcH(f.name) + '</a>';
        });
        favsHtml += '</div>';
    }

    var html =
        '<div id="rc-overlay" class="rc-overlay" onclick="if(event.target===this)rcCloseModal()">' +
            '<div class="rc-modal">' +
                '<button class="rc-modal__close-btn" onclick="rcCloseModal()">×</button>' +
                '<div class="rc-modal__head">' +
                    '<div class="rc-search-wrap">' +
                        '<div class="rc-search">' +
                            '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' +
                                '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>' +
                            '</svg>' +
                            '<input id="rc-input" type="text" placeholder="Поиск города..." autocomplete="off" oninput="rcSearch(this.value)">' +
                        '</div>' +
                        '<div class="rc-drop" id="rc-drop"></div>' +
                    '</div>' +
                    favsHtml +
                '</div>' +
                '<div class="rc-modal__body">' + col1 + col2 + col3 + '</div>' +
            '</div>' +
        '</div>';

    var tmp = document.createElement('div');
    tmp.innerHTML = html;
    document.body.appendChild(tmp.firstElementChild);
    setTimeout(function() {
        var inp = document.getElementById('rc-input');
        if (inp) inp.focus();
    }, 100);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') rcCloseModal();
    });
}

function rcCloseModal() {
    var o = document.getElementById('rc-overlay');
    if (o) o.style.display = 'none';
}

function rcSearch(val) {
    var q = val.trim().toLowerCase();
    var drop = document.getElementById('rc-drop');
    if (!drop) return;
    drop.innerHTML = '';
    if (q.length < 2) { drop.classList.remove('is-open'); return; }
    var hits = RC.cities.filter(function(c) {
        return c.name.toLowerCase().indexOf(q) !== -1;
    });
    if (!hits.length) {
        drop.innerHTML = '<div class="rc-drop-none">Ничего не найдено</div>';
    } else {
        hits.slice(0, 20).forEach(function(c) {
            var a = document.createElement('a');
            a.textContent = c.name;
            a.href = 'javascript:void(0)';
            a.onclick = function() { rcSelectCity(c.id, c.url); };
            drop.appendChild(a);
        });
    }
    drop.classList.add('is-open');
}

function rcClickSec(el) {
    var lv  = parseInt(el.dataset.lv);
    var sid = parseInt(el.dataset.id);
    el.closest('.rc-col').querySelectorAll('.rc-sec').forEach(function(s) { s.classList.remove('is-active'); });
    el.classList.add('is-active');
    if (lv === 1) {
        var col2 = document.getElementById('rc-col2');
        if (col2) col2.querySelectorAll('[data-pid]').forEach(function(p) {
            p.style.display = parseInt(p.dataset.pid) === sid ? '' : 'none';
        });
        rcShowCities(-1);
    } else if (lv === 2) {
        rcShowCities(sid);
    }
}

function rcShowCities(sid) {
    var col3 = document.getElementById('rc-col3');
    if (!col3) return;
    col3.querySelectorAll('[data-sid]').forEach(function(el) {
        el.style.display = sid === -1 ? 'none'
            : (parseInt(el.dataset.sid) === sid || sid === 0 ? '' : 'none');
    });
}

rcShowConfirm();
</script>