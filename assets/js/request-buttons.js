// Function for TOR Modal
function openTorModal() {
  var TorModal = document.getElementById("TorModal");
  TorModal.classList.remove("hidden");
}
function closeTorModal() {
  var TorModal = document.getElementById("TorModal");
  TorModal.classList.add("hidden");
}
window.onclick = function (event) {
  var TorModal = document.getElementById("TorModal");
  if (
    !event.target.closest("#TorModal") &&
    !event.target.matches('[onclick="openTorModal()"]')
  ) {
    TorModal.classList.add("hidden");
  }
};

// Function for Good Moral Certificate Modal
function openGoodmoralModal() {
  var GoodmoralModal = document.getElementById("GoodmoralModal");
  GoodmoralModal.classList.remove("hidden");
}

function closeGoodmoralModal() {
  var GoodmoralModal = document.getElementById("GoodmoralModal");
  GoodmoralModal.classList.add("hidden");
}

window.onclick = function (event) {
  var GoodmoralModal = document.getElementById("GoodmoralModal");
  if (
    !event.target.closest("#GoodmoralModal") &&
    !event.target.matches('[onclick="openGoodmoralModal()"]')
  ) {
    GoodmoralModal.classList.add("hidden");
  }
};

// Function for Honorable Dismissal Modal
function openHonorableModal() {
  var HonorableModal = document.getElementById("HonorableModal");
  HonorableModal.classList.remove("hidden");
}

function closeHonorableModal() {
  var HonorableModal = document.getElementById("HonorableModal");
  HonorableModal.classList.add("hidden");
}

window.onclick = function (event) {
  var HonorableModal = document.getElementById("HonorableModal");
  if (
    !event.target.closest("#HonorableModal") &&
    !event.target.matches('[onclick="openHonorableModal"]')
  ) {
    HonorableModal.classList.add("hidden");
  }
};
