function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const textDiv = document.getElementById("textDiv");
    const dashboard = document.getElementById("dashboard");
    const accountManagement = document.getElementById("accountManagement");
    const studentInformation = document.getElementById("studentInformation");
    const enrollmentList = document.getElementById("enrollmentList");
    const faculty = document.getElementById("faculty");
    const logout = document.getElementById("logout");
    const logoContainer = document.querySelector(".logo-container");

    sidebar.classList.toggle("expanded");

    if (sidebar.classList.contains("expanded")) {
        sidebar.style.width = "240px";
        textDiv.classList.remove("hidden");
        dashboard.classList.remove("hidden"); 
        accountManagement.classList.remove("hidden");
        studentInformation.classList.remove("hidden");
        faculty.classList.remove("hidden");
        enrollmentList.classList.remove("hidden");
        logout.classList.remove("hidden");
        logoContainer.classList.add("fixed-logo");
    } else {
        sidebar.style.width = "56px";
        textDiv.classList.add("hidden");
        dashboard.classList.add("hidden"); 
        accountManagement.classList.add("hidden");
        studentInformation.classList.add("hidden");
        enrollmentList.classList.add("hidden");
        faculty.classList.add("hidden");
        logout.classList.add("hidden");
        logoContainer.classList.remove("fixed-logo");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");

    sidebar.style.width = "56px";

    sidebar.addEventListener("click", function () {
        toggleSidebar();
    });
});
