document.addEventListener('DOMContentLoaded', () => {
const plansBtn = document.getElementById('plans-btn');
const plansMenu = document.getElementById('plans-menu');

const coreBtn = document.getElementById('core-btn');
const coreMenu = document.getElementById('core-megamenu');

const paymentBtn = document.getElementById('payment-btn');
const paymentMenu = document.getElementById('payment-menu');

const ppoBtn = document.getElementById('ppo-btn');
const ppoMenu = document.getElementById('ppo-menu');

const profileBtn = document.getElementById('profile-btn');
const profileMenu = document.getElementById('profile-menu');

const allDropdowns = [plansMenu, coreMenu, paymentMenu, ppoMenu, profileMenu];
const allButtons = [plansBtn, coreBtn, paymentBtn, ppoBtn, profileBtn];

function closeAllDropdowns() {
  for (let i = 0; i < allDropdowns.length; i++) {
    if (allDropdowns[i]) {
      allDropdowns[i].classList.remove('open');
    }
  }
  for (let i = 0; i < allButtons.length; i++) {
    if (allButtons[i]) {
      allButtons[i].setAttribute('aria-expanded', 'false');
      allButtons[i].classList.remove('active');
    }
  }
}

function toggleDropdown(btn, menu) {
  const isOpen = menu.classList.contains('open');
  closeAllDropdowns();
  if (!isOpen) {
    menu.classList.add('open');
    btn.setAttribute('aria-expanded', 'true');
    btn.classList.add('active');
  }
}

if (plansBtn && plansMenu) {
  plansBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    toggleDropdown(plansBtn, plansMenu);
  });
}

if (coreBtn && coreMenu) {
  coreBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    toggleDropdown(coreBtn, coreMenu);
  });
}

if (paymentBtn && paymentMenu) {
  paymentBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    toggleDropdown(paymentBtn, paymentMenu);
  });
}

if (ppoBtn && ppoMenu) {
  ppoBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    toggleDropdown(ppoBtn, ppoMenu);
  });
}

if (profileBtn && profileMenu) {
  profileBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    toggleDropdown(profileBtn, profileMenu);
  });
}

for (let i = 0; i < allDropdowns.length; i++) {
  if (allDropdowns[i]) {
    allDropdowns[i].addEventListener('click', function(e) {
      e.stopPropagation();
    });
  }
}

const tabCoverage = document.getElementById('tab-coverage');
const tabPharmacy = document.getElementById('tab-pharmacy');
const tabHospital = document.getElementById('tab-hospital');
const tabPhysician = document.getElementById('tab-physician');
const tabBenefits = document.getElementById('tab-benefits');

const panelCoverage = document.getElementById('panel-coverage');
const panelPharmacy = document.getElementById('panel-pharmacy');
const panelHospital = document.getElementById('panel-hospital');
const panelPhysician = document.getElementById('panel-physician');
const panelBenefits = document.getElementById('panel-benefits');

const allTabs = [tabCoverage, tabPharmacy, tabHospital, tabPhysician, tabBenefits];
const allPanels = [panelCoverage, panelPharmacy, panelHospital, panelPhysician, panelBenefits];

function switchCategory(selectedTab, selectedPanel) {
  for (let i = 0; i < allTabs.length; i++) {
    if (allTabs[i]) {
      allTabs[i].classList.remove('active');
      allTabs[i].setAttribute('aria-selected', 'false');
    }
  }
  for (let i = 0; i < allPanels.length; i++) {
    if (allPanels[i]) {
      allPanels[i].classList.remove('active');
      allPanels[i].hidden = true;
    }
  }
  if (selectedTab && selectedPanel) {
    selectedTab.classList.add('active');
    selectedTab.setAttribute('aria-selected', 'true');
    selectedPanel.classList.add('active');
    selectedPanel.hidden = false;
  }
}

if (tabCoverage) {
  tabCoverage.addEventListener('click', function() { switchCategory(tabCoverage, panelCoverage); });
  tabCoverage.addEventListener('mouseenter', function() { switchCategory(tabCoverage, panelCoverage); });
}
if (tabPharmacy) {
  tabPharmacy.addEventListener('click', function() { switchCategory(tabPharmacy, panelPharmacy); });
  tabPharmacy.addEventListener('mouseenter', function() { switchCategory(tabPharmacy, panelPharmacy); });
}
if (tabHospital) {
  tabHospital.addEventListener('click', function() { switchCategory(tabHospital, panelHospital); });
  tabHospital.addEventListener('mouseenter', function() { switchCategory(tabHospital, panelHospital); });
}
if (tabPhysician) {
  tabPhysician.addEventListener('click', function() { switchCategory(tabPhysician, panelPhysician); });
  tabPhysician.addEventListener('mouseenter', function() { switchCategory(tabPhysician, panelPhysician); });
}
if (tabBenefits) {
  tabBenefits.addEventListener('click', function() { switchCategory(tabBenefits, panelBenefits); });
  tabBenefits.addEventListener('mouseenter', function() { switchCategory(tabBenefits, panelBenefits); });
}

