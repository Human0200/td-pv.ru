$(document).ready(function () {
  $('.mobilemenu__menu--regions').hide()
})
function rcH(s) {
  return String(s)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
}

function rcGetSiteAddress() {
  if (typeof arAllcorp3Options === 'undefined') return location.hostname
  var a = arAllcorp3Options['SITE_ADDRESS']
  if (!a) return location.hostname
  return typeof a === 'string' ? a : Array.isArray(a) ? a.join(',') : String(a)
}

function rcSelectCity(id, url) {
  var siteAddress = rcGetSiteAddress()
  var arDomains =
    siteAddress.indexOf(',') !== -1 ? siteAddress.split(',') : [siteAddress]
  arDomains.forEach(function (d) {
    d = d.replace(/[\n']/g, '').trim()
    if (!d) return
    $.removeCookie('current_region', { path: '/', domain: d })
  })
  arDomains.forEach(function (d) {
    d = d.replace(/[\n']/g, '').trim()
    if (!d) return
    $.cookie('current_region', id, { path: '/', domain: d })
  })
  sessionStorage.removeItem('rc_confirm_shown')
  location.href = url || location.href
}

function rcShowConfirm() {
  if (!RC.confirm.show) return

  // Проверяем, не открыто ли уже окно подтверждения
  if (document.getElementById('rc-confirm-overlay')) {
    return // Если окно уже есть - ничего не делаем
  }

  var overlay = document.createElement('div')
  overlay.className = 'rc-overlay'
  overlay.id = 'rc-confirm-overlay'
  overlay.onclick = function (e) {
    if (e.target === overlay) rcHideConfirm()
  }
  overlay.innerHTML =
    '<div class="rc-confirm">' +
    '<button class="rc-confirm__close-btn" onclick="rcHideConfirm()">×</button>' +
    '<div class="rc-confirm__city">' +
    rcH(RC.confirm.regionName) +
    '</div>' +
    '<div class="rc-confirm__question">Это ваш город?</div>' +
    '<div class="rc-confirm__btns">' +
    '<button class="rc-btn rc-btn--yes" onclick="rcConfirmYes()">Да</button>' +
    '<button class="rc-btn rc-btn--chg" onclick="rcHideConfirm();rcOpenModal()">Изменить</button>' +
    '</div>' +
    '</div>'
  document.body.appendChild(overlay)
}

function rcHideConfirm() {
  RC.confirm.show = false
  var el = document.getElementById('rc-confirm-overlay')
  if (el) el.remove()
}

function rcConfirmYes() {
  rcHideConfirm()
  rcSelectCity(RC.confirm.regionId, RC.confirm.regionUrl || location.href)
}

function rcShowNotice(msg) {
  if (!msg) return

  // не плодим окна
  if (document.getElementById('rc-notice-overlay')) return

  var overlay = document.createElement('div')
  overlay.className = 'rc-overlay'
  overlay.id = 'rc-notice-overlay'

  overlay.onclick = function (e) {
    if (e.target === overlay) rcHideNotice()
  }

  overlay.innerHTML =
    '<div class="rc-confirm">' +
    '<button class="rc-confirm__close-btn" onclick="rcHideNotice()">×</button>' +
    '<div class="rc-confirm__question">' +
    rcH(msg) +
    '</div>' +
    '<div class="rc-confirm__btns">' +
    '<button class="rc-btn rc-btn--yes" onclick="rcHideNotice()">Ок</button>' +
    '</div>' +
    '</div>'

  document.body.appendChild(overlay)
}

function rcHideNotice() {
  var el = document.getElementById('rc-notice-overlay')
  if (el) el.remove()
}

function rcInitNotice() {
  try {
    var msg = sessionStorage.getItem('rc_notice')
    if (!msg) return
    sessionStorage.removeItem('rc_notice')
    rcShowNotice(msg)
  } catch (e) {}
}

// показать после загрузки DOM
$(document).ready(function () {
  rcInitNotice()
})

function rcApplyAllowedCities(allowedIds) {
  if (typeof RC === 'undefined') return

  if (!RC._allCities) RC._allCities = (RC.cities || []).slice()
  if (!RC._allFavs) RC._allFavs = (RC.favs || []).slice()

  RC._filtered = Array.isArray(allowedIds) && allowedIds.length > 0

  // нет привязки у товара => все города
  if (!RC._filtered) {
    RC.cities = RC._allCities.slice()
    RC.favs = RC._allFavs.slice()
    return
  }

  var set = {}
  allowedIds.forEach(function (id) {
    id = parseInt(id, 10)
    if (id > 0) set[id] = true
  })

  // ВАЖНО: fallback город (НН) всегда должен быть доступен
  set[6157] = true

  RC.cities = RC._allCities.filter(function (c) {
    return !!set[c.id]
  })

  RC.favs = RC._allFavs.filter(function (f) {
    return !!set[f.id]
  })
}

function rcOpenModal(allowedIds) {
  // если не передали аргумент — берем ограничения страницы (карточки)
  if (!Array.isArray(allowedIds)) {
    allowedIds = window.RC_PAGE_ALLOWED_IDS
  }

  rcHideConfirm()

  // применяем фильтр (или сброс на полный список)
  rcApplyAllowedCities(allowedIds)

  // безопасная вставка url в onclick
  function rcJ(s) {
    return JSON.stringify(String(s || ''))
  }

  var existing = document.getElementById('rc-overlay')
  if (existing) {
    existing.style.display = 'flex'
    var inp = document.getElementById('rc-input')
    if (inp) {
      inp.value = ''
      rcSearch('')
      inp.focus()
    }
    return
  }

  // если список отфильтрован — секции не нужны
  var useSections = !RC._filtered && RC.sections1 && RC.sections1.length

  var col1 = ''
  if (useSections) {
    col1 =
      '<div class="rc-col" id="rc-col1"><div class="rc-col__title">' +
      (RC.sections2 && RC.sections2.length ? 'Округ' : 'Регион') +
      '</div>'
    RC.sections1.forEach(function (s) {
      col1 +=
        '<div class="rc-sec" data-id="' +
        s.id +
        '" data-lv="1" onclick="rcClickSec(this)">' +
        rcH(s.name) +
        '</div>'
    })
    col1 += '</div>'
  }

  var col2 = ''
  if (useSections && RC.sections2 && RC.sections2.length) {
    col2 =
      '<div class="rc-col" id="rc-col2"><div class="rc-col__title">Регион</div>'
    RC.sections2.forEach(function (p) {
      col2 += '<div data-pid="' + p.pid + '" style="display:none">'
      p.children.forEach(function (c) {
        col2 +=
          '<div class="rc-sec" data-id="' +
          c.id +
          '" data-lv="2" onclick="rcClickSec(this)">' +
          rcH(c.name) +
          '</div>'
      })
      col2 += '</div>'
    })
    col2 += '</div>'
  }

  var col3 =
    '<div class="rc-col" id="rc-col3"><div class="rc-col__title">Город</div>'

  RC.cities.forEach(function (c) {
    // если фильтр включён — показываем сразу
    var show = RC.flat || RC._filtered ? '' : ' style="display:none"'

    if (c.isCurrent) {
      col3 +=
        '<div data-sid="' +
        c.secId +
        '"' +
        show +
        '><span class="rc-city rc-city--cur">' +
        rcH(c.name) +
        '</span></div>'
    } else {
      col3 +=
        '<div data-sid="' +
        c.secId +
        '"' +
        show +
        '><a class="rc-city" href="javascript:void(0)" onclick="rcSelectCity(' +
        c.id +
        ',' +
        rcJ(c.url) +
        ')">' +
        rcH(c.name) +
        '</a></div>'
    }
  })
  col3 += '</div>'

  var favsHtml = ''
  if (RC.favs && RC.favs.length) {
    favsHtml = '<div class="rc-favs">'
    RC.favs.forEach(function (f) {
      favsHtml +=
        '<a href="javascript:void(0)" onclick="rcSelectCity(' +
        f.id +
        ',' +
        rcJ(f.url) +
        ')">' +
        rcH(f.name) +
        '</a>'
    })
    favsHtml += '</div>'
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
    '<div class="rc-modal__body">' +
    col1 +
    col2 +
    col3 +
    '</div>' +
    '</div>' +
    '</div>'

  var tmp = document.createElement('div')
  tmp.innerHTML = html
  document.body.appendChild(tmp.firstElementChild)

  setTimeout(function () {
    var inp = document.getElementById('rc-input')
    if (inp) inp.focus()
  }, 100)

  // Esc вешаем один раз
  if (!rcOpenModal._escBound) {
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') rcCloseModal()
    })
    rcOpenModal._escBound = true
  }
}

function rcCloseModal() {
  var o = document.getElementById('rc-overlay')
  if (o) o.style.display = 'none'
}

function rcSearch(val) {
  var q = val.trim().toLowerCase()
  var drop = document.getElementById('rc-drop')
  if (!drop) return
  drop.innerHTML = ''
  if (q.length < 2) {
    drop.classList.remove('is-open')
    return
  }
  var hits = RC.cities.filter(function (c) {
    return c.name.toLowerCase().indexOf(q) !== -1
  })
  if (!hits.length) {
    drop.innerHTML = '<div class="rc-drop-none">Ничего не найдено</div>'
  } else {
    hits.slice(0, 20).forEach(function (c) {
      var a = document.createElement('a')
      a.textContent = c.name
      a.href = 'javascript:void(0)'
      a.onclick = function () {
        rcSelectCity(c.id, c.url)
      }
      drop.appendChild(a)
    })
  }
  drop.classList.add('is-open')
}

function rcClickSec(el) {
  var lv = parseInt(el.dataset.lv)
  var sid = parseInt(el.dataset.id)
  el.closest('.rc-col')
    .querySelectorAll('.rc-sec')
    .forEach(function (s) {
      s.classList.remove('is-active')
    })
  el.classList.add('is-active')
  if (lv === 1) {
    var col2 = document.getElementById('rc-col2')
    if (col2)
      col2.querySelectorAll('[data-pid]').forEach(function (p) {
        p.style.display = parseInt(p.dataset.pid) === sid ? '' : 'none'
      })
    rcShowCities(-1)
  } else if (lv === 2) {
    rcShowCities(sid)
  }
}

function rcShowCities(sid) {
  var col3 = document.getElementById('rc-col3')
  if (!col3) return
  col3.querySelectorAll('[data-sid]').forEach(function (el) {
    el.style.display =
      sid === -1
        ? 'none'
        : parseInt(el.dataset.sid) === sid || sid === 0
          ? ''
          : 'none'
  })
}
