export async function initQuillEditors(root = document) {
    const wrappers = root.querySelectorAll("[data-quill]:not([data-quill-ready])");
    if (!wrappers.length) return; // halaman tanpa editor tidak mengunduh Quill

    const { createEditor } = await import("./create-editor.js");
    wrappers.forEach((el) => createEditor(el));
}
