const state = {
  lang: localStorage.getItem('siteLang') || 'pt',
  theme: localStorage.getItem('siteTheme') || 'light'
}

function applyLanguage(lang) {
  document.documentElement.lang = lang === 'pt' ? 'pt-PT' : 'en'
  document.querySelectorAll('[data-pt]').forEach(el => {
    el.textContent = el.dataset[lang]
  })
  document.querySelectorAll('[data-placeholder-pt]').forEach(el => {
    el.placeholder = el.dataset[`placeholder${lang === 'pt' ? 'Pt' : 'En'}`]
  })
  const langBtn = document.getElementById('langToggle')
  if (langBtn) {
    langBtn.textContent = lang === 'pt' ? 'EN' : 'PT'
    langBtn.setAttribute('aria-label', lang === 'pt' ? 'Switch to English' : 'Mudar para português')
  }
  state.lang = lang
  localStorage.setItem('siteLang', lang)
  renderVisitCount()
  setupNumberValidation()
}

function applyTheme(theme) {
  document.body.classList.toggle('dark', theme === 'dark')
  const themeBtn = document.getElementById('themeToggle')
  if (themeBtn) {
    themeBtn.textContent = theme === 'dark' ? '☀️' : '🌙'
  }
  state.theme = theme
  localStorage.setItem('siteTheme', theme)
}

function setupToggles() {
  const langBtn = document.getElementById('langToggle')
  const themeBtn = document.getElementById('themeToggle')
  if (langBtn) {
    langBtn.addEventListener('click', () => {
      applyLanguage(state.lang === 'pt' ? 'en' : 'pt')
    })
  }
  if (themeBtn) {
    themeBtn.addEventListener('click', () => {
      applyTheme(state.theme === 'light' ? 'dark' : 'light')
    })
  }
}

function renderVisitCount() {
  const pageKey = `visits:${location.pathname.split('/').pop() || 'index.php'}`
  const visits = Number(localStorage.getItem(pageKey) || '0')
  const box = document.getElementById('visitCount')
  if (box) {
    const label = state.lang === 'pt' ? 'Visitas: ' : 'Visits: '
    box.textContent = label + visits
  }
}

function setupVisits() {
  const pageKey = `visits:${location.pathname.split('/').pop() || 'index.php'}`
  const visits = Number(localStorage.getItem(pageKey) || '0') + 1
  localStorage.setItem(pageKey, String(visits))
  renderVisitCount()
}

function validatePhone(number) {
  if (!/^\d{9}$/.test(number)) return false

  if (!['91', '92', '93', '96'].includes(number.slice(0, 2))) return false

  return true
}

function setupNumberValidation() {
  const input = document.getElementById('number')
  const output = document.getElementById('numberMessage')
  if (!input || !output) return

  const render = () => {
    const value = input.value.trim()

    if (!value) {
      output.textContent = ''
      output.className = 'validation'
      return
    }

    if (value.length < 9) {
      output.textContent = ''
      output.className = 'validation'
      return
    }

    const ok = validatePhone(value)
    output.textContent = state.lang === 'pt'
      ? ok ? 'Número de telemóvel com formato válido.' : 'Número de telemóvel inválido. Use 9 dígitos válidos.'
      : ok ? 'Valid phone number format.' : 'Invalid phone number. Use 9 valid digits.'
    output.className = `validation ${ok ? 'valid' : 'invalid'}`
  }

  if (input.dataset.bound !== 'yes') {
    input.addEventListener('input', render)
    input.dataset.bound = 'yes'
  }
  render()
}

function setupGalleryModal() {
  const modal = document.getElementById('imageModal')
  const modalImg = document.getElementById('modalImage')
  const modalCaption = document.getElementById('modalCaption')
  if (!modal || !modalImg || !modalCaption) return

  document.querySelectorAll('.photo img').forEach(img => {
    img.addEventListener('click', () => {
      modalImg.src = img.src
      modalCaption.textContent = img.alt
      modal.classList.add('open')
    })
  })

  modal.addEventListener('click', () => modal.classList.remove('open'))
}

function setupFormSubmission() {
  const button = document.getElementById('submitRequest')
  const nameInput = document.getElementById('name')
  const numberInput = document.getElementById('number')
  const cityInput = document.getElementById('city')
  const message = document.getElementById('formMessage')

  if (!button || !nameInput || !numberInput || !cityInput || !message) return

  button.addEventListener('click', () => {
    const name = nameInput.value.trim()
    const number = numberInput.value.trim()
    const city = cityInput.value.trim()

    if (!name || !number || !city) {
      message.textContent = state.lang === 'pt'
        ? 'Preencha o nome, o telemóvel e o destino.'
        : 'Please fill in your name, phone number and destination.'
      message.className = 'validation invalid'
      return
    }

    if (!validatePhone(number)) {
      message.textContent = state.lang === 'pt'
        ? 'Número de telemóvel inválido.'
        : 'Invalid phone number.'
      message.className = 'validation invalid'
      return
    }

    message.textContent = state.lang === 'pt'
      ? `Pedido submetido com sucesso. Obrigado, ${name}. Iremos entrar em contacto consigo em breve sobre ${city}.`
      : `Request submitted successfully. Thank you, ${name}. We will contact you soon about ${city}.`
    message.className = 'validation valid'
  })
}

document.addEventListener('DOMContentLoaded', () => {
  setupToggles()
  applyTheme(state.theme)
  applyLanguage(state.lang)
  setupVisits()
  setupNumberValidation()
  setupGalleryModal()
  setupFormSubmission()
})
