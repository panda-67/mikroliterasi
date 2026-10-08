export function imageHandler(quill, uploadUrl) {
    return () => {
        const input = document.createElement("input");
        input.type = "file";
        input.accept = "image/*";
        input.onchange = async () => {
            const file = input.files[0];
            if (!file) return;

            const body = new FormData();
            body.append("image", file);

            try {
                const res = await fetch(uploadUrl, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        Accept: "application/json",
                    },
                    body,
                });
                if (!res.ok) throw new Error("Upload gagal");
                const { url } = await res.json();

                const range = quill.getSelection(true);
                quill.insertEmbed(range.index, "image", url, "user");
                quill.setSelection(range.index + 1);
            } catch (e) {
                console.error(e);
                alert("Gagal mengunggah gambar.");
            }
        };
        input.click();
    };
}
