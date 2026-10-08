import Quill from "quill";
import "quill/dist/quill.snow.css";
import { toolbars } from "./toolbars";
import { imageHandler } from "./image-upload";

export function createEditor(wrapper) {
    const input = wrapper.querySelector("[data-quill-input]");
    const target = wrapper.querySelector("[data-quill-editor]");
    const { toolbar = "basic", placeholder = "", uploadUrl } = wrapper.dataset;

    const quill = new Quill(target, {
        theme: "snow",
        placeholder,
        modules: {
            toolbar: {
                container: toolbars[toolbar] ?? toolbars.basic,
                handlers: uploadUrl ? { image: null } : {}, // diisi di bawah
            },
        },
    });

    // Pasang handler upload gambar bila ada URL-nya
    if (uploadUrl) {
        quill.getModule("toolbar").addHandler("image", imageHandler(quill, uploadUrl));
    }

    // Isi konten awal dari input hidden
    if (input.value) {
        quill.setContents(quill.clipboard.convert({ html: input.value }), "silent");
    }

    // Sinkronkan ke input hidden agar ikut terkirim saat submit form
    const sync = () => {
        input.value =
            quill.getText().trim() === "" && !quill.root.querySelector("img") ? "" : quill.root.innerHTML;
        input.dispatchEvent(new Event("input", { bubbles: true }));
    };
    quill.on("text-change", sync);

    wrapper.dataset.quillReady = "true";
    wrapper.quill = quill; // akses instance: element.quill
    return quill;
}