document.addEventListener('click', function(e) {
  if (!e.target.closest('.has-dropdown')) {
    closeAllDropdowns();
  }
});

const hamburgerBtn = document.getElementById('hamburger-btn');
const mobileDrawer = document.getElementById('mobile-nav-drawer');
const mobileOverlay = document.getElementById('mobile-overlay');
const mobileCloseBtn = document.getElementById('mobile-close-btn');

function openDrawer() {
  if (mobileDrawer && mobileOverlay && hamburgerBtn) {
    mobileDrawer.classList.add('active');
    mobileOverlay.classList.add('active');
    hamburgerBtn.setAttribute('aria-expanded', 'true');
    document.body.classList.add('drawer-open');
  }
}

function closeDrawer() {
  if (mobileDrawer && mobileOverlay && hamburgerBtn) {
    mobileDrawer.classList.remove('active');
    mobileOverlay.classList.remove('active');
    hamburgerBtn.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('drawer-open');
  }
}

if (hamburgerBtn) {
  hamburgerBtn.addEventListener('click', function() {
    if (mobileDrawer && mobileDrawer.classList.contains('active')) {
      closeDrawer();
    } else {
      openDrawer();
    }
  });
}

if (mobileCloseBtn) {
  mobileCloseBtn.addEventListener('click', closeDrawer);
}

if (mobileOverlay) {
  mobileOverlay.addEventListener('click', closeDrawer);
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' || e.key === 'Esc') {
    closeAllDropdowns();
    closeDrawer();
  }
});

const mPlansTrigger = document.getElementById('m-plans-trigger');
const mPlansContent = document.getElementById('m-plans-content');
const mCoreTrigger = document.getElementById('m-core-trigger');
const mCoreContent = document.getElementById('m-core-content');
const mPaymentTrigger = document.getElementById('m-payment-trigger');
const mPaymentContent = document.getElementById('m-payment-content');
const mPpoTrigger = document.getElementById('m-ppo-trigger');
const mPpoContent = document.getElementById('m-ppo-content');
const mProfileTrigger = document.getElementById('m-profile-trigger');
const mProfileContent = document.getElementById('m-profile-content');

function toggleMobileAccordion(trigger, content) {
  if (!trigger || !content) return;
  const isClosed = content.hidden;
  content.hidden = !isClosed;
  trigger.setAttribute('aria-expanded', isClosed ? 'true' : 'false');
}

if (mPlansTrigger) {
  mPlansTrigger.addEventListener('click', function() {
    toggleMobileAccordion(mPlansTrigger, mPlansContent);
  });
}
if (mCoreTrigger) {
  mCoreTrigger.addEventListener('click', function() {
    toggleMobileAccordion(mCoreTrigger, mCoreContent);
  });
}
if (mPaymentTrigger) {
  mPaymentTrigger.addEventListener('click', function() {
    toggleMobileAccordion(mPaymentTrigger, mPaymentContent);
  });
}
if (mPpoTrigger) {
  mPpoTrigger.addEventListener('click', function() {
    toggleMobileAccordion(mPpoTrigger, mPpoContent);
  });
}
if (mProfileTrigger) {
  mProfileTrigger.addEventListener('click', function() {
    toggleMobileAccordion(mProfileTrigger, mProfileContent);
  });
}

const nestedTriggers = document.querySelectorAll('.nested-trigger');
for (let i = 0; i < nestedTriggers.length; i++) {
  nestedTriggers[i].addEventListener('click', function() {
    const panel = this.nextElementSibling;
    if (panel) {
      const isClosed = panel.hidden;
      panel.hidden = !isClosed;
      this.setAttribute('aria-expanded', isClosed ? 'true' : 'false');
    }
  });
}

const mobileLinks = document.querySelectorAll('.mobile-nav-drawer a');
for (let i = 0; i < mobileLinks.length; i++) {
  mobileLinks[i].addEventListener('click', function() {
    closeDrawer();
  });
}

const filterChips = document.querySelectorAll('.filter-chip');
for (let i = 0; i < filterChips.length; i++) {
  filterChips[i].addEventListener('click', function() {
    for (let j = 0; j < filterChips.length; j++) {
      filterChips[j].classList.remove('active');
    }
    this.classList.add('active');
  });
}

window.addEventListener('resize', function() {
  if (window.innerWidth >= 1024) {
    closeDrawer();
  } else {
    closeAllDropdowns();
  }
});
});
