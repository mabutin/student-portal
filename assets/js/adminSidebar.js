function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const textElements = document.querySelectorAll('.tracking-wide');

    sidebar.classList.toggle("expanded");

    if (sidebar.classList.contains("expanded")) {
        sidebar.style.width = "240px";
        textElements.forEach(element => element.classList.remove("hidden"));
    } else {
        sidebar.style.width = "56px";
        textElements.forEach(element => element.classList.add("hidden"));
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");

    sidebar.style.width = "56px";

    sidebar.addEventListener("click", function () {
        toggleSidebar();
    });
});
