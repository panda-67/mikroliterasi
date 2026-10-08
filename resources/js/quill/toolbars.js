export const toolbars = {
    minimal: [["bold", "italic", "underline"], ["link"]],
    basic: [
        [{ header: [2, 3, false] }],
        ["bold", "italic", "underline", "strike"],
        [{ list: "ordered" }, { list: "bullet" }, { align: [] }],
        ["link", "clean"],
    ],
    full: [
        [{ header: [1, 2, 3, false] }],
        ["bold", "italic", "underline", "strike"],
        [{ color: [] }, { background: [] }],
        [{ list: "ordered" }, { list: "bullet" }, { align: [] }],
        ["blockquote", "code-block"],
        ["link", "image"],
        ["clean"],
    ],
};
