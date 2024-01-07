function showTab(tabContentId, activeTabId, ...inactiveTabIds) {
  const tabs = document.querySelectorAll(".tab");
  tabs.forEach((tab) => tab.classList.remove("border-b-2", "border-blue-200"));

  const activeTab = document.getElementById(activeTabId);
  activeTab.classList.add("border-b-2", "border-blue-200");

  inactiveTabIds.forEach((inactiveTabId) => {
    const inactiveTab = document.getElementById(inactiveTabId);
    inactiveTab.classList.remove("border-b-2", "border-blue-200");
  });

  const tabContents = document.querySelectorAll(".tab-content");
  tabContents.forEach((content) => content.classList.add("hidden"));

  const tabContent = document.getElementById(tabContentId);
  tabContent.classList.remove("hidden");
}

document.addEventListener("DOMContentLoaded", function () {
  const fatherTab = document.getElementById("fatherTab");
  const motherTab = document.getElementById("motherTab");
  const emergencyTab = document.getElementById("emergencyTab");

  fatherTab.addEventListener("click", function () {
    showTab("fatherTabContent", "fatherTab", "motherTab", "emergencyTab");
  });

  motherTab.addEventListener("click", function () {
    showTab("motherTabContent", "motherTab", "fatherTab", "emergencyTab");
  });

  emergencyTab.addEventListener("click", function () {
    showTab("emergencyTabContent", "emergencyTab", "fatherTab", "motherTab");
  });
});

function openUpdateModal() {
  var updateModal = document.getElementById("updateModal");
  updateModal.classList.remove("hidden");
}
function closeUpdateModal() {
  var updateModal = document.getElementById("updateModal");
  updateModal.classList.add("hidden");
}
window.onclick = function (event) {
  var updateModal = document.getElementById("updateModal");
  if (
    !event.target.closest("#updateModal") &&
    !event.target.matches('[onclick="openUpdateModal()"]')
  ) {
    updateModal.classList.add("hidden");
  }
};
