import "flowbite";
import { DataTable } from "simple-datatables";
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";
import "./bootstrap";
import "./charts";
import "./dark-mode";
import "./sidebar";

window.showLoading = function () {
    const loading = document.getElementById("loading-screen");

    if (loading) {
        loading.classList.remove("hidden");
        loading.classList.add("flex");
    }
};

window.hideLoading = function () {
    const loading = document.getElementById("loading-screen");

    if (loading) {
        loading.classList.remove("flex");
        loading.classList.add("hidden");
    }
};

// Refresh / pindah halaman / tutup tab
window.addEventListener("beforeunload", function () {
    showLoading();
});

document.addEventListener("DOMContentLoaded", () => {
    const table = document.getElementById("data-table");

    if (table) {
        new DataTable(table, {
            searchable: true,
            sortable: false,
            paging: true,

            labels: {
                placeholder: "Cari data...",
                perPage: "",
                noRows: "Data tidak ditemukan",
                info: "",
            },
        });
    }
});

new TomSelect("#fitur_ids", {
    plugins: ["remove_button"],
    placeholder: "Pilih fitur",
});
